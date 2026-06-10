<?php

namespace App\Http\Controllers\Back;

use App\{
    Models\Order,
    Models\PromoCode,
    Models\TrackOrder,
    Http\Controllers\Controller,
};
use App\Helpers\SmsHelper;
use App\Mail\CollectOrderMail;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderDeliveredMail;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     */
    public function __construct()
    {
        $this->middleware("auth:admin");
        $this->middleware("adminlocalize");
        $this->middleware("permissions:Update Orders")->only([
            "edit",
            "update",
            "status",
            "preference",
            "orderDispatchDetails",
            "showDispatchView",
        ]);
        $this->middleware("permissions:Delete Orders")->only(["delete"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type) {
            if ($request->start_date && $request->end_date) {
                $datas = $start_date = Carbon::parse($request->start_date);
                $end_date = Carbon::parse($request->end_date);
                $datas = Order::latest("id")
                    ->whereOrderStatus($request->type)
                    ->whereDate("created_at", ">=", $start_date)
                    ->whereDate("created_at", "<=", $end_date)
                    ->get();
            } else {
                $datas = Order::latest("id")
                    ->whereOrderStatus($request->type)
                    ->get();
            }
        } else {
            if ($request->start_date && $request->end_date) {
                $datas = $start_date = Carbon::parse($request->start_date);
                $end_date = Carbon::parse($request->end_date);
                $datas = Order::latest("id")
                    ->whereDate("created_at", ">=", $start_date)
                    ->whereDate("created_at", "<=", $end_date)
                    ->get();
            } else {
                $datas = Order::latest("id")->get();
            }
        }
        return view("back.order.index", compact("datas"));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view("back.order.edit", compact("order"));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Check if order_id is available
        if (
            Order::where("transaction_number", $request->transaction_number)
                ->where("id", "!=", $id)
                ->exists()
        ) {
            return redirect()
                ->route("back.order.index")
                ->withErrors(__("Order ID already exists."));
        }

        $order->update($request->all());
        return redirect()
            ->route("back.order.index")
            ->withSuccess(__("Order Updated Successfully."));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $order = Order::findOrfail($id);
        $cart = json_decode($order->cart, true);
        return view("back.order.invoice", compact("order", "cart"));
    }

    //Display the order preference is provided
    public function preference($id)
    {
        $order = Order::findOrfail($id);
        $cart = array_filter(json_decode($order->cart, true), function ($item) {
            return !empty($item["sample_image"]) ||
                !empty($item["preference_description"]);
        });

        return view("back.order.preferences", compact("order", "cart"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printOrder($id)
    {
        $order = Order::findOrfail($id);
        $cart = json_decode($order->cart, true);
        return view("back.order.print", compact("order", "cart"));
    }

    /**
     * Change the status for editing the specified resource.
     *
     * @param  int  $id
     * @param  string  $field
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */
    public function status($id, $field, $value)
    {
        $order = Order::find($id);
        $Orderid = $id;
        if ($field == "payment_status") {
            if ($order["payment_status"] == "Paid") {
                return redirect()
                    ->route("back.order.index")
                    ->withErrors(__("Order is already paid."));
            }
        }
        if ($field == "order_status") {
            if ($order["order_status"] == "Delivered") {
                return redirect()
                    ->route("back.order.index")
                    ->withErrors(__("Order is already Delivered."));
            }
        }
        $order->update([$field => $value]);
        if ($order->payment_status == "Paid") {
            $this->setPromoCode($order);
        }

        if ($field == "order_status") {
            if ($value === "Canceled") {
                $shippping_info = json_decode($order->shipping_info, true);
                $cart = json_decode($order->cart, true);
                Mail::to($shippping_info["ship_email"])->send(
                    new OrderCancelledMail($shippping_info, $cart, $order),
                );
            }
        }

        if ($field == "order_status") {
            if ($value === "Delivered") {
                $delivery = json_decode($order->shipping, true);

                if (isset($delivery)) {
                    if (
                        $delivery["title"] === "collect" ||
                        $delivery["title"] === "Delivery"
                    ) {
                        $deliveryType = $delivery["title"];
                        return redirect()->route("back.dispatch.view", [
                            "order_id" => $Orderid,
                            "deliveryType" => $deliveryType,
                            "order_number" => $order->transaction_number,
                        ]);
                    }
                }
            }
        }

        $this->setTrackOrder($order);

        $sms = new SmsHelper();
        $user_number = $order->user->phone;
        if ($user_number) {
            $sms->SendSms(
                $user_number,
                "'order_status'",
                $order->transaction_number,
            );
        }

        return redirect()
            ->route("back.order.index")
            ->withSuccess(__("Status Updated Successfully."));
    }

    /**
     * Custom Function
     */
    public function setTrackOrder($order)
    {
        if ($order->order_status == "In Progress") {
            if (
                !TrackOrder::whereOrderId($order->id)
                    ->whereTitle("In Progress")
                    ->exists()
            ) {
                TrackOrder::create([
                    "title" => "In Progress",
                    "order_id" => $order->id,
                ]);
            }
        }
        if ($order->order_status == "Canceled") {
            if (
                !TrackOrder::whereOrderId($order->id)
                    ->whereTitle("Canceled")
                    ->exists()
            ) {
                if (
                    !TrackOrder::whereOrderId($order->id)
                        ->whereTitle("In Progress")
                        ->exists()
                ) {
                    TrackOrder::create([
                        "title" => "In Progress",
                        "order_id" => $order->id,
                    ]);
                }
                if (
                    !TrackOrder::whereOrderId($order->id)
                        ->whereTitle("Delivered")
                        ->exists()
                ) {
                    TrackOrder::create([
                        "title" => "Delivered",
                        "order_id" => $order->id,
                    ]);
                }

                if (
                    !TrackOrder::whereOrderId($order->id)
                        ->whereTitle("Canceled")
                        ->exists()
                ) {
                    TrackOrder::create([
                        "title" => "Canceled",
                        "order_id" => $order->id,
                    ]);
                }
            }
        }

        if ($order->order_status == "Delivered") {
            if (
                !TrackOrder::whereOrderId($order->id)
                    ->whereTitle("In Progress")
                    ->exists()
            ) {
                TrackOrder::create([
                    "title" => "In Progress",
                    "order_id" => $order->id,
                ]);
            }

            if (
                !TrackOrder::whereOrderId($order->id)
                    ->whereTitle("Delivered")
                    ->exists()
            ) {
                TrackOrder::create([
                    "title" => "Delivered",
                    "order_id" => $order->id,
                ]);
            }
        }
    }

    public function setPromoCode($order)
    {
        $discount = json_decode($order->discount, true);
        if ($discount != null) {
            $code = PromoCode::find($discount["code"]["id"]);
            $code->no_of_times--;
            $code->update();
        }
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->tranaction->delete();
        if (Notification::where("order_id", $id)->exists()) {
            Notification::where("order_id", $id)->delete();
        }
        if (count($order->tracks_data) > 0) {
            foreach ($order->tracks_data as $track) {
                $track->delete();
            }
        }
        $order->delete();
        return redirect()
            ->back()
            ->withSuccess(__("Order Deleted Successfully."));
    }

    /**
     *
     * Dispatching Order Details
     */

    public function orderDispatchDetails(Request $request)
    {
        if ($request->delivery_type === "collect") {
            $request->validate([
                "order_number" => "required",
                "pickup_location" => "required",
                "opening_hours" => "required",
                "contact_number" => "required",
            ]);
        } else {
            $request->validate([
                "courier_name" => "required",
                "tracking_number" => "required",
                "tracking_link" => "required",
                "delivery_date" => "required",
            ]);
        }

        $order = Order::find($request->order);
        $this->setTrackOrder($order);
        if ($request->delivery_type === "collect") {
            $DispatchDetail = [
                "order_number" => $request->order_number,
                "pickup_location" => $request->pickup_location,
                "opening_hours" => $request->opening_hours,
                "contact_number" => $request->contact_number,
            ];
        } else {
            $DispatchDetail = [
                "courier_name" => $request->courier_name,
                "tracking_number" => $request->tracking_number,
                "tracking_link" => $request->tracking_link,
                "delivery_date" => $request->delivery_date,
            ];
        }

        $shipping_info = json_decode($order->shipping_info, true);
        $cart = json_decode($order->cart, true);
        if ($request->delivery_type === "collect") {
            Mail::to($shipping_info["ship_email"])->send(
                new CollectOrderMail(
                    $shipping_info,
                    $cart,
                    $DispatchDetail,
                    $order,
                ),
            );
        } else {
            Mail::to($shipping_info["ship_email"])->send(
                new OrderDeliveredMail(
                    $shipping_info,
                    $cart,
                    $DispatchDetail,
                    $order,
                ),
            );
        }
        $sms = new SmsHelper();
        $user_number = $order->user->phone;
        if ($user_number) {
            $sms->SendSms(
                $user_number,
                "'order_status'",
                $order->transaction_number,
            );
        }
        return redirect()
            ->route("back.order.index")
            ->withSuccess(__("Delivered Successfully."));
    }

    public function showDispatchView($Orderid, $deliveryType, $order_number)
    {
        return view(
            "back.dispatch",
            compact("Orderid", "deliveryType", "order_number"),
        );
    }
}
