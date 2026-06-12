@php
    $grandSubtotal = 0;
    $bundle_discount_total = 0;
@endphp
<style>
    .toolbar-dropdown.cart-dropdown {
        margin-top: 20px !important;
        width: 750px !important;
        min-width: 750px !important;
        padding: 20px !important;
    }
</style>
@if (Session::has('cart'))

<div class="cart-header d-flex align-items-center justify-content-end" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
    <a class="btn btn-sm btn-dark rounded-pill px-3" style="font-size: 9px; padding: 5px 10px; display: inline-flex; align-items: center; gap: 5px;" href="{{ route('front.cart.clear') }}"><i class="icon-trash"></i> <span>Clear Cart</span></a>
</div>

@foreach (Session::get('cart') as $key => $cart)
@php
    $grandSubtotal += $cart['price'] * $cart['qty'];
    $bundle_discount_total += $cart['bundle_discount'] ?? 0;
@endphp
    @php
        $optionDetails = \App\Models\AttributeOption::whereIn('id', $cart['options_id'] ?? [])->get();
        
        $lastOption = $optionDetails->last();

        $lastImage = null;

        if ($lastOption && !empty($lastOption->variation_images)) {
            $images = json_decode($lastOption->variation_images, true);
            $lastImage = is_array($images) && count($images) ? $images[0] : null;
        }
    @endphp

<div class="entry d-flex align-items-center" style="padding-bottom: 15px; border-bottom: 1px solid #eee; margin-bottom: 15px; gap: 15px;">
  
  <div style="flex: 3; display: flex; align-items: center; gap: 15px;">
      <div class="entry-thumb" style="width: 60px; height: 60px; flex-shrink: 0; background: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
        <a href="{{ route('front.product', $cart['slug']) }}" style="display: block; width: 100%; height: 100%;">
            @if($lastImage)
                <img src="{{ url('assets/img/' . $lastImage) }}" alt="Product" style="width: 100%; height: 100%; object-fit: contain;">
            @else
                <img src="{{ url('assets/img/' . $cart['photo']) }}" alt="Product" style="width: 100%; height: 100%; object-fit: contain;">
            @endif
        </a>
      </div>
      <div>
        <h4 class="entry-title" style="margin: 0;"><a href="{{route('front.product', $cart['slug'])}}" style="font-size: 13px; font-weight: 600;">{{ Str::limit($cart['name'], 45) }}</a></h4>
        @foreach ($cart['attribute']['option_name'] as $optionkey => $option_name)
        <span class="att" style="font-size: 11px; display: block; color: #777;"><em>{{$cart['attribute']['names'][$optionkey]}}:</em> {{$option_name}} ({{PriceHelper::setCurrencyPrice($cart['attribute']['option_price'][$optionkey])}})</span>
        @endforeach
      </div>
  </div>

  <div style="flex: 1.5; text-align: center; font-size: 13px; color: #555;">
      {{PriceHelper::setCurrencyPrice($cart['main_price'])}}
  </div>

  <div style="flex: 1.5; display: flex; justify-content: center;">
      <div class="qtySelector product-quantity d-flex align-items-center" style="background: #f3f5f9; border-radius: 30px; padding: 2px 5px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
          <span class="decreaseQtycart cartsubclick" data-id="{{ $key }}"
              data-target="{{ \App\Helpers\PriceHelper::GetItemId($key) }}" style="cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.08); font-size: 10px;"><i class="fas fa-minus"></i></span>
          <input type="text" disabled class="qtyValue cartcart-amount text-center"
              value="{{ $cart['qty'] }}" style="width: 30px; border: none; background: transparent; font-weight: bold; font-size: 12px; padding: 0;">
          <span class="increaseQtycart cartaddclick" data-id="{{ $key }}"
              data-target="{{ \App\Helpers\PriceHelper::GetItemId($key) }}"
              data-item="{{ isset($cart['options_id']) ? implode(',', (array)$cart['options_id']) : '' }}" style="cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.08); font-size: 10px;"><i class="fas fa-plus"></i></span>
          <input type="hidden" value="3333" id="current_stock">
      </div>
  </div>

  <div style="flex: 1.5; text-align: center; font-weight: 700; font-size: 13px; color: #111;">
      {{PriceHelper::setCurrencyPrice($cart['main_price'] * $cart['qty'])}}
  </div>

  <div style="width: 90px; text-align: center;">
      <a href="{{route('front.cart.destroy', $key)}}" style="color: #ff4d4f; background: #fff1f0; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 12px;"><i class="icon-x"></i></a>
  </div>

