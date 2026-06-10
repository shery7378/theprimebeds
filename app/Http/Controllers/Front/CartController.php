<?php

namespace App\Http\Controllers\Front;

use App\{
    Models\Item,
    Http\Controllers\Controller,
    Repositories\Front\CartRepository
};
use App\Helpers\PriceHelper;
use App\Models\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Constructor Method.
     *
     * @param  \App\Repositories\Front\CartRepository $repository
     *
     */
    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('localize');
    }

    public function index()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        } else {
            $cart = [];
        }
        return view('front.catalog.cart', [
            'cart' => $cart
        ]);
    }


    public function addToCart(Request $request)
    {
        $msg = $this->repository->store($request);


        if ($request->ajax()) {
            if (!empty($msg['buystatus']) && $msg['buystatus'] === "true") {
                $msg['redirect'] = route('front.cart');
            }

            return $msg;
        }
    }

    public function store(Request $request)
    {

        $msg = $this->repository->store($request);
        if (isset($request->addtocart)) {
            Session::flash('success_message', __('Cart Added Successfully'));
            return back();
        }
        return redirect()->route('front.checkout.billing')->withSuccess($msg);
    }

    public function destroy($id)
    {

        $cart = Session::get('cart');
        unset($cart[$id]);
        if (count($cart) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        Session::flash('success', __('Cart item remove successfully.'));
        return back();
    }

    public function promoStore(Request $request)
    {
        return response()->json($this->repository->promoStore($request));
    }

    public function shippingStore(Request $request)
    {
        return redirect()->route('front.checkout');
    }


    public function update($id)
    {
        return view('front.catalog.cart_form', [
            'item' => Item::findOrFail($id),
            'attributes' => Item::findOrFail($id)->attributes,
            'cart_item' => Session::get('cart')[$id],
        ]);
    }


    public function shippingCharge(Request $request)
    {

        $charges = [];
        $items = [];
        foreach ($request->user_id as $data) {
            $check = explode('|', $data);
            $charges[] = $check[0];
            $items[] = $check[1];
        }
        $cart = Session::get('cart');
        $delivery_amount = 0;
        foreach ($charges as $index => $charge) {
            if ($charge != 0) {
                $vendor_charge = Item::findOrFail($items[$index])->user->shipping->price;
                $delivery_amount += $vendor_charge;
                $cart[$items[$index]]['delivery_charge'] = $vendor_charge;
            } else {
                $cart[$items[$index]]['delivery_charge'] = 0;
            }
        }

        Session::put('cart', $cart);

        return response()->json(['delivery' => PriceHelper::setPrice($delivery_amount), 'main' => $delivery_amount]);
    }


    public function headerCartLoad()
    {
        return view('includes.header_cart');
    }
    public function CartLoad()
    {
        return view('includes.cart');
    }

    public function cartClear()
    {
        Session::forget('cart');
        Session::flash('success', __('Cart clear successfully'));
        return back();
    }

    public function promoDelete()
    {
        Session::forget('coupon');
        Session::flash('success', __('Promo code remove successfully'));
        return back();
    }

    /** 
     * update preferences
     * 
     * */

    public function updatePreferences(Request $request)
    {
        // dd(ini_get('upload_max_filesize'), ini_get('post_max_size'));

        $cart = Session::has('cart') ? Session::get('cart') : [];
        $orderId = $request->input('order_id');

        if (!isset($cart[$orderId])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ]);
        }

        $item = $cart[$orderId];

        // Ensure we only start with existing image paths
        $existingImages = json_decode($item['sample_image'] ?? '[]', true);
        $allImages = is_array($existingImages) ? $existingImages : [];

        $uploadPath = public_path('assets/preferences');

        // Process old images if re-uploaded
        if ($request->hasFile('old_sample_images')) {
            foreach ($request->file('old_sample_images') as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $originalName = str_replace(' ', '', $file->getClientOriginalName());

                    // Avoid duplication
                    $isDuplicate = collect($allImages)->contains(function ($existing) use ($originalName) {
                        return str_ends_with($existing, $originalName);
                    });

                    if (!$isDuplicate) {
                        $name = time() . '_' . uniqid() . '_' . $originalName;
                        $file->move($uploadPath, $name);
                        $allImages[] = $name; // store only filename
                    }
                }
            }
        }

        // Process new images
        if ($request->hasFile('new_sample_images')) {
            foreach ($request->file('new_sample_images') as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $originalName = str_replace(' ', '', $file->getClientOriginalName());

                    $isDuplicate = collect($allImages)->contains(function ($existing) use ($originalName) {
                        return str_ends_with($existing, $originalName);
                    });

                    if (!$isDuplicate) {
                        $name = time() . '_' . uniqid() . '_' . $originalName;
                        $file->move($uploadPath, $name);
                        $allImages[] = $name; // store only filename
                    }
                }
            }
        }

        // Update the session-safe item
        $item['sample_image'] = json_encode(array_values($allImages)); // only filenames
        $item['preference_description'] = $request->input('preference_description');

        // Just in case: Remove any accidental UploadedFile objects
        foreach ($item as $key => $val) {
            if ($val instanceof \Illuminate\Http\UploadedFile) {
                unset($item[$key]);
            }
        }

        // Save back to cart in session
        $cart[$orderId] = $item;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'images' => collect($allImages)->map(fn($img) => asset('assets/preferences/' . $img))
        ]);
    }

    public function removeImage(Request $request)
    {
        $filename = $request->input('filename');
        $orderId = $request->input('order_id');

        if (!$filename || !$orderId) {
            return response()->json(['success' => false, 'message' => 'Filename or order_id is missing']);
        }

        $cart = Session::has('cart') ? Session::get('cart') : [];
        if (!isset($cart[$orderId])) {
            return response()->json(['success' => false, 'message' => 'Cart item not found']);
        }

        $item = $cart[$orderId];
        $images = json_decode($item['sample_image'] ?? '[]', true);
        if (!is_array($images)) $images = [];

        if (($key = array_search($filename, $images)) !== false) {
            unset($images[$key]);
            $item['sample_image'] = json_encode(array_values($images)); // Reindex
            $cart[$orderId] = $item;
            Session::put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image not found in cart item']);
    }
}
