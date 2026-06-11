<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\MerchantPayout;
use App\Models\MerchantProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantReviewController extends Controller
{
    /**
     * List all pending merchant price proposals.
     */
    public function pendingPrices()
    {
        $pendingProducts = MerchantProduct::with(['user', 'item'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

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
}
