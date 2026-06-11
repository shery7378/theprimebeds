@extends('master.front')
@section('title', __('Merchant Dashboard'))

@section('content')

{{-- ===== PAGE TITLE ===== --}}
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                    <li class="separator"></li>
                    <li>{{ __('Merchant Dashboard') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ===== PAGE CONTENT ===== --}}
<div class="container padding-bottom-3x mb-2">
    <div class="row">

        {{-- SIDEBAR --}}
        @include('includes.merchant_sitebar')

        {{-- MAIN CONTENT --}}
        <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>

            {{-- ===== HERO WELCOME BANNER ===== --}}
            <div class="merchant-hero-banner mb-4">
                <div class="merchant-hero-left">
                    <div class="merchant-hero-emoji">🚀</div>
                    <div>
                        <h4 class="merchant-hero-title">{{ __('Welcome back,') }} <span>{{ $user->first_name }}!</span></h4>
                        <p class="merchant-hero-sub">{{ __("Here's what's happening with your store today.") }}</p>
                        <div class="merchant-hero-store-row">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <a href="{{ route('front.merchant.store', $user->store_name) }}" target="_blank" class="merchant-hero-store-link">
                                {{ url('/store/' . $user->store_name) }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="merchant-hero-right">
                    <a href="{{ route('user.merchant.catalog') }}" class="btn-merchant-add">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Add Products') }}
                    </a>
                </div>
            </div>

            {{-- ===== STATS GRID ===== --}}
            <div class="row merchant-stats-grid mb-4">

                {{-- Total Earnings --}}
                <div class="col-md-6 mb-3">
                    <div class="merchant-stat-card stat-earnings">
                        <div class="stat-card-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">{{ __('Total Earnings') }}</p>
                            <h3 class="stat-value">{{ \App\Helpers\PriceHelper::setCurrencyPrice($totalEarnings) }}</h3>
                            <span class="stat-badge stat-badge-green">{{ __('Available Balance') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Active Products --}}
                <div class="col-md-6 mb-3">
                    <a href="{{ route('user.merchant.my_products') }}" class="merchant-stat-card stat-active">
                        <div class="stat-card-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">{{ __('Active Products') }}</p>
                            <h3 class="stat-value">{{ $activeProductsCount }}</h3>
                            <span class="stat-badge stat-badge-blue">{{ __('Live in store') }}</span>
                        </div>
                    </a>
                </div>

                {{-- Pending Approval --}}
                <div class="col-md-6 mb-3">
                    <a href="{{ route('user.merchant.my_products') }}" class="merchant-stat-card stat-pending">
                        <div class="stat-card-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">{{ __('Pending Approval') }}</p>
                            <h3 class="stat-value">{{ $pendingProductsCount }}</h3>
                            <span class="stat-badge stat-badge-orange">{{ __('Awaiting admin review') }}</span>
                        </div>
                    </a>
                </div>

                {{-- Rejected --}}
                <div class="col-md-6 mb-3">
                    <a href="{{ route('user.merchant.my_products') }}" class="merchant-stat-card stat-rejected">
                        <div class="stat-card-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">{{ __('Rejected') }}</p>
                            <h3 class="stat-value">{{ $rejectedProductsCount }}</h3>
                            <span class="stat-badge stat-badge-red">{{ __('Needs revision') }}</span>
                        </div>
                    </a>
                </div>

            </div>

            {{-- ===== RECENT PRODUCTS TABLE ===== --}}
            <div class="merchant-section-card">
                <div class="merchant-section-header">
                    <h6 class="merchant-section-title">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        {{ __('Recent Products') }}
                    </h6>
                    <a href="{{ route('user.merchant.my_products') }}" class="merchant-view-all">{{ __('View All') }} &rarr;</a>
                </div>

                @if($recentProducts->isEmpty())
                <div class="merchant-empty-state">
                    <div class="merchant-empty-icon">📦</div>
                    <p class="merchant-empty-title">{{ __('No products yet') }}</p>
                    <p class="merchant-empty-sub">{{ __('Start by browsing the catalog and adding products to your store.') }}</p>
                    <a href="{{ route('user.merchant.catalog') }}" class="btn-merchant-primary">{{ __('Browse Catalog') }}</a>
                </div>
                @else
                <div class="merchant-products-list">
                    @foreach($recentProducts as $mp)
                    <div class="merchant-product-row">
                        <div class="merchant-product-thumb">
                            @if($mp->item && $mp->item->photo)
                                <img src="{{ asset('assets/img/' . $mp->item->photo) }}" alt="{{ $mp->item->name ?? '' }}">
                            @else
                                <div class="merchant-product-thumb-placeholder">
                                    <svg width="20" height="20" fill="none" stroke="#9ca3af" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="merchant-product-info">
                            <p class="merchant-product-name">{{ $mp->item->name ?? '—' }}</p>
                            <p class="merchant-product-price">{{ \App\Helpers\PriceHelper::setCurrencyPrice($mp->merchant_price) }}</p>
                        </div>
                        <div class="merchant-product-status">
                            @if($mp->status === 'approved')
                                <span class="mps-badge mps-approved">
                                    <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                    {{ __('Live') }}
                                </span>
                            @elseif($mp->status === 'pending')
                                <span class="mps-badge mps-pending">
                                    <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/></svg>
                                    {{ __('Pending') }}
                                </span>
                            @else
                                <span class="mps-badge mps-rejected">
                                    <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                    {{ __('Rejected') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ===== QUICK ACTIONS ===== --}}
            <div class="merchant-quick-actions mt-4">
                <h6 class="merchant-section-title mb-3">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    {{ __('Quick Actions') }}
                </h6>
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="{{ route('user.merchant.catalog') }}" class="merchant-quick-card">
                            <span class="merchant-quick-icon" style="background:linear-gradient(135deg,#6366f1,#818cf8)">
                                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </span>
                            <span>{{ __('Add to Store') }}</span>
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('user.merchant.my_products') }}" class="merchant-quick-card">
                            <span class="merchant-quick-icon" style="background:linear-gradient(135deg,#0ea5e9,#38bdf8)">
                                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </span>
                            <span>{{ __('Manage Products') }}</span>
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('front.merchant.store', $user->store_name) }}" target="_blank" class="merchant-quick-card">
                            <span class="merchant-quick-icon" style="background:linear-gradient(135deg,#22c55e,#4ade80)">
                                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </span>
                            <span>{{ __('View My Store') }}</span>
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('user.profile') }}" class="merchant-quick-card">
                            <span class="merchant-quick-icon" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
                                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <span>{{ __('Edit Profile') }}</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- /col-lg-8 --}}
    </div>
