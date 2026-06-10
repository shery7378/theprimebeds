@extends('master.front')
@section('title')
    {{__('Dashboard')}}
@endsection

@push('styles')
<style>
    /* ── Reset & base ─────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Palette (white-anchored) ─────────────────── */
    :root {
        --white:       #ffffff;
        --bg:          #f5f7fa;
        --surface:     #ffffff;
        --border:      #e8ecf0;
        --text-dark:   #1a1f2e;
        --text-mid:    #4b5563;
        --text-light:  #9ca3af;

        /* accent – indigo-violet family, pairs crisply with white */
        --accent:      #6366f1;
        --accent-soft: #eef0fe;
        --accent-mid:  #c7d2fe;

        /* status chips */
        --teal-bg:     #ecfdf5;  --teal-fg:   #065f46;  --teal-dot:  #10b981;
        --amber-bg:    #fffbeb;  --amber-fg:  #92400e;  --amber-dot: #f59e0b;
        --red-bg:      #fef2f2;  --red-fg:    #991b1b;  --red-dot:   #ef4444;
        --blue-bg:     #eff6ff;  --blue-fg:   #1e40af;  --blue-dot:  #3b82f6;
        --purple-bg:   #f5f3ff;  --purple-fg: #4c1d95;  --purple-dot:#8b5cf6;
    }

    /* ── Layout scaffolding ───────────────────────── */
    body { background: var(--bg); }

    .dash-wrapper {
        max-width: 1120px;
        margin: 0 auto;
        padding: 2rem 1.25rem 3rem;
    }

    .dash-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 991px) {
        .dash-grid { grid-template-columns: 1fr; }
    }

    /* ── Sidebar ──────────────────────────────────── */
    .sidebar {
        background: var(--surface);
        border-radius: 16px;
        border: 1px solid var(--border);
        overflow: hidden;
        position: sticky;
        top: 1.5rem;
    }

    .sidebar-profile {
        background: var(--accent);
        padding: 1.75rem 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-align: center;
    }

    .avatar-ring {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        border: 2.5px solid rgba(255,255,255,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 1px;
    }

    .sidebar-name {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .sidebar-since {
        font-size: 12px;
        color: rgba(255,255,255,0.65);
        margin: 0;
    }

    .sidebar-nav {
        padding: 0.75rem 0.75rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 13.5px;
        color: var(--text-mid);
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        position: relative;
    }

    .nav-link:hover {
        background: var(--bg);
        color: var(--text-dark);
    }

    .nav-link.active {
        background: var(--accent-soft);
        color: var(--accent);
        font-weight: 600;
    }

    .nav-link i { font-size: 17px; flex-shrink: 0; }

    .nav-badge {
        margin-left: auto;
        background: var(--accent-soft);
        color: var(--accent);
        font-size: 11px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 20px;
        min-width: 22px;
        text-align: center;
    }

    .nav-link.active .nav-badge {
        background: var(--accent-mid);
    }

    .nav-divider {
        height: 1px;
        background: var(--border);
        margin: 0.5rem 0.75rem;
    }

    /* ── Main column ──────────────────────────────── */
    .main-col { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Welcome bar ──────────────────────────────── */
    .welcome-bar {
        background: var(--surface);
        border-radius: 16px;
        border: 1px solid var(--border);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .welcome-text h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 3px;
    }

    .welcome-text p {
        font-size: 13px;
        color: var(--text-light);
        margin: 0;
    }

    .welcome-actions { display: flex; gap: 8px; }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
        color: var(--text-mid);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: border-color 0.15s, background 0.15s;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-outline:hover { border-color: var(--accent-mid); background: var(--accent-soft); color: var(--accent); }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        background: var(--accent);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: opacity 0.15s;
        white-space: nowrap;
    }

    .btn-primary:hover { opacity: 0.88; }

    /* ── Stat cards grid ──────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 20px rgba(99,102,241,0.08);
        transform: translateY(-2px);
    }

    .stat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.purple { background: var(--purple-bg); color: var(--purple-dot); }
    .stat-icon.teal   { background: var(--teal-bg);   color: var(--teal-dot);   }
    .stat-icon.amber  { background: var(--amber-bg);  color: var(--amber-dot);  }
    .stat-icon.red    { background: var(--red-bg);    color: var(--red-dot);    }
    .stat-icon.blue   { background: var(--blue-bg);   color: var(--blue-dot);   }

    .stat-chip {
        font-size: 10.5px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .stat-chip.purple { background: var(--purple-bg); color: var(--purple-fg); }
    .stat-chip.teal   { background: var(--teal-bg);   color: var(--teal-fg);   }
    .stat-chip.amber  { background: var(--amber-bg);  color: var(--amber-fg);  }
    .stat-chip.red    { background: var(--red-bg);    color: var(--red-fg);    }
    .stat-chip.blue   { background: var(--blue-bg);   color: var(--blue-fg);   }

    .stat-num {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1;
    }

    .stat-label {
        font-size: 12.5px;
        color: var(--text-light);
        margin-top: 2px;
    }

    /* ── Two-col lower row ────────────────────────── */
    .lower-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    @media (max-width: 700px) {
        .lower-row { grid-template-columns: 1fr; }
    }

    /* ── Panel card ───────────────────────────────── */
    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    .panel-header {
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border);
    }

    .panel-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .panel-link {
        font-size: 12px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .panel-link:hover { text-decoration: underline; }

    .panel-body { padding: 0.25rem 0; }

    /* ── Empty state ──────────────────────────────── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 1.75rem 1rem;
        text-align: center;
    }

    .empty-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--accent-soft);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .empty-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .empty-sub {
        font-size: 12px;
        color: var(--text-light);
        margin: 0;
    }

    .empty-cta {
        margin-top: 4px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        border-radius: 8px;
        background: var(--accent);
        color: #fff;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
    }

    /* ── Quick actions ────────────────────────────── */
    .quick-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    @media (max-width: 600px) {
        .quick-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        padding: 1rem 0.5rem;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: var(--bg);
        color: var(--text-mid);
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        transition: background 0.15s, border-color 0.15s, color 0.15s;
        cursor: pointer;
    }

    .quick-btn:hover {
        background: var(--accent-soft);
        border-color: var(--accent-mid);
        color: var(--accent);
    }

    .quick-btn i {
        font-size: 22px;
        color: var(--accent);
    }

    /* ── Breadcrumb ───────────────────────────────── */
    .dash-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-light);
        margin-bottom: 1.25rem;
    }

    .dash-breadcrumb a {
        color: var(--text-light);
        text-decoration: none;
    }

    .dash-breadcrumb a:hover { color: var(--accent); }

    .dash-breadcrumb span { color: var(--text-mid); font-weight: 500; }

    .dash-breadcrumb .sep { font-size: 10px; }
