@extends('master.front')
@section('title')
    {{ __('Invoice') }}
@endsection
@section('content')

    <style>
        /* ===== Premium Invoice Redesign ===== */
        .pdp-invoice-wrapper {
            background-color: #fcfbfa;
            padding-top: 40px;
            padding-bottom: 80px;
        }

        .pdp-invoice-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(140, 117, 88, 0.06);
            border: 1px solid #ebe5db;
            padding: 45px !important;
            margin-bottom: 20px;
            position: relative;
        }

        /* Action Buttons */
        .btn-invoice-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: none;
        }
        .btn-back {
            background: #faf8f5;
            border: 1px solid #ebe5db;
            color: #796e65 !important;
        }
        .btn-back:hover {
            background: #f4f1eb;
            color: #2c2724 !important;
            transform: translateX(-3px);
        }
        .btn-print {
            background: var(--primary-color, #8C7558);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(140, 117, 88, 0.2);
        }
        .btn-print:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(140, 117, 88, 0.3);
        }

        /* Invoice Header Row */
        .invoice-header-row {
            border-bottom: 1px solid #f4f1eb;
            padding-bottom: 30px;
        }
        .invoice-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-color, #8C7558);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        /* Meta Grid */
        .invoice-meta-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            background: #faf8f5;
            border: 1px solid #ebe5db;
            border-radius: 14px;
            padding: 24px;
        }
        @media (max-width: 768px) {
            .invoice-meta-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .invoice-meta-grid {
                grid-template-columns: 1fr;
            }
        }
        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .meta-label {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #796e65;
            letter-spacing: 1px;
        }
        .meta-value {
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            color: #2c2724;
            line-height: 1.3;
        }
        .p-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            width: fit-content;
        }
        .status-paid {
            background: rgba(0, 184, 148, 0.1);
            color: #00b894;
        }
        .status-unpaid {
            background: rgba(214, 48, 49, 0.1);
            color: #d63031;
        }

        /* Address Grid */
        .address-box-card {
            background: #ffffff;
            border: 1px solid #ebe5db;
            border-radius: 14px;
            overflow: hidden;
            height: 100%;
            transition: border-color 0.3s;
        }
        .address-box-card:hover {
            border-color: var(--primary-color, #8C7558);
        }
        .address-box-header {
            background: #faf8f5;
            border-bottom: 1px solid #ebe5db;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .address-box-header .icon {
            color: var(--primary-color, #8C7558);
            font-size: 16px;
        }
        .address-box-header h5 {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            color: #2c2724;
        }
        .address-box-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .address-box-body .name {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #2c2724;
            margin-bottom: 4px;
        }
        .address-box-body .info {
            font-size: 13.5px;
            color: #796e65;
            margin: 0;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.4;
        }
        .address-box-body .info i {
            color: #c4b8a7;
            margin-top: 3px;
            width: 14px;
            text-align: center;
        }
        .address-box-body .address-detail {
            line-height: 1.5;
        }

        /* Products Table */
        .premium-table-wrap {
            border: 1px solid #ebe5db;
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
            margin-top: 10px;
        }
        .premium-table {
            margin: 0 !important;
            width: 100%;
        }
        .premium-table th {
            background: #faf8f5 !important;
            border-bottom: 1px solid #ebe5db !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            color: #796e65 !important;
            letter-spacing: 0.8px !important;
            padding: 16px 20px !important;
            border-top: none !important;
        }
        .premium-table td {
            padding: 20px !important;
            border-bottom: 1px solid #f4f1eb !important;
            vertical-align: middle !important;
            font-size: 14.5px !important;
            color: #2c2724;
        }
        .premium-table tr:last-child td {
            border-bottom: none !important;
        }
        .product-info-cell {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .product-info-cell .product-name {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #2c2724;
        }
        .btn-download-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-color, #8C7558);
            color: #ffffff !important;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none !important;
            transition: opacity 0.2s;
            width: fit-content;
            box-shadow: 0 4px 10px rgba(140, 117, 88, 0.15);
        }
        .btn-download-pill:hover {
            opacity: 0.9;
        }
        .license-info-text {
            font-size: 12px;
            color: #796e65;
            margin: 0;
            background: #faf8f5;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px dashed #ebe5db;
        }
        .attributes-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .attribute-pill {
            background: #faf8f5;
            border: 1px solid #ebe5db;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            color: #4e453e;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .attribute-pill .price-val {
            color: var(--primary-color, #8C7558);
            font-weight: 700;
        }

        /* Invoice Summary Card */
        .invoice-summary-card {
            background: #faf8f5;
            border: 1px solid #ebe5db;
            border-radius: 14px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #796e65;
            font-weight: 500;
        }
        .summary-value {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: #2c2724;
        }
        .total-row {
            border-top: 1px dashed #ebe5db;
            padding-top: 16px;
            margin-top: 4px;
        }
        .total-label {
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            font-weight: 800;
            color: #2c2724;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .total-value {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-color, #8C7558);
        }
    </style>

    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumbs">
                        <li><a href="{{ route('user.order.index') }}">{{ __('Orders') }}</a> </li>
                        <li class="separator"></li>
                        <li>{{ __('Order Invoice') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @php
        if ($order->state) {
            $state = json_decode($order->state, true);
        } else {
            $state = [];
        }
    @endphp

    <!-- Page Content-->
    <div class="pdp-invoice-wrapper print_invoice">
        <div class="container">
            
            {{-- Action Buttons Row --}}
            <div class="row align-items-center mb-4">
                <div class="col-6">
                    <a href="{{ route('user.order.index') }}" class="btn-invoice-action btn-back">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Orders') }}
                    </a>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('user.order.print', $order->id) }}" target="_blank" class="btn-invoice-action btn-print">
                        <i class="fas fa-print"></i> {{ __('Print Invoice') }}
                    </a>
                </div>
            </div>

            {{-- Main Invoice Card --}}
            <div class="pdp-invoice-card">
                
                {{-- Header / Logo --}}
                <div class="row invoice-header-row align-items-center mb-5">
                    <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
                        <img class="img-fluid mb-2" style="max-height: 48px;" alt="Logo"
                            src="{{ url('assets/img/prime_beds_logo3_transparent.png') }}">
                        <p class="text-muted small mb-0" style="font-family: 'Outfit', sans-serif; font-weight: 500;">
                            {{ __('Luxury Beds & Premium Sleep Solutions') }}
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <h2 class="invoice-title mb-1">{{ __('INVOICE') }}</h2>
                        <p class="text-muted small mb-0" style="font-family: 'Outfit', sans-serif; font-weight: 500;">
                            {{ __('Invoice No') }}: <span style="font-weight: 700; color: #2c2724;">{{ $order->transaction_number }}</span>
                        </p>
                    </div>
                </div>

                {{-- Order Details Meta Grid --}}
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="invoice-meta-grid">
                            <div class="meta-item">
                                <span class="meta-label">{{ __('Order Date') }}</span>
                                <span class="meta-value">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">{{ __('Transaction ID') }}</span>
                                <span class="meta-value" style="font-size: 13.5px; word-break: break-all;">{{ $order->txnid ? $order->txnid : __('N/A') }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">{{ __('Payment Method') }}</span>
                                <span class="meta-value">{{ $order->payment_method }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">{{ __('Payment Status') }}</span>
                                <span class="meta-value">
                                    @if ($order->payment_status == 'Paid')
                                        <span class="p-status-badge status-paid">
                                            <i class="fas fa-check-circle"></i> {{ __('Paid') }}
                                        </span>
                                    @else
                                        <span class="p-status-badge status-unpaid">
                                            <i class="fas fa-exclamation-circle"></i> {{ __('Unpaid') }}
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Address Grid --}}
                <div class="row mb-5 g-4">
                    <div class="col-md-6">
                        <div class="address-box-card">
                            <div class="address-box-header">
                                <i class="fas fa-file-invoice icon"></i>
                                <h5>{{ __('Billing Address') }}</h5>
                            </div>
                            <div class="address-box-body">
                                @php
                                    $bill = json_decode($order->billing_info, true);
                                @endphp
                                <p class="name">{{ $bill['bill_first_name'] ?? '' }} {{ $bill['bill_last_name'] ?? '' }}</p>
                                <p class="info"><i class="fas fa-envelope"></i> {{ $bill['bill_email'] ?? '' }}</p>
                                <p class="info"><i class="fas fa-phone"></i> {{ $bill['bill_phone'] ?? '' }}</p>
                                @if (isset($bill['bill_address1']))
                                    <p class="info address-detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>
                                            {{ $bill['bill_address1'] }}{{ isset($bill['bill_address2']) ? ', ' . $bill['bill_address2'] : '' }}<br>
                                            {{ $bill['bill_city'] ?? '' }}{{ isset($state['name']) ? ', ' . $state['name'] : '' }}{{ isset($bill['bill_zip']) ? ' ' . $bill['bill_zip'] : '' }}<br>
                                            {{ $bill['bill_country'] ?? '' }}
                                        </span>
                                    </p>
                                @endif
                                @if (isset($bill['bill_company']))
                                    <p class="info"><i class="fas fa-building"></i> {{ $bill['bill_company'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="address-box-card">
                            <div class="address-box-header">
                                <i class="fas fa-truck icon"></i>
                                <h5>{{ __('Shipping Address') }}</h5>
                            </div>
                            <div class="address-box-body">
                                @php
                                    $ship = json_decode($order->shipping_info, true);
                                @endphp
                                <p class="name">{{ $ship['ship_first_name'] ?? '' }} {{ $ship['ship_last_name'] ?? '' }}</p>
                                <p class="info"><i class="fas fa-envelope"></i> {{ $ship['ship_email'] ?? '' }}</p>
                                <p class="info"><i class="fas fa-phone"></i> {{ $ship['ship_phone'] ?? '' }}</p>
                                @if (isset($ship['ship_address1']))
                                    <p class="info address-detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>
                                            {{ $ship['ship_address1'] }}{{ isset($ship['ship_address2']) ? ', ' . $ship['ship_address2'] : '' }}<br>
                                            {{ $ship['ship_city'] ?? '' }}{{ isset($state['name']) ? ', ' . $state['name'] : '' }}{{ isset($ship['ship_zip']) ? ' ' . $ship['ship_zip'] : '' }}<br>
                                            {{ $ship['ship_country'] ?? '' }}
                                        </span>
                                    </p>
                                @endif
                                @if (isset($ship['ship_company']))
                                    <p class="info"><i class="fas fa-building"></i> {{ $ship['ship_company'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Products Table --}}
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="table-responsive premium-table-wrap">
                            <table class="table premium-table">
                                <thead>
                                    <tr>
                                        <th width="45%">{{ __('Products') }}</th>
                                        <th width="25%">{{ __('Attribute') }}</th>
                                        <th width="15%" class="text-center">{{ __('Quantity') }}</th>
                                        <th width="15%" class="text-end">{{ __('Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $option_price = 0;
                                        $total = 0;
                                    @endphp
                                    @foreach (json_decode($order->cart, true) as $key => $item)
                                        @php
                                            $total += $item['main_price'] * $item['qty'];
                                            $option_price += $item['attribute_price'];
                                            $grandSubtotal = $total + $option_price;
                                            if (App\Models\Item::where('id', $key)->exists()) {
                                                $main_item = App\Models\Item::findOrFail($key);
                                            } else {
                                                $main_item = null;
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="product-info-cell">
                                                    <span class="product-name">{{ $item['name'] }}</span>
                                                    @if ($main_item)
                                                        @if ($item['item_type'] == 'digital')
                                                            @if ($order->payment_status == 'Paid')
                                                                <div class="mt-2">
                                                                    @if ($main_item['file_type'] == 'link')
                                                                        <a href="{{ $main_item->link }}" target="_blank"
                                                                            class="btn-download-pill"><i class="fas fa-external-link-alt"></i> {{ __('Click Here') }}</a>
                                                                    @else
                                                                        <a href="{{ asset('assets/files/' . $main_item->file) }}"
                                                                            class="btn-download-pill"><i class="fas fa-cloud-download-alt"></i> {{ __('Download') }}</a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endif

                                                        @if ($item['item_type'] == 'license')
                                                            @if ($order->payment_status == 'Paid')
                                                                <div class="mt-2">
                                                                    @if ($main_item['file_type'] == 'link')
                                                                        <a href="{{ $main_item->link }}" target="_blank"
                                                                            class="btn-download-pill"><i class="fas fa-external-link-alt"></i> {{ __('Click Here') }}</a>
                                                                    @else
                                                                        <a href="{{ asset('assets/files/' . $main_item->file) }}"
                                                                            class="btn-download-pill"><i class="fas fa-cloud-download-alt"></i> {{ __('Download') }}</a>
                                                                    @endif
                                                                    <p class="license-info-text mt-2">
                                                                        <i class="fas fa-key"></i> <b>{{ __('License') }}</b>: {{ $item['item_l_n'] }} - {{ $item['item_l_k'] }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if (isset($item['attribute']['option_name']) && $item['attribute']['option_name'])
                                                    <div class="attributes-list">
                                                        @foreach ($item['attribute']['option_name'] as $optionkey => $option_name)
                                                            <span class="attribute-pill">
                                                                {{ $option_name }}
                                                                <span class="price-val">
                                                                    (+@if ($setting->currency_direction == 1)
                                                                        {{ $order->currency_sign }}{{ round($item['attribute']['option_price'][$optionkey] * $order->currency_value, 2) }}
                                                                    @else
                                                                        {{ round($item['attribute']['option_price'][$optionkey] * $order->currency_value, 2) }}{{ $order->currency_sign }}
                                                                    @endif)
                                                                </span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center font-monospace" style="font-weight: 700; color: #2c2724;">
                                                {{ $item['qty'] }}
                                            </td>
                                            <td class="text-end font-monospace" style="font-weight: 700; color: #2c2724;">
                                                @if ($setting->currency_direction == 1)
                                                    {{ $order->currency_sign }}{{ round($item['main_price'] * $order->currency_value, 2) }}
                                                @else
                                                    {{ round($item['main_price'] * $order->currency_value, 2) }}{{ $order->currency_sign }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Summary Section --}}
                <div class="row justify-content-end">
                    <div class="col-md-6 col-lg-5">
                        <div class="invoice-summary-card">
                            @if ($order->tax != 0)
                                <div class="summary-row">
                                    <span class="summary-label">{{ __('Tax') }}</span>
                                    <span class="summary-value">
                                        @if ($setting->currency_direction == 1)
                                            {{ $order->currency_sign }}{{ round($order->tax * $order->currency_value, 2) }}
                                        @else
                                            {{ round($order->tax * $order->currency_value, 2) }}{{ $order->currency_sign }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            @if (json_decode($order->discount, true))
                                @php
                                    $discount = json_decode($order->discount, true);
                                @endphp
                                <div class="summary-row">
                                    <span class="summary-label">{{ __('Coupon discount') }} ({{ $discount['code']['code_name'] }})</span>
                                    <span class="summary-value text-danger">
                                        @if ($setting->currency_direction == 1)
                                            -{{ $order->currency_sign }}{{ round($discount['discount'] * $order->currency_value, 2) }}
                                        @else
                                            -{{ round($discount['discount'] * $order->currency_value, 2) }}{{ $order->currency_sign }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            @if (json_decode($order->shipping, true))
                                @php
                                    $shipping = json_decode($order->shipping, true);
                                @endphp
                                <div class="summary-row">
                                    <span class="summary-label">{{ __('Shipping') }}</span>
                                    <span class="summary-value">
                                        @if ($setting->currency_direction == 1)
                                            {{ $order->currency_sign }}{{ round($shipping['price'] * $order->currency_value, 2) }}
                                        @else
                                            {{ round($shipping['price'] * $order->currency_value, 2) }}{{ $order->currency_sign }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            @if (json_decode($order->state_price, true))
                                <div class="summary-row">
                                    <span class="summary-label">{{ __('State Tax') }}{{ isset($state['type']) && $state['type'] == 'percentage' ? ' (' . $state['price'] . '%) ' : '' }}</span>
                                    <span class="summary-value">
                                        @if ($setting->currency_direction == 1)
                                            {{ $order->currency_sign }}{{ round($order['state_price'] * $order->currency_value, 2) }}
                                        @else
                                            {{ round($order['state_price'] * $order->currency_value, 2) }}{{ $order->currency_sign }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                            <div class="summary-row total-row">
                                <span class="total-label">
                                    @if ($order->payment_method == 'Cash On Delivery')
                                        {{ __('Total amount') }}
                                    @else
                                        {{ __('Total amount due') }}
                                    @endif
                                </span>
                                <span class="total-value">
                                    @if ($setting->currency_direction == 1)
                                        {{ $order->currency_sign }}{{ PriceHelper::OrderTotal($order) }}
                                    @else
                                        {{ PriceHelper::OrderTotal($order) }}{{ $order->currency_sign }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
