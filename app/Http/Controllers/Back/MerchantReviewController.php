<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\MerchantPayout;
use App\Models\MerchantProduct;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
        $this->middleware("adminlocalize");
        $this->middleware("permissions:Manage Merchants")->only([
            "index",
            "payouts",
            "payoutHistory",
        ]);
        $this->middleware("permissions:Update Merchants")->only([
            "pay",
        ]);
        $this->middleware("permissions:Manage Merchant Pricing")->only([
            "pendingPrices",
            "productPricing",
            "submitPrice",
            "deletePrice",
            "allProposals",
        ]);
        $this->middleware("permissions:Update Merchant Pricing")->only([
            "approve",
        ]);
        $this->middleware("permissions:Delete Merchant Pricing")->only([
            "reject",
        ]);
    }

    /**
     * List all registered merchants.
     */
    public function index()
    {
        $merchants = User::where('is_merchant', true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('back.merchant.index', compact('merchants'));
    }

    /**
     * List all pending merchant price proposals.
     */
    public function pendingPrices()
    {
        $query = MerchantProduct::with(['user', 'item'])
            ->where('status', 'pending')
            ->latest();

        $admin = Auth::guard('admin')->user();
        if ($admin->role && strtolower($admin->role->name) == 'merchant') {
            $user = User::where('email', $admin->email)->first();
            if ($user) {
                $query->where('user_id', $user->id);
            } else {
                $query->where('user_id', 0);
            }
        }

        $pendingProducts = $query->paginate(20);

        return view('back.merchant.pending_prices', compact('pendingProducts'));
    }

    /**
     * Approve a merchant product price.
     */
    public function approve($id)
    {
        $merchantProduct = MerchantProduct::findOrFail($id);
        $merchantProduct->status = 'approved';
        $merchantProduct->is_active = true;
        $merchantProduct->save();

        return redirect()->back()->with('success', __('Price approved and product is now live on the merchant storefront.'));
    }

    /**
     * Reject a merchant product price.
     */
    public function reject($id)
    {
        $merchantProduct = MerchantProduct::findOrFail($id);
        $merchantProduct->status = 'rejected';
        $merchantProduct->is_active = false;
        $merchantProduct->save();

        return redirect()->back()->with('success', __('Price proposal rejected.'));
    }

    /**
     * List all merchants with their earnings balance.
     */
    public function payouts()
    {
        $merchants = User::where('is_merchant', true)
            ->orderByDesc('earnings_balance')
            ->paginate(20);

        return view('back.merchant.payouts', compact('merchants'));
    }

    /**
     * Process a manual payout for a merchant.
     */
    public function pay(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'amount'   => 'required|numeric|min:0.01',
            'note'     => 'nullable|string|max:255',
        ]);

        $merchant = User::findOrFail($request->user_id);

        if ($request->amount > $merchant->earnings_balance) {
            return redirect()->back()->with('error', __('Payout amount exceeds the merchant\'s current earnings balance.'));
        }

        // Deduct from balance
        $merchant->earnings_balance -= $request->amount;
        $merchant->save();

        // Record payout history
        MerchantPayout::create([
            'user_id'  => $merchant->id,
            'admin_id' => Auth::guard('admin')->id(),
            'amount'   => $request->amount,
            'note'     => $request->note,
        ]);

        return redirect()->back()->with('success', __('Payout of ') . number_format($request->amount, 2) . __(' processed successfully.'));
    }

    /**
     * Show payout history for a specific merchant.
     */
    public function payoutHistory($userId)
    {
        $merchant = User::findOrFail($userId);
        $history  = MerchantPayout::where('user_id', $userId)->latest()->paginate(20);

        return view('back.merchant.payout_history', compact('merchant', 'history'));
    }

    /**
     * Show products catalog and allow merchant to submit prices.
     */
    public function productPricing(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Find corresponding user
        $user = User::where('email', $admin->email)->first();
        if (!$user || !$user->is_merchant) {
            return redirect()->route('back.dashboard')->with('error', __('Only merchants can manage product pricing.'));
        }

        // Get all items/products in the system (available for pricing)
        $query = Item::where('status', 1);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest('id')->paginate(20);

        // Fetch all proposed prices for this merchant
        $myProposals = MerchantProduct::where('user_id', $user->id)
            ->pluck('merchant_price', 'item_id')
            ->toArray();

        // Fetch statuses too
        $myStatuses = MerchantProduct::where('user_id', $user->id)
            ->pluck('status', 'item_id')
            ->toArray();

        return view('back.merchant.product_pricing', compact('items', 'myProposals', 'myStatuses'));
    }

    /**
     * Submit or update a price proposal.
     */
    public function submitPrice(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $user = User::where('email', $admin->email)->first();
        if (!$user || !$user->is_merchant) {
            return redirect()->back()->with('error', __('Only merchants can submit pricing.'));
        }

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'merchant_price' => 'required|numeric|min:0',
        ]);

        $item = Item::findOrFail($request->item_id);

        MerchantProduct::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item->id],
            ['merchant_price' => $request->merchant_price, 'is_active' => false, 'status' => 'pending']
        );

        return redirect()->back()->with('success', __('Price proposal submitted successfully and is pending approval.'));
    }

    /**
     * Delete/cancel a price proposal.
     */
    public function deletePrice($id)
    {
        $admin = Auth::guard('admin')->user();
        $user = User::where('email', $admin->email)->first();
        if (!$user || !$user->is_merchant) {
            return redirect()->back()->with('error', __('Only merchants can manage pricing.'));
        }

        $merchantProduct = MerchantProduct::where('user_id', $user->id)
            ->where('item_id', $id)
            ->firstOrFail();

        $merchantProduct->delete();

        return redirect()->back()->with('success', __('Price proposal removed.'));
    }

    /**
     * List all merchant price proposals (for admin).
     */
    public function allProposals(Request $request)
    {
        $query = MerchantProduct::with(['user', 'item'])->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($qu) use ($search) {
                    $qu->where('first_name', 'like', '%' . $search . '%')
                       ->orWhere('last_name', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%')
                       ->orWhere('store_name', 'like', '%' . $search . '%');
                })->orWhereHas('item', function($qi) use ($search) {
                    $qi->where('name', 'like', '%' . $search . '%')
                       ->orWhere('sku', 'like', '%' . $search . '%');
                });
            });
        }

        $proposals = $query->paginate(20);

        return view('back.merchant.all_proposals', compact('proposals'));
    }
}