</style>
@endpush

@section('content')
<div class="dash-wrapper">

    {{-- Breadcrumb --}}
    <nav class="dash-breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('front.index') }}">
            <i class="ti ti-home" style="font-size:14px; vertical-align:-2px;"></i>
            {{ __('Home') }}
        </a>
        <span class="sep">›</span>
        <span>{{ __('Dashboard') }}</span>
    </nav>

    <div class="dash-grid">

        {{-- ── Sidebar ── --}}
        <aside class="sidebar">
            <div class="sidebar-profile">
                <div class="avatar-ring">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <p class="sidebar-name">{{ auth()->user()->name }}</p>
                <p class="sidebar-since">{{ __('Joined') }} {{ auth()->user()->created_at->format('M Y') }}</p>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('user.dashboard') }}" class="nav-link active">
                    <i class="ti ti-layout-dashboard"></i>
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('user.profile') }}" class="nav-link">
                    <i class="ti ti-user"></i>
                    {{ __('Profile') }}
                </a>
                <a href="{{ route('user.ticket') }}" class="nav-link">
                    <i class="ti ti-headset"></i>
                    {{ __('Support Tickets') }}
                </a>

                <div class="nav-divider"></div>

                <a href="{{ route('user.order.index') }}" class="nav-link">
                    <i class="ti ti-shopping-bag"></i>
                    {{ __('Orders') }}
                    @if($allorders > 0)
                        <span class="nav-badge">{{ $allorders }}</span>
                    @endif
                </a>
                <a href="{{ route('user.address') }}" class="nav-link">
                    <i class="ti ti-map-pin"></i>
                    {{ __('Addresses') }}
                </a>
                <a href="{{ route('user.wishlist.index') }}" class="nav-link">
                    <i class="ti ti-heart"></i>
                    {{ __('Wishlist') }}
                </a>

                <div class="nav-divider"></div>

                <a href="{{ route('user.merchant.dashboard') }}" class="nav-link">
                    <i class="ti ti-store"></i>
                    {{ __('Merchant Dashboard') }}
                </a>
            </nav>
        </aside>

        {{-- ── Main content ── --}}
        <main class="main-col">

            {{-- Welcome bar --}}
            <div class="welcome-bar">
                <div class="welcome-text">
                    <h2>{{ __('Welcome back') }}, {{ explode(' ', auth()->user()->name)[0] }} :wave:</h2>
                    <p>{{ __("Here's a summary of your account activity.") }}</p>
                </div>
                <div class="welcome-actions">
                    <a href="{{ route('front.catalog') }}" class="btn-outline">
                        <i class="ti ti-shopping-cart" style="font-size:14px;"></i>
                        {{ __('Shop now') }}
                    </a>
                    <a href="{{ route('user.order.index') }}" class="btn-primary">
                        <i class="ti ti-truck-delivery" style="font-size:14px;"></i>
                        {{ __('Track order') }}
                    </a>
                </div>
            </div>

            {{-- Stats grid --}}
            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon purple">
                            <i class="ti ti-shopping-bag"></i>
                        </div>
                        <span class="stat-chip purple">{{ __('All') }}</span>
                    </div>
                    <div>
                        <div class="stat-num">{{ $allorders }}</div>
                        <div class="stat-label">{{ __('Total orders') }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon teal">
                            <i class="ti ti-circle-check"></i>
                        </div>
                        <span class="stat-chip teal">{{ __('Done') }}</span>
                    </div>
                    <div>
                        <div class="stat-num">{{ $delivered }}</div>
                        <div class="stat-label">{{ __('Completed') }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon amber">
                            <i class="ti ti-refresh"></i>
                        </div>
                        <span class="stat-chip amber">{{ __('Active') }}</span>
                    </div>
                    <div>
                        <div class="stat-num">{{ $progress }}</div>
                        <div class="stat-label">{{ __('Processing') }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon blue">
                            <i class="ti ti-clock"></i>
                        </div>
                        <span class="stat-chip blue">{{ __('Waiting') }}</span>
                    </div>
                    <div>
                        <div class="stat-num">{{ $pending }}</div>
                        <div class="stat-label">{{ __('Pending') }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon red">
                            <i class="ti ti-x"></i>
                        </div>
                        <span class="stat-chip red">{{ __('Closed') }}</span>
                    </div>
                    <div>
                        <div class="stat-num">{{ $canceled }}</div>
                        <div class="stat-label">{{ __('Cancelled') }}</div>
                    </div>
                </div>

            </div>

            {{-- Quick actions --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">{{ __('Quick actions') }}</p>
                </div>
                <div style="padding: 1rem;">
                    <div class="quick-grid">
                        <a href="{{ route('user.order.index') }}" class="quick-btn">
                            <i class="ti ti-truck-delivery"></i>
                            {{ __('Track order') }}
                        </a>
                        <a href="{{ route('user.address') }}" class="quick-btn">
                            <i class="ti ti-map-pin"></i>
                            {{ __('Manage addresses') }}
                        </a>
                        <a href="{{ route('user.ticket') }}" class="quick-btn">
                            <i class="ti ti-headset"></i>
                            {{ __('Open a ticket') }}
                        </a>
                        <a href="{{ route('user.profile') }}" class="quick-btn">
                            <i class="ti ti-user-edit"></i>
                            {{ __('Edit profile') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Lower row: Recent orders + Wishlist --}}
            <div class="lower-row">

                {{-- Recent orders --}}
                <div class="panel">
                    <div class="panel-header">
                        <p class="panel-title">{{ __('Recent orders') }}</p>
                        <a href="{{ route('user.order.index') }}" class="panel-link">
                            {{ __('View all') }} <i class="ti ti-arrow-right" style="font-size:12px;"></i>
                        </a>
                    </div>
                    <div class="panel-body">
                        @if(isset($recentOrders) && $recentOrders->count())
                            @foreach($recentOrders as $order)
                            <div style="display:flex; align-items:center; gap:10px; padding:10px 1.25rem; border-bottom:1px solid var(--border);">
                                <div style="width:34px;height:34px;border-radius:8px;background:var(--accent-soft);color:var(--accent);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="ti ti-package" style="font-size:16px;"></i>
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <p style="font-size:13px;font-weight:600;color:var(--text-dark);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        #{{ $order->order_number }}
                                    </p>
                                    <p style="font-size:11px;color:var(--text-light);margin:0;">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                @php
                                    $statusMap = [
                                        'delivered'  => ['teal',  __('Delivered')],
                                        'processing' => ['amber', __('Processing')],
                                        'pending'    => ['blue',  __('Pending')],
                                        'canceled'   => ['red',   __('Cancelled')],
                                    ];
                                    [$cls, $label] = $statusMap[$order->status] ?? ['blue', ucfirst($order->status)];
                                @endphp
                                <span class="stat-chip {{ $cls }}">{{ $label }}</span>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="ti ti-shopping-bag"></i>
                                </div>
                                <p class="empty-title">{{ __('No orders yet') }}</p>
                                <p class="empty-sub">{{ __('Your recent orders will appear here.') }}</p>
                                <a href="{{ route('front.catalog') }}" class="empty-cta">
                                    <i class="ti ti-arrow-right" style="font-size:13px;"></i>
                                    {{ __('Start shopping') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Wishlist --}}
                <div class="panel">
                    <div class="panel-header">
                        <p class="panel-title">{{ __('Wishlist') }}</p>
                        <a href="{{ route('user.wishlist.index') }}" class="panel-link">
                            {{ __('View all') }} <i class="ti ti-arrow-right" style="font-size:12px;"></i>
                        </a>
                    </div>
                    <div class="panel-body">
                        @if(isset($wishlistItems) && $wishlistItems->count())
                            @foreach($wishlistItems->take(4) as $item)
                            <div style="display:flex; align-items:center; gap:10px; padding:10px 1.25rem; border-bottom:1px solid var(--border);">
                                <div style="width:36px;height:36px;border-radius:8px;overflow:hidden;background:var(--bg);flex-shrink:0;">
                                    @if($item->product->thumbnail)
                                        <img src="{{ asset($item->product->thumbnail) }}" style="width:100%;height:100%;object-fit:cover;" alt="{{ $item->product->name }}">
                                    @else
                                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);">
                                            <i class="ti ti-photo" style="font-size:16px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <p style="font-size:13px;font-weight:600;color:var(--text-dark);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $item->product->name }}
                                    </p>
                                    <p style="font-size:11px;color:var(--text-light);margin:0;">
                                        {{ config('settings.currency_symbol') }}{{ number_format($item->product->price, 0) }}
                                    </p>
                                </div>
                                <i class="ti ti-heart-filled" style="font-size:16px;color:#f472b6;flex-shrink:0;"></i>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="ti ti-heart"></i>
                                </div>
                                <p class="empty-title">{{ __('Wishlist is empty') }}</p>
                                <p class="empty-sub">{{ __('Save items you love for later.') }}</p>
                                <a href="{{ route('front.catalog') }}" class="empty-cta">
                                    <i class="ti ti-arrow-right" style="font-size:13px;"></i>
                                    {{ __('Explore products') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>
@endsection