<aside class="sidebar">
    <div class="padding-top-2x hidden-lg-up"></div>
    <!-- Items in Cart Widget-->

    <section class="checkout-premium-card">
        <h3 class="widget-title">{{ __('Order Summary') }}</h3>
        @php
            $free_shipping = DB::table('shipping_services')->whereStatus(1)->whereIsCondition(1)->first();
        @endphp

        @if ($free_shipping)
            @if ($free_shipping->minimum_price >= $cart_total)
                <p class="free-shippin-aa"><em>{{ __('Free Shipping After Order') }}
                        {{ PriceHelper::setCurrencyPrice($free_shipping->minimum_price) }}</em></p>
            @endif
        @endif

        <table class="table">
            <tr>
                <td>{{ __('Cart subtotal') }}:</td>
                <td class="text-gray-dark">{{ PriceHelper::setCurrencyPrice($cart_total) }}</td>
            </tr>

            @if ($tax != 0)
                <tr>
                    <td>{{ __('Estimated tax') }}:</td>
                    <td class="text-gray-dark">{{ PriceHelper::setCurrencyPrice($tax) }}</td>
                </tr>
            @endif

            @if (DB::table('states')->count() > 0)
                <tr class="{{ Auth::check() && Auth::user()->state_id ? '' : 'd-none' }} set__state_price_tr">
                    <td>{{ __('State tax') }}:</td>
                    <td class="text-gray-dark set__state_price">
                        {{ PriceHelper::setCurrencyPrice(Auth::check() && Auth::user()->state_id ? ($cart_total * Auth::user()->state->price) / 100 : 0) }}
                    </td>
                </tr>
            @endif

            @if ($discount)
                <tr>
                    <td>{{ __('Coupon discount') }}:</td>
                    <td class="text-danger">-
                        {{ PriceHelper::setCurrencyPrice($discount ? $discount['discount'] : 0) }}</td>
                </tr>
            @endif

            @if ($shipping)
                <tr class="d-none set__shipping_price_tr">
                    <td>{{ __('Shipping') }}:</td>
                    <td class="text-gray-dark set__shipping_price">
                        {{ PriceHelper::setCurrencyPrice($shipping ? $shipping->price : 0) }}</td>
                </tr>
            @endif
            <tr>
                <td class="text-lg text-primary">{{ __('Order total') }}</td>
                <td class="text-lg text-primary grand_total_set">{{ PriceHelper::setCurrencyPrice($grand_total) }}
                </td>
            </tr>
        </table>
        
        {{-- Coupon / Promo Code Section --}}
        <div class="promo-section-checkout mt-4 mb-2 p-3 rounded shadow-sm" style="background-color: #f8f9fa; border: 2px dashed #cbd5e1;">
            @if ($discount)
                <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background: #e6f4ea; border: 1px solid #34a853; gap: 8px;">
                    <div>
                        <span class="d-block text-success font-weight-bold" style="font-size: 14px;">
                            <i class="fas fa-check-circle me-1"></i>{{ __('Coupon Active') }}
                        </span>
                        <small class="text-dark font-weight-bold" style="font-size: 13px;">{{ $discount['code']['title'] ?? '' }}</small>
                    </div>
                    <a href="{{ route('front.promo.destroy') }}" class="btn btn-sm btn-danger shadow-sm" style="border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600;">
                        <i class="fas fa-times mr-1"></i>{{ __('Remove') }}
                    </a>
                </div>
            @else
                <h6 class="mb-3 font-weight-bold text-dark" style="font-size: 15px;">
                    <i class="fas fa-ticket-alt text-primary mr-2"></i>{{ __('Have a Promo Code?') }}
                </h6>
                <form method="post" id="checkout_coupon_form_single" action="{{ route('front.promo.submit') }}">
                    @csrf
                    <div class="d-flex align-items-stretch shadow-sm rounded" style="gap: 0;">
                        <input class="form-control" name="code" type="text" placeholder="{{ __('Enter code...') }}" required 
                            style="border-radius: 8px 0 0 8px; border: 1px solid #ced4da; border-right: none; padding: 10px 15px; font-size: 14px; min-height: 45px; margin-bottom: 0; box-shadow: none;">
                        <button class="btn btn-primary m-0 px-4" type="submit" 
                            style="border-radius: 0 8px 8px 0; font-size: 14px; font-weight: bold; min-height: 45px; display: inline-flex; align-items: center; justify-content: center; text-transform: none; letter-spacing: 0; transition: all 0.3s ease;">
                            {{ __('Apply') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </section>

    @if (PriceHelper::CheckDigital() == true)
    <section class="checkout-premium-card">
        <h3 class="widget-title">{{ __('Shipping Options') }}</h3>
        <div class="row">
            <div class="col-sm-12 mb-3">
                @if (PriceHelper::CheckDigital() == true)
                    @php
                        $free_shipping = DB::table('shipping_services')->whereStatus(1)->whereIsCondition(1)->first();
                    @endphp

                    <select name="shipping_id" class="form-control form-control-premium" id="shipping_id_select" required>
                        <option value="" selected disabled>{{ __('Select Shipping Method') }}*</option>
                        @foreach (DB::table('shipping_services')->whereStatus(1)->get() as $shipping)
                            @if ($shipping->id == 1 && isset($free_shipping) && $free_shipping->minimum_price <= $cart_total)
                                <option value="{{ $shipping->id }}" data-href="{{ route('front.shipping.setup') }}">
                                    {{ $shipping->title }}
                                </option>
                            @else
                                @if ($shipping->id != 1)
                                    <option value="{{ $shipping->id }}"
                                        data-href="{{ route('front.shipping.setup') }}">{{ $shipping->title }}
                                        ({{ PriceHelper::setCurrencyPrice($shipping->price) }})
                                    </option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                    @error('shipping_id')
                        <p class="text-danger shipping_message">{{ $message }}</p>
                    @enderror

                @endif
            </div>
            <div class="col-sm-12 mb-3">
                @if (PriceHelper::CheckDigital() == true)
                    @if (DB::table('states')->whereStatus(1)->count() > 0)
                        <select name="state_id" class="form-control form-control-premium" id="state_id_select" required>
                            <option value="" selected disabled>{{ __('Select Shipping State') }}*</option>
                            @foreach (DB::table('states')->whereStatus(1)->get() as $state)
                                <option value="{{ $state->id }}" data-href="{{ route('front.state.setup') }}"
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
                        @error('state_id')
                            <p class="text-danger state_message">{{ $message }}</p>
                        @enderror
                    @endif
                @endif
            </div>
        </div>

    </section>
    @endif



    <!-- Order Summary Widget-->
    <section class="checkout-premium-card mb-0">
        <h3 class="widget-title">{{ __('Pay now') }}</h3>
        <div class="row">
            <div class="col-sm-12">
                @php
                    $gateways = DB::table('payment_settings')->whereStatus(1)->get();
                @endphp
                <style>
                    .custom-payment-select-trigger {
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
                    .custom-payment-select-trigger:hover {
                        border-color: #8C7558 !important;
                    }
                    .custom-payment-select-wrapper.open .custom-payment-select-trigger {
                        border-color: #8C7558 !important;
                        box-shadow: 0 0 0 4px rgba(140, 117, 88, 0.1) !important;
                    }
                    .custom-payment-select-trigger i {
                        font-size: 10px;
                        color: #b59469;
                        transition: transform 0.3s ease, color 0.2s ease;
                        margin-left: 8px;
                    }
                    .custom-payment-select-wrapper.open .custom-payment-select-trigger i {
                        transform: rotate(180deg);
                        color: #8C7558 !important;
                    }
                    .custom-payment-select-options {
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
                    .custom-payment-select-option {
                        padding: 10px 20px !important;
                        font-size: 13.5px !important;
                        font-weight: 600 !important;
                        color: #5a5045 !important;
                        cursor: pointer;
                        transition: all 0.22s ease;
                        font-family: 'Outfit', sans-serif;
                    }
                    .custom-payment-select-option:not(.placeholder-option):hover {
                        background: rgba(197, 160, 89, 0.06) !important;
                        color: #8C7558 !important;
                        padding-left: 24px !important;
                    }
                    .custom-payment-select-option.active {
                        background: rgba(197, 160, 89, 0.1) !important;
                        color: #8C7558 !important;
                        font-weight: 700 !important;
                    }
                    .custom-payment-select-option.placeholder-option {
                        color: #b59469 !important;
                        cursor: not-allowed;
                        border-bottom: 1px solid rgba(235, 220, 208, 0.5);
                        font-weight: 500 !important;
                    }
                </style>
                <div class="custom-payment-select-wrapper mb-3" style="position: relative; width: 100%;">
                    <div class="custom-payment-select-trigger">
                        <span class="selected-payment-text" style="color: #b59469;">{{ __('Select a payment method') }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="custom-payment-select-options">
                        <li class="custom-payment-select-option placeholder-option">{{ __('Select a payment method') }}</li>
                        @foreach ($gateways as $gateway)
                            @php
                                $show = true;
                                if (PriceHelper::CheckDigitalPaymentGateway() && $gateway->unique_keyword == 'cod') {
                                    $show = false;
                                }
                                // Commented out/hidden Bank Transfer for now
                                if ($gateway->unique_keyword == 'bank') {
                                    $show = false;
                                }
                            @endphp
                            @if ($show)
                                <li class="custom-payment-select-option" data-value="{{ $gateway->unique_keyword }}" style="padding: 10px 16px; font-size: 14.5px; font-weight: 500; color: #374151; cursor: pointer; transition: all 0.2s ease;">
                                    {{ $gateway->name }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <select class="form-control form-control-premium payment_gateway d-none" required>
                    <option value="" selected disabled>{{ __('Select a payment method') }}</option>
                    @foreach ($gateways as $gateway)
                        {{-- Commented out/hidden Bank Transfer for now --}}
                        @if ($gateway->unique_keyword != 'bank')
                            @if (PriceHelper::CheckDigitalPaymentGateway())
                                @if ($gateway->unique_keyword != 'cod')
                                    <option value="{{ $gateway->unique_keyword }}">{{ $gateway->name }}</option>
                                @endif
                            @else
                                <option value="{{ $gateway->unique_keyword }}">{{ $gateway->name }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>

                @if ($setting->is_privacy_trams == 1)
                    <div class="form-group mt-4">
                        <div class="custom-control d-flex custom-checkbox">
                            <input class="custom-control-input me-2" type="checkbox" id="trams__condition_single"
                                value="">
                            <label class="custom-control-label flex-1" for="trams__condition">This site is protected by
                                reCAPTCHA
                                and the <a href="{{ $setting->policy_link }}" target="_blank">Privacy Policy</a> and <a
                                    href="{{ $setting->terms_link }}" target="_blank">Terms of Service</a>
                                apply.</label>
                        </div>
                    </div>
                @endif

                <button id="single_checkout_payment" disabled="true"
                    class="btn btn-primary mt-4 single_checkout_payment" type="submit"><span>@lang('Pay now')</span></button>
            </div>

        </div>
    </section>

</aside>

@section('script')
    <script>
        // Show the modal on #single_checkout_payment change
        $(document).on("click", "#single_checkout_payment", function(e) {
            // 1. Validate billing form fields
            let billingForm = document.getElementById('checkoutBilling');
            if (billingForm && !billingForm.reportValidity()) {
                e.preventDefault();
                return false;
            }

            // 2. Validate shipping options
            let shippingSelect = document.getElementById('shipping_id_select');
            let stateSelect = document.getElementById('state_id_select');

            if (shippingSelect && !shippingSelect.value) {
                alert('Please select a shipping method.');
                e.preventDefault();
                return false;
            }

            if (stateSelect && !stateSelect.value) {
                alert('Please select a shipping state.');
                e.preventDefault();
                return false;
            }

            let keyword = $('.payment_gateway').val();
            let modalElement = document.getElementById(keyword);

            if (modalElement) {
                // Open the modal using Bootstrap 5's API
                let modal = new bootstrap.Modal(modalElement);
                modal.show();

                // Get all input fields from the #checkoutBilling form
                let allinput = $("#checkoutBilling input");

                // Clear any previously appended inputs from checkoutBilling
                $(modalElement).find('form').find('.billing-field').remove();

                // Loop through each input and append a hidden input in the modal form
                allinput.each(function() {
                    // Create a new hidden input field with the same name and value
                    let hiddenInput = $('<input>')
                        .attr('type', 'hidden') // Set the input type to hidden
                        .attr('name', $(this).attr('name')) // Use the same name attribute
                        .addClass('billing-field')
                        .val($(this).val()); // Set the value of the hidden input

                    // Append the hidden input to the modal form
                    $(modalElement).find('form').append(hiddenInput);
                });

                // Explicitly set shipping and state values in the modal
                if (shippingSelect) {
                    $(modalElement).find('.shipping_id_setup').val(shippingSelect.value);
                }
                if (stateSelect) {
                    $(modalElement).find('.state_id_setup').val(stateSelect.value);
                }
            }
        });

        // Handle the "Terms and Conditions" checkbox click
        $(document).on("click", "#trams__condition_single", function() {
            if ($("#trams__condition_single").is(':checked')) {
                console.log("check");
                // Enable the dropdown by assigning the ID and removing the disabled attribute
                $('.single_checkout_payment').attr('id', "single_checkout_payment");
                $('.single_checkout_payment').attr('disabled', false);
            } else {
                // Remove the ID and disable the dropdown when unchecked
                $('.single_checkout_payment').removeAttr('id');
                $('.single_checkout_payment').attr('disabled', true);
            }
        });

        // Toggle payment dropdown open/close
        $(document).on('click', '.custom-payment-select-trigger', function(e) {
            e.stopPropagation();
            $('.custom-payment-select-options').slideToggle(200);
            $(this).closest('.custom-payment-select-wrapper').toggleClass('open');
        });

        // Close payment dropdown when clicking outside
        $(document).on('click', function() {
            $('.custom-payment-select-options').slideUp(150);
            $('.custom-payment-select-wrapper').removeClass('open');
        });

        // Select payment option
        $(document).on('click', '.custom-payment-select-option:not(.placeholder-option)', function() {
            let val = $(this).data('value');
            let text = $(this).text().trim();
            let select = $('.payment_gateway');
            
            select.val(val).trigger('change');
            $('.selected-payment-text').text(text).css('color', '#2c2924');
            
            $(this).addClass('active').siblings().removeClass('active');
            $('.custom-payment-select-options').slideUp(150);
            $('.custom-payment-select-wrapper').removeClass('open');
        });
    </script>
@endsection
