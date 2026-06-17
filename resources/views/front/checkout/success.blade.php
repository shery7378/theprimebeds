@extends('master.front')

@section('title')
    {{ __('Order Success') }}
@endsection

@section('content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a> </li>
                    <li class="separator"></li>
                    <li>{{ __('Success') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1">
        <div class="card text-center" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); max-width: 800px; margin: 0 auto; overflow: hidden;">
            <div class="card-body" style="padding: 50px 30px;">
                <!-- Success Icon -->
                <div style="margin-bottom: 25px;">
                    <div style="width: 90px; height: 90px; border-radius: 50%; background: #e8f9ed; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                </div>
                
                <h2 class="card-title" style="font-weight: 700; color: #333; margin-bottom: 15px;">{{ __('Thank you for your order!') }}</h2>
                <p class="card-text text-muted" style="font-size: 1.1rem; margin-bottom: 25px;">
                    {{ __('Your order has been successfully placed and is now being processed.') }}
                </p>
                
                <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin: 0 auto 30px auto; max-width: 450px; border: 1px dashed #ced4da;">
                    <p style="margin: 0; font-size: 0.95rem; color: #6c757d; text-transform: uppercase; letter-spacing: 1px;">{{ __('Order Number') }}</p>
                    <h4 style="margin: 5px 0 0 0; color: #000; font-weight: bold; letter-spacing: 1.5px;">{{ $order->transaction_number }}</h4>
                </div>
                
                <p class="card-text text-muted" style="margin-bottom: 30px;">
                    {{ __('We\'ll send a confirmation email to you shortly with your order details.') }}
                </p>
                
                <div class="d-flex justify-content-center flex-wrap" style="gap: 15px;">
                    <a class="btn btn-outline-primary" href="{{ route('front.order.track') }}" style="border-radius: 30px; padding: 12px 30px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="icon-map-pin pr-2"></i> {{ __('Track Order') }}
                    </a>
                    <a class="btn btn-primary" href="{{ route('front.catalog') }}" style="border-radius: 30px; padding: 12px 30px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="icon-package pr-2"></i> {{ __('Continue Shopping') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
