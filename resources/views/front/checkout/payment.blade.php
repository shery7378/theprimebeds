@extends('master.front')
@section('title')
    {{ __('Payment') }}
@endsection
@section('content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a> </li>
                    <li class="separator"></li>
                    <li>{{ __('Review your order and pay') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1 checkut-page">
        <div class="row">
            <!-- Payment Methode-->
            <div class="col-xl-9 col-lg-8">
                <div class="steps flex-sm-nowrap mb-5"> <a class="step" href="{{ route('front.checkout.billing') }}">
                        <h4 class="step-title"><i class="icon-check-circle"></i>1. {{ __('Invoice to') }}:</h4>
                    </a> <a class="step" href="{{ route('front.checkout.shipping') }}">
                        <h4 class="step-title"><i class="icon-check-circle"></i>2. {{ __('Ship to') }}:</h4>
                    </a> <a class="step active" href="{{ route('front.checkout.payment') }}">
                        <h4 class="step-title">3. {{ __('Review and pay') }}</h4>
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="pb-2 widget-title2">{{ __('Review Your Order') }} :</h6>
                        
                        <div class="row">
                            <div class="col-sm-6 mb-4">
                                <h6 class="fz-16-bold">{{ __('Invoice address') }} :</h6>
                                @php

                                    $ship = Session::get('shipping_address');
                                    $bill = Session::get('billing_address');
                                @endphp
                                <ul class="list-unstyled">
                                    <li><span class="text-muted pay-label">{{ __('Name') }}:
                                        </span>{{ $ship['ship_first_name'] }} {{ $ship['ship_last_name'] }}</li>
                                    @if (PriceHelper::CheckDigital())
                                        <li><span class="text-muted pay-label">{{ __('Address') }}:
                                            </span>{{ $ship['ship_address1'] }} {{ @$ship['ship_address2'] }}</li>
                                    @endif
                                    <li><span class="text-muted pay-label">{{ __('Phone') }}: </span>{{ $ship['ship_phone'] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6  mb-4">
                                <h6 class="fz-16-bold">{{ __('Shipping address') }} :</h6>
                                <ul class="list-unstyled">
                                    <li><span class="text-muted pay-label">{{ __('Name') }}:
                                        </span>{{ $bill['bill_first_name'] }} {{ $bill['bill_last_name'] }}</li>
                                    @if (PriceHelper::CheckDigital())
                                        <li><span class="text-muted pay-label">{{ __('Address') }}:
                                            </span>{{ $ship['ship_address1'] }} {{ @$ship['ship_address2'] }}</li>
                                    @endif
                                    <li><span class="text-muted pay-label">{{ __('Phone') }}: </span>{{ $bill['bill_phone'] }}
                                    </li>
                                </ul>

                              
                               
                            </div>
                        </div>
                        {{-- @if (PriceHelper::CheckDigital() == true) --}}
                        <h6 class="pb-2 widget-title2">{{ __('Shipping Options') }} :</h6>
                        {{-- @endif --}}
                        <div class="row">
                            <div class="col-sm-6  mb-4">
                                 {{-- @if (PriceHelper::CheckDigital() == true) --}}
                                    
                            
                                    @php
                                        $free_shipping = DB::table('shipping_services')->whereStatus(1)->whereIsCondition(1)->first();
                                    @endphp

    <style>
                                        .custom-shipping-select-trigger {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            width: 100%;
                                            padding: 12px 20px;
                                            background: #ffffff !important;
                                            border: 1.5px solid #ebdcd0 !important;
                                            border-radius: 14px !important;
                                            font-size: 13.5px !important;
                                            font-weight: 600 !important;
                                            color: #2c2924 !important;
                                            cursor: pointer;
                                            user-select: none;
                                            transition: all 0.22s ease;
                                            font-family: 'Outfit', sans-serif;
                                        }
                                        .custom-shipping-select-trigger:hover {
                                            border-color: #8C7558 !important;
                                        }
                                        .custom-shipping-select-wrapper.open .custom-shipping-select-trigger {
                                            border-color: #8C7558 !important;
                                            box-shadow: 0 0 0 4px rgba(140, 117, 88, 0.1) !important;
                                        }
                                        .custom-shipping-select-trigger i {
                                            font-size: 10px;
                                            color: #b59469;
                                            transition: transform 0.3s ease, color 0.2s ease;
                                            margin-left: 8px;
                                        }
                                        .custom-shipping-select-wrapper.open .custom-shipping-select-trigger i {
                                            transform: rotate(180deg);
                                            color: #8C7558 !important;
                                        }
                                        .custom-shipping-select-options {
                                            position: absolute;
                                            top: calc(100% + 8px);
                                            left: 0;
                                            right: 0;
                                            background: rgba(255, 255, 255, 0.98) !important;
                                            backdrop-filter: blur(8px);
                                            border: 1.5px solid #ebdcd0 !important;
                                            border-radius: 14px !important;
                                            padding: 8px 0 !important;
                                            margin: 0;
                                            list-style: none;
                                            display: none;
                                            z-index: 1050;
                                            box-shadow: 0 10px 30px rgba(44, 41, 36, 0.05);
                                            max-height: 250px;
                                            overflow-y: auto;
                                        }
                                        .custom-shipping-select-option {
                                            padding: 10px 20px !important;
                                            font-size: 13.5px !important;
                                            font-weight: 600 !important;
                                            color: #5a5045 !important;
                                            cursor: pointer;
                                            transition: all 0.22s ease;
                                            font-family: 'Outfit', sans-serif;
                                        }
                                        .custom-shipping-select-option:not(.placeholder-option):hover {
                                            background: rgba(197, 160, 89, 0.06) !important;
                                            color: #8C7558 !important;
                                            padding-left: 24px !important;
                                        }
                                        .custom-shipping-select-option.active {
                                            background: rgba(197, 160, 89, 0.1) !important;
                                            color: #8C7558 !important;
                                            font-weight: 700 !important;
                                        }
                                        .custom-shipping-select-option.placeholder-option {
                                            color: #b59469 !important;
                                            cursor: not-allowed;
                                            border-bottom: 1px solid rgba(235, 220, 208, 0.5);
                                            font-weight: 500 !important;
                                        }
                                    </style>
                                    <div class="custom-shipping-select-wrapper mb-3" style="position: relative; width: 100%;">
                                        <div class="custom-shipping-select-trigger">
                                            <span class="selected-shipping-text" style="color: #b59469;">{{ __('Select Shipping Method') }}</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <ul class="custom-shipping-select-options">
                                            <li class="custom-shipping-select-option placeholder-option">{{ __('Select Shipping Method') }}</li>
                                            @foreach (DB::table('shipping_services')->whereStatus(1)->get() as $shipping)
                                                @if ($shipping->id == 1 && isset($free_shipping) &&  $free_shipping->minimum_price <= $cart_total)
                                                    <li class="custom-shipping-select-option" data-value="{{ $shipping->id }}">
                                                        {{ $shipping->title }}
                                                    </li>
                                                @else
                                                    @if ($shipping->id != 1)
                                                        <li class="custom-shipping-select-option" data-value="{{ $shipping->id }}">
                                                            {{ $shipping->title }} ({{ PriceHelper::setCurrencyPrice($shipping->price) }})
                                                            @if($shipping->title == 'collect')
                                                                - {{ __('Sign and Print Creation LTD, 41 High Street , EH22 1JB') }}
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <select name="shipping_id" class="form-control d-none" id="shipping_id_select" required>
                                        <option value="" selected disabled>{{ __('Select Shipping Method') }}</option>
                                        @foreach (DB::table('shipping_services')->whereStatus(1)->get() as $shipping)
                                            @if ($shipping->id == 1 && isset($free_shipping) &&  $free_shipping->minimum_price <= $cart_total)
                                                <option value="{{ $shipping->id }}"
                                                    data-href="{{ route('front.shipping.setup') }}">{{ $shipping->title }}
                                                </option>
                                            @else
                                                @if ($shipping->id != 1)
                                                    <option value="{{ $shipping->id }}"
                                                        data-href="{{ route('front.shipping.setup') }}">{{ $shipping->title }}
                                                        ({{ PriceHelper::setCurrencyPrice($shipping->price) }})
                                                    @if($shipping->title == 'collect')
                                                        - {{ __('Sign and Print Creation LTD, 41 High Street , EH22 1JB') }}
                                                    @endif
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>

                                    <small class="text-primary shipping_message">{{ __('Please select shipping method') }}</small>
                                    @error('shipping_id')
                                        <p class="text-danger shipping_message">{{ $message }}</p>
                                    @enderror

                                {{-- @endif --}}
                            </div>
                            <div class="col-sm-6  mb-4">
                                @if (PriceHelper::CheckDigital() == true)
                                    
                                
                                @if (DB::table('states')->whereStatus(1)->count() > 0)
                                    <select name="state_id" class="form-control" id="state_id_select" required>
                                        <option value="" selected disabled>{{ __('Select Shipping State') }}</option>
                                        @foreach (DB::table('states')->whereStatus(1)->get() as $state)
                                            <option value="{{ $state->id }}"
                                                data-href="{{ route('front.state.setup') }}"
                                                {{ Auth::check() && Auth::user()->state_id == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                                @if ($state->type == 'fixed')
                                                    ({{ PriceHelper::setCurrencyPrice($state->price) }})
                                                @else
                                                    ({{ $state->price }}%)
                                                @endif

                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-primary state_message">{{ __('Please select shipping state') }}</small>
                                    @error('state_id')
                                        <p class="text-danger state_message">{{ $message }}</p>
                                    @enderror
                                @endif
                            @endif
                            </div>
                        </div>
                        <h6 class="pb-2 widget-title2">{{ __('Pay With') }} :</h6>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="payment-methods">
                                    @php
                                        $gateways = DB::table('payment_settings')->whereStatus(1)->get();
                                    @endphp
                                    @foreach ($gateways as $gateway)
                                        @if (PriceHelper::CheckDigitalPaymentGateway())
                                            @if ($gateway->unique_keyword != 'cod')
                                                <div class="single-payment-method">
                                                    <a class="text-decoration-none payment-link" href="#" data-modal-target="#{{ $gateway->unique_keyword }}">
                                                        <img src="{{ url('assets/img/' . $gateway->photo) }}" alt="{{ $gateway->name }}" title="{{ $gateway->name }}">
                                                        <p>{{ $gateway->name }}</p>
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="single-payment-method">
                                                <a class="text-decoration-none payment-link" href="#" data-modal-target="#{{ $gateway->unique_keyword }}">
                                                    <img src="{{ url('assets/img/' . $gateway->photo) }}" alt="{{ $gateway->name }}" title="{{ $gateway->name }}">
                                                    <p>{{ $gateway->name }}</p>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('includes.checkout_modal')

            </div>
            <!-- Sidebar  -->
            <div class="col-xl-3 col-lg-4">
                @include('includes.checkout_sitebar',$cart)
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all payment method links
    const paymentLinks = document.querySelectorAll('.payment-link');
    const shippingSelect = document.getElementById('shipping_id_select');
    const stateSelect = document.getElementById('state_id_select');
    const shippingMessage = document.querySelector('.shipping_message');
    const stateMessage = document.querySelector('.state_message');
    const isShippingRequired = true;

    // Add click event listeners to all payment method links
    paymentLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            let isValid = true;
            
            // Validate shipping method
            if (isShippingRequired && !shippingSelect.value) {
                shippingMessage.textContent = 'Please select shipping method';
                shippingMessage.classList.remove('text-primary');
                shippingMessage.classList.add('text-danger');
                isValid = false;
            }

            // Validate state if required
            if (isShippingRequired && stateSelect && !stateSelect.value) {
                stateMessage.textContent = 'Please select shipping state';
                stateMessage.classList.remove('text-primary');
                stateMessage.classList.add('text-danger');
                isValid = false;
            }

            // Only open modal if valid
            if (isValid) {
                const targetModalId = this.getAttribute('data-modal-target');
                const modalElement = document.querySelector(targetModalId);
                
                if (shippingSelect) {
                    const shippingInput = modalElement.querySelector('.shipping_id_setup');
                    if(shippingInput) shippingInput.value = shippingSelect.value;
                }
                if (stateSelect) {
                    const stateInput = modalElement.querySelector('.state_id_setup');
                    if(stateInput) stateInput.value = stateSelect.value;
                }

                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    });

    // Reset validation messages when user selects an option
    if (shippingSelect) {
        shippingSelect.addEventListener('change', function() {
            shippingMessage.textContent = 'Please select shipping method';
            shippingMessage.classList.remove('text-danger');
            shippingMessage.classList.add('text-primary');
        });
    }

    if (stateSelect) {
        stateSelect.addEventListener('change', function() {
            stateMessage.textContent = 'Please select shipping state';
            stateMessage.classList.remove('text-danger');
            stateMessage.classList.add('text-primary');
        });
    }

    // Toggle shipping dropdown open/close
    $(document).on('click', '.custom-shipping-select-trigger', function(e) {
        e.stopPropagation();
        $('.custom-shipping-select-options').slideToggle(200);
        $(this).closest('.custom-shipping-select-wrapper').toggleClass('open');
    });

    // Close shipping dropdown when clicking outside
    $(document).on('click', function() {
        $('.custom-shipping-select-options').slideUp(150);
        $('.custom-shipping-select-wrapper').removeClass('open');
    });

    // Select shipping option
    $(document).on('click', '.custom-shipping-select-option:not(.placeholder-option)', function() {
        let val = $(this).data('value');
        let text = $(this).text().trim();
        let select = $('#shipping_id_select');
        
        select.val(val).trigger('change');
        if (select[0]) {
            select[0].dispatchEvent(new Event('change'));
        }
        $('.selected-shipping-text').text(text).css('color', '#2c2924');
        
        $(this).addClass('active').siblings().removeClass('active');
        $('.custom-shipping-select-options').slideUp(150);
        $('.custom-shipping-select-wrapper').removeClass('open');
    });
});
</script>
@endsection