</div>
@endforeach


<div class="d-flex justify-content-between align-items-end mt-3 pt-3" style="border-top: 1px solid #eee;">
    <div style="flex: 1; max-width: 350px;">
        <form class="coupon-form" method="post" id="header_coupon_form" action="{{ route('front.promo.submit') }}">
            @csrf
            <div class="d-flex align-items-stretch" style="width: 100%;">
                <input class="form-control" name="code" type="text" placeholder="{{ __('Coupon code') }}" required style="border-radius: 30px 0 0 30px; padding-left:20px; border-right: 0; min-height: 44px; margin-bottom: 0;">
                <button class="btn btn-dark m-0 px-4" type="submit" style="border-radius: 0 30px 30px 0; white-space: nowrap; min-height: 44px; display: flex; align-items: center; justify-content: center;"><span>{{ __('Apply Coupon') }}</span></button>
            </div>
        </form>
    </div>

    <div class="text-right d-flex flex-column align-items-end" style="min-width: 250px;">
        @if(Session::has('coupon'))
        <div class="d-flex justify-content-between w-100 mb-2">
            <span class="text-muted">{{ __('Discount') }} ({{ Session::get('coupon')['code']['title'] }}):</span>
            <div>
                <span class="text-danger font-weight-bold">-{{ PriceHelper::setCurrencyPrice(Session::get('coupon')['discount']) }}</span>
                <a class="remove-from-cart text-danger ms-2" href="{{ route('front.promo.destroy') }}" data-toggle="tooltip" title="Remove item"><i class="icon-x"></i></a>
            </div>
        </div>
        @endif

        @if($bundle_discount_total > 0)
        <div class="d-flex justify-content-between w-100 mb-2">
            <span class="text-muted">{{ __('Bundle Discount') }}:</span>
            <span class="text-danger font-weight-bold">-{{ PriceHelper::setCurrencyPrice($bundle_discount_total) }}</span>
        </div>
        @endif

        <div class="d-flex justify-content-between w-100 text-lg font-weight-bold" style="font-size: 16px;">
            <span class="text-muted">{{ __('Subtotal') }}:</span>
            <span class="text-dark">{{ PriceHelper::setCurrencyPrice($grandSubtotal + $bundle_discount_total - (Session::has('coupon') ? Session::get('coupon')['discount'] : 0)) }}</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between mt-3">
  <div class="w-50 d-block pe-2"><a class="btn btn-outline-primary btn-sm mb-0 w-100"
      href="{{route('front.cart')}}"><span>{{__('Cart')}}</span></a></div>
  <div class="w-50 d-block ps-2 text-end"><a class="btn btn-primary btn-sm mb-0 w-100"
      href="{{route('front.checkout.billing')}}"><span>{{__('Checkout')}}</span></a></div>
</div>
  @else
  <style>
      .toolbar-dropdown.cart-dropdown {
          width: 380px !important;
          min-width: 380px !important;
          max-height: none !important;
          overflow: hidden !important;
          padding: 0 !important;
      }
      .toolbar-dropdown.cart-dropdown * {
          max-height: none !important;
      }
  </style>
  <div style="text-align: center; width: 100%; overflow: hidden;">
    <a href="{{ route('front.catalog') }}" style="display: block; width: 100%;">
        <img src="{{ asset('assets/img/cart.png') }}" alt="Empty Cart" style="width: 100%; display: block;">
    </a>
  </div>
  @endif
  <script>
    function cartQuantity(key, change) {
      console.log("Key:", key, "Change:", change);

      const input = document.getElementById('Cartquantity_' + key);
      if (!input) {
        console.warn("Input not found for key:", key);
        return;
      }

      let value = parseInt(input.value) || 1;
      value += change;

      if (value < 1) value = 1;

      input.value = value;
    }
  </script>


</div>