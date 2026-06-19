@extends('master.front')
@section('title')
    {{__('Dashboard')}}
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
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

        /* accent – brand color family, pairs crisply with white */
        --accent:      var(--primary-color, #8C7558);
        --accent-hover:var(--primary-color, #8C7558);
        --accent-soft: #fcf9f2;
        --accent-mid:  #e9e0d2;

        /* status chips */
        --teal-bg:     #ecfdf5;  --teal-fg:   #065f46;  --teal-dot:  #10b981;
        --amber-bg:    #fffbeb;  --amber-fg:  #92400e;  --amber-dot: #f59e0b;
        --red-bg:      #fef2f2;  --red-fg:    #991b1b;  --red-dot:   #ef4444;
        --blue-bg:     #eff6ff;  --blue-fg:   #1e40af;  --blue-dot:  #3b82f6;
        --purple-bg:   #f5f3ff;  --purple-fg: #4c1d95;  --purple-dot:#8b5cf6;
        
        --pill-pending-bg:   #fffbeb; --pill-pending-fg:   #d97706;
        --pill-delivered-bg: #ecfdf5; --pill-delivered-fg: #059669;
        --pill-completed-bg: #f3f4f6; --pill-completed-fg: #4b5563; /* or blue */
        --pill-canceled-bg:  #fef2f2; --pill-canceled-fg:  #dc2626;
    }

    body { background: var(--bg); font-family: 'Inter', sans-serif; overflow-x: hidden; }

    .dash-wrapper {
        max-width: 1120px;
        margin: 0 auto;
        padding: 2rem 1.25rem 4rem;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @media (min-width: 992px) {
        body.sidebar-active .dash-wrapper {
            padding-left: 300px;
        }
    }

    .dash-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    /* ── Sidebar (Global Off-canvas) ───────────────────────── */
    .sidebar {
        background: var(--surface);
        border: 1px solid var(--border);
        position: fixed;
        top: 130px;
        left: -320px;
        bottom: 0;
        width: 280px;
        height: calc(100vh - 130px);
        z-index: 9999;
        border-radius: 0;
        margin: 0;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
    }
        
    .sidebar.active {
        left: 0;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: transparent;
        z-index: 9998;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .btn-sidebar-toggle {
        display: block;
        background: none;
        border: none;
        font-size: 24px;
        color: var(--text-dark);
        cursor: pointer;
        padding: 0;
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
    .main-col { display: flex; flex-direction: column; gap: 1.5rem; }

    /* ── Top Header ───────────────────────────────── */
    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 0.5rem;
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .header-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--accent-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 600;
        color: var(--accent);
    }
    .header-info h1 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 4px;
    }
    .header-info .breadcrumbs {
        font-size: 12px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .header-info .breadcrumbs i { font-size: 14px; }
    
    .header-right {
        display: flex;
        gap: 12px;
    }
    .btn-header {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-primary {
        background: var(--accent);
        color: #fff;
        border: none;
    }
    .btn-primary:hover {
        background: var(--accent-hover);
        color: #fff;
    }

    /* ── Stat cards grid ──────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem 1rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .stat-card-title {
        font-size: 13px;
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 12px;
    }
    .stat-card-value {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .val-accent { color: var(--accent); }
    .val-green  { color: var(--teal-fg); }
    .val-amber  { color: var(--amber-fg); }
    .val-blue   { color: var(--blue-fg); }

    .stat-card-sub {
        font-size: 12px;
        color: var(--text-light);
    }

    /* ── Orders Table ─────────────────────────────── */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .table-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .table-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }
    .custom-table th {
        background: #fafbfc;
        padding: 12px 1.5rem;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-mid);
        border-bottom: 1px solid var(--border);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .custom-table td {
        padding: 16px 1.5rem;
        border-bottom: 1px solid var(--border);
        font-size: 13.5px;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .custom-table tr:last-child td {
        border-bottom: none;
    }
    .custom-table tbody tr:hover {
        background: #fdfdfd;
    }

    .order-number {
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
    }
    .order-number:hover {
        color: var(--accent);
        text-decoration: underline;
    }

    .status-pill {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        text-align: center;
    }
    .pill-pending   { background: var(--amber-bg) !important; color: var(--amber-fg) !important; }
    .pill-delivered { background: var(--teal-bg) !important; color: var(--teal-fg) !important; }
    .pill-processing{ background: var(--blue-bg) !important; color: var(--blue-fg) !important; }
    .pill-canceled  { background: var(--red-bg) !important; color: var(--red-fg) !important; }
</style>
@endpush

@section('content')

@include('includes.user_sitebar')

<div class="dash-wrapper">
    <div class="dash-grid">
        {{-- ── Main content ── --}}
        <main class="main-col">

            {{-- Top Header --}}
            <div class="dash-header">
                <div class="header-left">
                    <button id="sidebarToggle" class="btn-sidebar-toggle">
                        <i class="ti ti-menu-2"></i>
                    </button>
                    <div class="header-avatar">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                    </div>
                    <div class="header-info">
                        <h1>{{ __('Welcome back') }}, {{ auth()->user()->first_name }}!</h1>
                        <p style="margin: 0; font-size: 13px; color: var(--text-light);">{{ __('Here is an overview of your account today.') }}</p>
                    </div>
                </div>
                <div class="header-right">
                    <a href="{{ route('user.profile') }}" class="btn-header btn-primary">
                        <i class="ti ti-settings"></i> {{ __('Settings') }}
                    </a>
                </div>
            </div>

            {{-- Stats grid --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-title">{{ __('Total Orders') }}</div>
                    <div class="stat-card-value val-accent">{{ $allorders }}</div>
                    <div class="stat-card-sub">{{ __('Lifetime orders') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-title">{{ __('Completed') }}</div>
                    <div class="stat-card-value val-green">{{ $delivered }}</div>
                    <div class="stat-card-sub">{{ __('Successfully delivered') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-title">{{ __('Processing') }}</div>
                    <div class="stat-card-value val-blue">{{ $progress }}</div>
                    <div class="stat-card-sub">{{ __('Currently active') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-title">{{ __('Pending') }}</div>
                    <div class="stat-card-value val-amber">{{ $pending }}</div>
                    <div class="stat-card-sub">{{ __('Awaiting action') }}</div>
                </div>
            </div>

            {{-- Orders Table --}}
            <div class="table-card">
                <div class="table-header">
                    <h2 class="table-title">{{ __('Orders Table') }}</h2>
                    <a href="{{ route('user.order.index') }}" style="font-size:13px; color:var(--text-mid); text-decoration:none;"><i class="ti ti-arrows-maximize"></i></a>
                </div>
                
                <div style="overflow-x:auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentOrders) && $recentOrders->count() > 0)
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('user.order.invoice', $order->id) }}" class="order-number">
                                                #{{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td style="font-weight:500;">
                                            {{ config('settings.currency_symbol') }}{{ number_format($order->pay_amount, 2) }}
                                        </td>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'Delivered'  => ['pill-delivered', __('Delivered')],
                                                    'Processing' => ['pill-processing', __('Processing')],
                                                    'Pending'    => ['pill-pending',   __('Pending')],
                                                    'Canceled'   => ['pill-canceled',  __('Cancelled')],
                                                ];
                                                [$cls, $label] = $statusMap[$order->order_status] ?? ['pill-pending', $order->order_status];
                                            @endphp
                                            <span class="status-pill {{ $cls }}">{{ $label }}</span>
                                        </td>
                                        <td style="color:var(--text-mid);">
                                            {{ $order->created_at->format('n/j/Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align:center; padding: 3rem 1rem;">
                                        <div style="color:var(--text-light); margin-bottom:8px;"><i class="ti ti-shopping-bag" style="font-size:24px;"></i></div>
                                        <div style="font-weight:500;">{{ __('No orders found') }}</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>


@endsection