<?php

namespace App\Http\Controllers\Back;

use Auth;

use App\{
    Http\Controllers\Controller,
    Http\Requests\ImageUpdateRequest,
    Repositories\Back\AccountRepository
};
use App\Helpers\PriceHelper;
use App\Models\Item;
use App\Models\Order;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param  \App\Repositories\Back\AccountRepository $repository
     *
     */
    public function __construct(AccountRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->role && strtolower($admin->role->name) == 'merchant') {
            $user = \App\Models\User::where('email', $admin->email)->first();
            if ($user) {
                $merchantProductIds = \App\Models\MerchantProduct::where('user_id', $user->id)->pluck('item_id')->toArray();
                
                // Get all orders containing merchant products
                $allOrders = Order::all()->filter(function($order) use ($merchantProductIds) {
                    $cart = json_decode($order->cart, true);
                    if (!$cart) return false;
                    foreach ($cart as $key => $item) {
                        $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                        if (in_array($itemId, $merchantProductIds)) {
                            return true;
                        }
                    }
                    return false;
                });

                $deliveredOrders = $allOrders->where('order_status', 'Delivered');
                $todayOrders = $allOrders->filter(function($order) {
                    return \Carbon\Carbon::parse($order->created_at)->isToday();
                });
                $monthOrders = $deliveredOrders->filter(function($order) {
                    return \Carbon\Carbon::parse($order->created_at)->isCurrentMonth();
                });
                $yearOrders = $deliveredOrders->filter(function($order) {
                    return \Carbon\Carbon::parse($order->created_at)->gt(\Carbon\Carbon::now()->subDays(365));
                });

                // Calculate product sales quantities
                $totalProductSale = 0;
                foreach ($deliveredOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $totalProductSale += $item['qty'] ?? 1;
                            }
                        }
                    }
                }

                $totalTodayProductSale = 0;
                foreach ($todayOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $totalTodayProductSale += $item['qty'] ?? 1;
                            }
                        }
                    }
                }

                $totalCurrentMonthProductSale = 0;
                foreach ($monthOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $totalCurrentMonthProductSale += $item['qty'] ?? 1;
                            }
                        }
                    }
                }

                $totalLatYearProductSale = 0;
                foreach ($yearOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $totalLatYearProductSale += $item['qty'] ?? 1;
                            }
                        }
                    }
                }

                // Calculate merchant earnings
                $totalEarningVal = 0;
                foreach ($deliveredOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $mProduct = \App\Models\MerchantProduct::where('user_id', $user->id)->where('item_id', $itemId)->first();
                                if ($mProduct) {
                                    $totalEarningVal += $mProduct->merchant_price * ($item['qty'] ?? 1);
                                }
                            }
                        }
                    }
                }

                $totalTodayEarningVal = 0;
                foreach ($todayOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $mProduct = \App\Models\MerchantProduct::where('user_id', $user->id)->where('item_id', $itemId)->first();
                                if ($mProduct) {
                                    $totalTodayEarningVal += $mProduct->merchant_price * ($item['qty'] ?? 1);
                                }
                            }
                        }
                    }
                }

                $totalMonthEarningVal = 0;
                foreach ($monthOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $mProduct = \App\Models\MerchantProduct::where('user_id', $user->id)->where('item_id', $itemId)->first();
                                if ($mProduct) {
                                    $totalMonthEarningVal += $mProduct->merchant_price * ($item['qty'] ?? 1);
                                }
                            }
                        }
                    }
                }

                $totalYearEarningVal = 0;
                foreach ($yearOrders as $order) {
                    $cart = json_decode($order->cart, true);
                    if ($cart) {
                        foreach ($cart as $key => $item) {
                            $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                            if (in_array($itemId, $merchantProductIds)) {
                                $mProduct = \App\Models\MerchantProduct::where('user_id', $user->id)->where('item_id', $itemId)->first();
                                if ($mProduct) {
                                    $totalYearEarningVal += $mProduct->merchant_price * ($item['qty'] ?? 1);
                                }
                            }
                        }
                    }
                }

                $curr = \App\Models\Currency::where('is_default', 1)->first();
                $setting = \App\Models\Setting::first();
                if ($setting->currency_direction == 1) {
                    $totalEarning = $curr->sign . $totalEarningVal;
                    $totalTodayEarning = $curr->sign . $totalTodayEarningVal;
                    $totalMonthEarning = $curr->sign . $totalMonthEarningVal;
                    $totalYearEarning = $curr->sign . $totalYearEarningVal;
                } else {
                    $totalEarning = $totalEarningVal . $curr->sign;
                    $totalTodayEarning = $totalTodayEarningVal . $curr->sign;
                    $totalMonthEarning = $totalMonthEarningVal . $curr->sign;
                    $totalYearEarning = $totalYearEarningVal . $curr->sign;
                }

                // Chart Days
                $days = "";
                $sales = "";
                $earning_days = "";
                $total_incomess = "";
                for ($i = 0; $i < 30; $i++) {
                    $dayStr = date("d M", strtotime('-'. $i .' days'));
                    $dateStr = date("Y-m-d", strtotime('-'. $i .' days'));
                    
                    $days .= "'".$dayStr."',";
                    $earning_days .= "'".$dayStr."',";
                    
                    $dayOrders = $allOrders->filter(function($order) use ($dateStr) {
                        return date("Y-m-d", strtotime($order->created_at)) == $dateStr;
                    });
                    
                    $sales .= "'".$dayOrders->count()."',";
                    
                    $dayEarnings = 0;
                    foreach ($dayOrders->where('order_status', 'Delivered') as $order) {
                        $cart = json_decode($order->cart, true);
                        if ($cart) {
                            foreach ($cart as $key => $item) {
                                $itemId = \App\Helpers\PriceHelper::GetItemId($key);
                                if (in_array($itemId, $merchantProductIds)) {
                                    $mProduct = \App\Models\MerchantProduct::where('user_id', $user->id)->where('item_id', $itemId)->first();
                                    if ($mProduct) {
                                        $dayEarnings += $mProduct->merchant_price * ($item['qty'] ?? 1);
                                    }
                                }
                            }
                        }
                    }
                    $total_incomess .= "'".$dayEarnings."',";
                }
                $days = rtrim($days, ", ");
                $earning_days = rtrim($earning_days, ", ");
                $sales = rtrim($sales, ", ");
                $check_income = rtrim($total_incomess, ", ");

                return view('back.dashboard.index', [
                    'totalUsers' => 0,
                    'totalItems' => \App\Models\MerchantProduct::where('user_id', $user->id)->count(),
                    'totalOrders' => $allOrders->count(),
                    'totalPendingOrders' => $allOrders->where('order_status', 'Pending')->count(),
                    'totalDeliveredOrders' => $allOrders->where('order_status', 'Delivered')->count(),
                    'totalCanceledOrders' => $allOrders->where('order_status', 'Canceled')->count(),
                    'recentUsers' => collect([]),
                    'recentOrders' => $allOrders->sortByDesc('id')->take(10),
                    'totalBrand' => 0,
                    'totalCategory' => 0,
                    'totalReview' => 0,
                    'totalTransaction' => 0,
                    'totalPendingTicket' => 0,
                    'totalTicket' => 0,
                    'totalBlog' => 0,
                    'totalSubscriber' => 0,
                    'totalProductSale' => $totalProductSale,
                    'totalCurrentMonthProductSale' => $totalCurrentMonthProductSale,
                    'totalTodayProductSale' => $totalTodayProductSale,
                    'totalLatYearProductSale' => $totalLatYearProductSale,
                    'totalEarning' => $totalEarning,
                    'totalTodayEarning' => $totalTodayEarning,
                    'totalMonthEarning' => $totalMonthEarning,
                    'totalYearEarning' => $totalYearEarning,
                    'totalSystemUserEarning' => 0,
                    'order_days' => $days,
                    'earning_days' => $earning_days,
                    'order_sales' => $sales,
                    'total_incomess' => $check_income,
                ]);
            }
        }

        $days = "";
        $sales = "";
        for($i = 0; $i < 30; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";
            $sales .=  "'".Order::where('order_status','=','Delivered')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }


        $earning_days = "";
        $total_incomess = '';
        $income = "";
        $check = 0;
        for($i = 0; $i < 30; $i++) {
            $earning_days .= "'".date("d M", strtotime('-'. $i .' days'))."',";
            $incomes = Order::where('order_status','=','Delivered')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->get();

            if($incomes->count() > 0){
                foreach($incomes as $income){
                    $check += PriceHelper::OrderTotalChart($income);
                }
                $total_incomess .=  "'".$check."',";
            }else{
                $total_incomess .=  "'".'0'."',";
            }
        }

        $earning_days =rtrim($earning_days, ", ");
        $check_income =rtrim($total_incomess, ", ");

        return view('back.dashboard.index',[
            'totalUsers' => $this->repository->getTotalUsers(),
            'totalItems' => $this->repository->getTotalItems(),
            'totalOrders' => $this->repository->getTotalOrders(),
            'totalPendingOrders' => $this->repository->getPendingOrders(),
            'totalDeliveredOrders' => $this->repository->getDeliveredOrders(),
            'totalCanceledOrders' => $this->repository->getCanceledOrders(),
            'recentUsers' => $this->repository->getRecentUsers(),
            'recentOrders' => $this->repository->getRecentOrders(),
            'totalBrand' => $this->repository->getTotalBrand(),
            'totalCategory' => $this->repository->getTotalCategory(),
            'totalReview' => $this->repository->getTotalReview(),
            'totalTransaction' => $this->repository->getTotalTransaction(),
            'totalPendingTicket' => $this->repository->getTotalPendingTicket(),
            'totalTicket' => $this->repository->getTotalTicket(),
            'totalBlog' => $this->repository->getTotalBlog(),
            'totalSubscriber' => $this->repository->getTotalSubscriber(),
            'totalProductSale' => $this->repository->getTotalProductSale(),
            'totalCurrentMonthProductSale' => $this->repository->getcurrentMonthProductSale(),
            'totalTodayProductSale' => $this->repository->getTodayProductSale(),
            'totalLatYearProductSale' => $this->repository->getYearProductSale(),
            'totalEarning' => $this->repository->getTotalEarning(),
            'totalTodayEarning' => $this->repository->getTodayEarning(),
            'totalMonthEarning' => $this->repository->getMonthEarning(),
            'totalYearEarning' => $this->repository->getYearEarning(),
            'totalSystemUserEarning' => $this->repository->getSystemUser(),
            'order_days' => $days,
            'earning_days' => $earning_days,
            'order_sales' => $sales,
            'total_incomess' => $check_income,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileForm()
    {
        $data = Auth::guard('admin')->user();
        return view('back.dashboard.profile',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(ImageUpdateRequest $request)
    {
        $this->repository->updateProfile($request);
        return redirect()->back()->withSuccess(__('Profile Updated Successfully!'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function passwordResetForm()
    {
        return view('back.dashboard.password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:4|max:16',
            'new_password' => 'required|min:4|max:16',
            'renew_password' => 'required|min:4|max:16',
        ]);

        $resp = $this->repository->updatePassword($request);

        if($resp['status']){
            return redirect()->back()->withSuccess($resp['message']);
        }else{
            return redirect()->back()->withErrors($resp['message']);
        }

    }

}
