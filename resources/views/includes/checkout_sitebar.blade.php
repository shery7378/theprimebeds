<aside class="sidebar">
    <div class="padding-top-2x hidden-lg-up"></div>
    <!-- Items in Cart Widget-->


    <section class="card widget widget-featured-posts widget-order-summary p-4">
        <h3 class="widget-title">{{ __('Order Summary') }}</h3>
        @php
            $free_shipping = DB::table('shipping_services')->whereStatus(1)->whereIsCondition(1)->first();
            $bundle_discount_total = 0;
            foreach ($cart as $item) {
                $bundle_discount_total += $item['bundle_discount'] ?? 0;
            }
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
                <td class="text-gray-dark">{{ PriceHelper::setCurrencyPrice($cart_total + $bundle_discount_total) }}</td>
            </tr>

            @if ($bundle_discount_total > 0)
            <tr>
                <td>{{ __('Bundle Discount') }}:</td>
                <td class="text-danger">-{{ PriceHelper::setCurrencyPrice($bundle_discount_total) }}</td>
            </tr>
            @endif

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

            @if (PriceHelper::CheckDigital())
                <tr class="d-none set__shipping_price_tr">
                    <td>{{ __('Shipping') }}:</td>
                    <td class="text-gray-dark set__shipping_price">
                        {{ PriceHelper::setCurrencyPrice(0) }}</td>
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
                <form method="post" id="checkout_coupon_form" action="{{ route('front.promo.submit') }}">
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

    <script>
    (function waitForJquery() {
        if (typeof jQuery === 'undefined') {
            setTimeout(waitForJquery, 50);
            return;
        }
        $(document).on('submit', '#checkout_coupon_form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var url = $form.attr('action');
            var $btn = $form.find('button');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $.ajax({
                type: 'POST',
                url: url,
                data: $form.serialize(),
                success: function (resp) {
                    if (resp.status) {
                        successNotification(resp.message);
                        setTimeout(function () { location.reload(); }, 800);
                    } else {
                        dangerNotification(resp.message);
                        $btn.prop('disabled', false).html('{{ __("Apply") }}');
                    }
                },
                error: function () {
                    dangerNotification('Something went wrong. Please try again.');
                    $btn.prop('disabled', false).html('{{ __("Apply") }}');
                }
            });
        });
    })();
</script>




    <section class="card widget widget-featured-posts widget-featured-products p-4">
        <h3 class="widget-title">{{ __('Items In Your Cart') }}</h3>
        @foreach ($cart as $key => $item)
            @php
                $optionDetails = \App\Models\AttributeOption::whereIn('id', $item['options_id'] ?? [])->get();
                $lastOption = $optionDetails->last();

                $lastImage = null;

                if ($lastOption && !empty($lastOption->variation_images)) {
                    $images = json_decode($lastOption->variation_images, true);
                    $lastImage = is_array($images) && count($images) ? $images[0] : null;
                }
            @endphp
            <div class="entry">
                <div class="entry-thumb">
                    <a href="{{ route('front.product', $item['slug']) }}">
                        @if($lastImage)
                            <img src="{{ url('assets/img/' . $lastImage) }}" alt="Product">
                        @else
                            <img src="{{ url('assets/img/' . $item['photo']) }}" alt="Product">
                        @endif
                    </a>
                </div>
                <div class="entry-content">
                    <h4 class="entry-title"><a href="{{ route('front.product', $item['slug']) }}">
                            {{ Str::limit($item['name'], 45) }}

                        </a></h4>
                    <span class="entry-meta">{{ $item['qty'] }} x
                        {{ PriceHelper::setCurrencyPrice($item['main_price']) }}.</span>

                    @foreach ($item['attribute']['option_name'] as $optionkey => $option_name)
                        <span class="entry-meta"><b>{{ $option_name }}</b> :
                            {{ PriceHelper::setCurrencySign() }}{{ $item['attribute']['option_price'][$optionkey] }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

</aside>
