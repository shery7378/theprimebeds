<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\MerchantProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    /**
     * Display the merchant dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        $activeProductsCount = $user->is_merchant ? $user->merchantProducts()->where('is_active', true)->count() : 0;
        $totalEarnings = $user->earnings_balance;

        return view('user.merchant.dashboard', compact('activeProductsCount', 'totalEarnings', 'user'));
    }

    /**
     * Allow user to become a merchant.
     */
    public function becomeMerchant(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255|unique:users,store_name',
        ]);

        $user = Auth::user();
        $user->is_merchant = true;
        // Clean store name for URL friendliness
        $user->store_name = Str::slug($request->store_name);
        $user->save();

        return redirect()->route('user.merchant.dashboard')->with('success', __('You are now a merchant!'));
    }

    /**
     * Show catalog of products available to sell.
     */
    public function catalog()
    {
        $user = Auth::user();
        if (!$user->is_merchant) return redirect()->route('user.merchant.dashboard');

        // Get all active items
        $items = Item::where('status', 1)->paginate(15);
        $merchantProducts = $user->merchantProducts()->pluck('merchant_price', 'item_id')->toArray();

        return view('user.merchant.catalog', compact('items', 'merchantProducts'));
    }

    /**
     * Show products the merchant has added to their store.
     */
    public function myProducts()
    {
        $user = Auth::user();
        if (!$user->is_merchant) return redirect()->route('user.merchant.dashboard');

        $merchantProducts = $user->merchantProducts()->with('item')->paginate(15);

        return view('user.merchant.my_products', compact('merchantProducts', 'user'));
    }

    /**
     * Add or update pricing for a product.
     */
    public function addOrUpdateProduct(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_merchant) return redirect()->back();

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'merchant_price' => 'required|numeric|min:0',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Optional: Ensure merchant price is not lower than base price if we want to ensure profit,
        // or let them sell at a loss if they want? Let's ensure it's greater than or equal to the discount_price or purchase_price.
        $basePrice = $item->purchase_price > 0 ? $item->purchase_price : $item->discount_price;

        if ($request->merchant_price < $basePrice) {
            return redirect()->back()->with('error', __('Merchant price cannot be lower than the base price of ') . \PriceHelper::setPrice($basePrice));
        }

        $merchantProduct = MerchantProduct::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item->id],
            ['merchant_price' => $request->merchant_price, 'is_active' => false, 'status' => 'pending']
        );

        return redirect()->back()->with('success', __('Price proposal submitted! It will go live once approved by the admin.'));
    }

    /**
     * Remove product from store.
     */
    public function removeProduct($id)
    {
        $user = Auth::user();
        $merchantProduct = MerchantProduct::where('user_id', $user->id)->where('item_id', $id)->firstOrFail();
        $merchantProduct->delete();

        return redirect()->back()->with('success', __('Product removed from your store.'));
    }
}
