@php
    $grandSubtotal = 0;
    $bundle_discount_total = 0;
@endphp
@if (Session::has('cart'))
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
<div class="entry">
  <div class="entry-thumb">
    <a href="{{ route('front.product', $cart['slug']) }}">
        @if($lastImage)
            <img src="{{ url('assets/img/' . $lastImage) }}" alt="Product">
        @else
            <img src="{{ url('assets/img/' . $cart['photo']) }}" alt="Product">
        @endif
    </a>
  </div>
  <div class="entry-content">
    <h4 class="entry-title"><a href="{{route('front.product', $cart['slug'])}}">
        {{ Str::limit($cart['name'], 45) }}
      </a></h4>
    <span class="entry-meta">{{$cart['qty']}} x {{PriceHelper::setCurrencyPrice($cart['main_price'])}}</span>
    @foreach ($cart['attribute']['option_name'] as $optionkey => $option_name)
    <span class="att"><em>{{$cart['attribute']['names'][$optionkey]}}:</em> {{$option_name}}
      ({{PriceHelper::setCurrencyPrice($cart['attribute']['option_price'][$optionkey])}})</span>
    @endforeach

  </div>
  <div class="entry-delete"><a href="{{route('front.cart.destroy', $key)}}"><i class="icon-x"></i></a></div>
  {{-- <div class="p-action-button mt-5">
    <div class="d-flex align-items-center gap-2">
      <div class="form-group d-flex" style="width: 90px;">
        <button type="button" onclick="cartQuantity('{{ $key }}', -1)"
          style="border: none; background: none; font-size: 20px;">−</button>

        <input type="text" name="Cartquantity" id="Cartquantity_{{ $key }}" class="form-control text-center" value="1"
          style="width: 50px; height: 30px;" readonly />


        <button type="button" onclick="cartQuantity('{{ $key }}', 1)"
          style="border: none; background: none; font-size: 20px;">+</button>
      </div>
    </div>
  </div> --}}

</div>

@endforeach


<div class="text-right">
  <p class="text-gray-dark py-2 mb-0"><span class="text-muted">{{__('Subtotal')}}:</span>
    {{PriceHelper::setCurrencyPrice($grandSubtotal + $bundle_discount_total)}}</p>
  @if($bundle_discount_total > 0)
    <p class="text-danger py-1 mb-0"><span class="text-muted">{{__('Bundle Discount')}}:</span>
      {{PriceHelper::setCurrencyPrice($bundle_discount_total)}}</p>
  @endif
</div>
<div class="d-flex justify-content-between">
  <div class="w-50 d-block"><a class="btn btn-primary btn-sm  mb-0"
      href="{{route('front.cart')}}"><span>{{__('Cart')}}</span></a></div>
  <div class="w-50 d-block text-end"><a class="btn btn-primary btn-sm  mb-0"
      href="{{route('front.checkout.billing')}}"><span>{{__('Checkout')}}</span></a></div>
  @else
  {{__('Cart empty')}}
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