</div>

{{-- ===== MERCHANT DASHBOARD STYLES ===== --}}
<style>
/* === HERO BANNER === */
.merchant-hero-banner {
    background: linear-gradient(135deg, #0f2540 0%, #1a3a5c 55%, #244e7a 100%);
    border-radius: 20px;
    padding: 28px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(15,37,64,.30);
}
.merchant-hero-banner::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: rgba(201,168,76,.08);
    border-radius: 50%;
}
.merchant-hero-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 80px;
    width: 150px; height: 150px;
    background: rgba(201,168,76,.05);
    border-radius: 50%;
}
.merchant-hero-left {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
}
.merchant-hero-emoji {
    font-size: 2.4rem;
    line-height: 1;
    flex-shrink: 0;
}
.merchant-hero-title {
    color: #fff;
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0 0 4px;
}
.merchant-hero-title span {
    color: #c9a84c;
}
.merchant-hero-sub {
    color: rgba(255,255,255,.7);
    font-size: 0.83rem;
    margin: 0 0 8px;
}
.merchant-hero-store-row {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,.5);
}
.merchant-hero-store-link {
    color: #a5b4fc;
    font-size: 0.78rem;
    text-decoration: none;
    word-break: break-all;
}
.merchant-hero-store-link:hover { color: #fff; text-decoration: underline; }
.merchant-hero-right { z-index: 1; flex-shrink: 0; }
.btn-merchant-add {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(201,168,76,.20);
    color: #c9a84c;
    border: 1.5px solid rgba(201,168,76,.40);
    padding: 9px 18px;
    border-radius: 12px;
    font-size: 0.87rem;
    font-weight: 600;
    text-decoration: none;
    backdrop-filter: blur(4px);
    transition: all .2s;
}
.btn-merchant-add:hover {
    background: rgba(201,168,76,.35);
    color: #e8cc82;
    text-decoration: none;
    transform: translateY(-1px);
}

/* === STAT CARDS === */
.merchant-stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
    background: #fff;
    border-radius: 18px;
    padding: 22px 20px;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    text-decoration: none;
    transition: all .2s ease;
    border: 1.5px solid transparent;
    height: 100%;
}
.merchant-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,.12);
    text-decoration: none;
}
.stat-earnings { border-color: #d4e3ef; }
.stat-earnings:hover { border-color: #1a3a5c; }
.stat-active { border-color: #d4e8d5; }
.stat-active:hover { border-color: #16a34a; }
.stat-pending { border-color: #fef3c7; }
.stat-pending:hover { border-color: #f59e0b; }
.stat-rejected { border-color: #fee2e2; }
.stat-rejected:hover { border-color: #ef4444; }

.stat-card-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-earnings .stat-card-icon { background: #e8eef5; color: #1a3a5c; }
.stat-active .stat-card-icon { background: #dcfce7; color: #16a34a; }
.stat-pending .stat-card-icon { background: #fef3c7; color: #f59e0b; }
.stat-rejected .stat-card-icon { background: #fee2e2; color: #ef4444; }

.stat-card-content { flex: 1; }
.stat-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin: 0 0 4px;
}
.stat-value {
    font-size: 1.55rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 6px;
    line-height: 1.1;
}
.stat-badge {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 20px;
}
.stat-badge-green { background: #dcfce7; color: #16a34a; }
.stat-badge-blue  { background: #e0f2fe; color: #0284c7; }
.stat-badge-orange { background: #fef3c7; color: #d97706; }
.stat-badge-red   { background: #fee2e2; color: #dc2626; }

/* === RECENT PRODUCTS === */
.merchant-section-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    overflow: hidden;
}
.merchant-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 22px 16px;
    border-bottom: 1px solid #f3f4f6;
}
.merchant-section-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.merchant-view-all {
    font-size: 0.83rem;
    font-weight: 600;
    color: #1a3a5c;
    text-decoration: none;
}
.merchant-view-all:hover { color: #0f2540; text-decoration: none; }

.merchant-products-list { padding: 8px 0; }
.merchant-product-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 22px;
    transition: background .15s;
}
.merchant-product-row:hover { background: #f9fafb; }
.merchant-product-thumb {
    width: 48px; height: 48px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f3f4f6;
}
.merchant-product-thumb img { width: 100%; height: 100%; object-fit: cover; }
.merchant-product-thumb-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
}
.merchant-product-info { flex: 1; min-width: 0; }
.merchant-product-name {
    font-size: 0.88rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.merchant-product-price {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}
.merchant-product-status { flex-shrink: 0; }

.mps-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.mps-approved { background: #dcfce7; color: #16a34a; }
.mps-pending  { background: #fef3c7; color: #d97706; }
.mps-rejected { background: #fee2e2; color: #dc2626; }

/* === EMPTY STATE === */
.merchant-empty-state {
    text-align: center;
    padding: 48px 24px;
}
.merchant-empty-icon { font-size: 3rem; margin-bottom: 14px; }
.merchant-empty-title { font-weight: 700; color: #111827; margin-bottom: 6px; }
.merchant-empty-sub { color: #9ca3af; font-size: 0.87rem; margin-bottom: 18px; }
.btn-merchant-primary {
    display: inline-block;
    background: linear-gradient(135deg, #1a3a5c, #244e7a);
    color: #fff;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.88rem;
    text-decoration: none;
    transition: opacity .2s;
}
.btn-merchant-primary:hover { opacity: .88; color: #fff; text-decoration: none; }

/* === QUICK ACTIONS === */
.merchant-quick-actions { }
.merchant-quick-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #fff;
    border-radius: 18px;
    padding: 22px 12px;
    text-align: center;
    font-size: 0.83rem;
    font-weight: 600;
    color: #374151;
    text-decoration: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: all .2s;
    border: 1.5px solid transparent;
    height: 100%;
}
.merchant-quick-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(0,0,0,.11);
    text-decoration: none;
    color: #111827;
    border-color: #e5e7eb;
}
.merchant-quick-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* === RESPONSIVE === */
@media (max-width: 767px) {
    .merchant-hero-banner { flex-direction: column; text-align: center; padding: 22px 18px; }
    .merchant-hero-left { flex-direction: column; text-align: center; }
    .stat-value { font-size: 1.25rem; }
}
</style>

@endsection
