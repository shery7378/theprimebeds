@php
    $grandSubtotal = 0;
    $bundle_discount_total = 0;
@endphp
<style>
    .toolbar-dropdown.cart-dropdown {
        margin-top: 20px !important;
        width: 420px !important;
        min-width: 420px !important;
        padding: 25px !important;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-radius: 12px;
        max-height: 80vh !important;
        overflow-y: auto !important;
    }
</style>
@if (Session::has('cart'))

<div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 1px solid #111;">
    <div style="width: 46px; height: 46px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
        <i class="icon-shopping-cart text-muted" style="font-size: 18px;"></i>
    </div>
    <div>
        <h6 style="margin: 0; font-weight: 600; color: #002e3b; font-size: 14px;">THE PRIME BEDS</h6>
        <span class="text-muted" style="font-size: 11px;">Luxury Beds & Furniture</span>
    </div>
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

<div class="d-flex flex-column mb-3" style="border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <div class="d-flex align-items-start mb-0">
        <div style="width: 72px; height: 72px; border-radius: 8px; overflow: hidden; background: #fff; flex-shrink: 0; border: 1px solid #eee;">
            <a href="{{ route('front.product', $cart['slug']) }}" style="display: block; width: 100%; height: 100%;">
                @if($lastImage)
                    <img src="{{ url('assets/img/' . $lastImage) }}" alt="Product" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                    <img src="{{ asset('assets/img/'.$cart['photo']) }}" alt="Product" style="width: 100%; height: 100%; object-fit: contain;">
                @endif
            </a>
        </div>
        <div class="d-flex flex-column" style="flex: 1; margin-left: 25px;">
            <a href="{{route('front.product', $cart['slug'])}}" style="font-size: 16px; font-weight: 700; color: #002e3b; line-height: 1.3;">{{ Str::limit($cart['name'], 45) }}</a>
            <span class="text-danger mt-1" style="font-size: 14px;">({{PriceHelper::setCurrencyPrice($cart['main_price'])}})</span>
            @foreach ($cart['attribute']['option_name'] as $optionkey => $option_name)
            <span style="font-size: 11px; color: #777; margin-top: 2px;">{{$cart['attribute']['names'][$optionkey]}}: {{$option_name}}</span>
            @endforeach
        </div>
    </div>
    
    <div class="d-flex align-items-stretch qtySelector product-quantity" style="border: 1.5px solid #999; border-radius: 4px; width: fit-content; overflow: hidden; height: 30px; align-self: flex-end; margin-top: -25px;">
        <span class="decreaseQtycart cartsubclick" data-id="{{ $key }}" data-target="{{ \App\Helpers\PriceHelper::GetItemId($key) }}" style="display: flex; align-items: center; justify-content: center; width: 32px; cursor: pointer; color: #111; font-size: 16px; background: #fdfdfd; padding-bottom: 5px;">&minus;</span>
        
        <input type="text" disabled class="qtyValue cartcart-amount text-center" value="{{ $cart['qty'] }}" style="display: flex; align-items: center; justify-content: center; padding: 0; padding-bottom: 6px; margin: 0; border: none; border-left: 1.5px solid #999; border-right: 1.5px solid #999; font-weight: 600; color: #111; width: 36px; background: transparent; font-size: 14px;">
        
        <span class="increaseQtycart cartaddclick" data-id="{{ $key }}" data-target="{{ \App\Helpers\PriceHelper::GetItemId($key) }}" data-item="{{ isset($cart['options_id']) ? implode(',', (array)$cart['options_id']) : '' }}" style="display: flex; align-items: center; justify-content: center; width: 32px; cursor: pointer; color: #111; font-size: 16px; background: #fdfdfd; padding-bottom: 5px;">&plus;</span>
        <input type="hidden" value="3333" id="current_stock">
    </div>
</div>
@endforeach

<div class="d-flex flex-column mt-3 mb-4" style="font-size: 15px; color: #111;">
    <div class="d-flex justify-content-between mb-2">
        <span>Subtotal:</span>
        <span style="font-weight: 500;">{{PriceHelper::setCurrencyPrice($grandSubtotal)}}</span>
    </div>

    
    @if(Session::has('coupon'))
    <div class="d-flex justify-content-between mb-2">
        <span class="text-danger">Discount:</span>
        <span class="text-danger" style="font-weight: 500;">-{{PriceHelper::setCurrencyPrice(Session::get('coupon')['discount'])}}</span>
    </div>
    @endif

    @if($bundle_discount_total > 0)
    <div class="d-flex justify-content-between mb-2">
        <span class="text-danger">Bundle Discount:</span>
        <span class="text-danger" style="font-weight: 500;">-{{ PriceHelper::setCurrencyPrice($bundle_discount_total) }}</span>
    </div>
    @endif

    <div class="d-flex justify-content-between mt-2 pt-2" style="border-top: 1px solid #111; font-weight: 700; font-size: 16px;">
        <span>Total:</span>
        <span>{{PriceHelper::setCurrencyPrice($grandSubtotal + $bundle_discount_total - (Session::has('coupon') ? Session::get('coupon')['discount'] : 0))}}</span>
    </div>
</div>

<div class="d-flex flex-column" style="gap: 12px;">
    <a href="{{ route('front.cart.clear') }}" class="btn btn-outline-danger btn-block m-0" style="border-radius: 8px; color: #e74c3c; border-color: #f5c6cb; background: #fff; text-transform: none; font-weight: 500;">Clear Cart</a>
    <a href="{{ route('front.checkout') }}" class="btn btn-outline-dark btn-block m-0" style="border-radius: 8px; color: #002e3b; border: 1px solid #002e3b; background: transparent; text-transform: none; font-weight: 600;">Go to Checkout</a>
</div>

@else
  <div class="text-center py-5">
      <i class="icon-shopping-cart" style="font-size: 40px; color: #ddd; margin-bottom: 15px;"></i>
      <h6 class="mb-0">{{__('Your Cart is empty.')}}</h6>
  </div>
@endif