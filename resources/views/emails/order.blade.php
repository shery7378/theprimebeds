<x-mail::message>
# 🛒 Order Received Successfully

{{-- Hi {{ $data[array_key_first($data)]['name'] ?? 'Customer' }},                      
Thank you for your order! Below are your order details: --}}
Hi {{ $data[array_key_first($data)]['name'] ?? 'Customer' }},  
Thank you for your order!

@if (!empty($order->transaction_number))
**🧾 Order ID:** {{ $order->transaction_number }}
@endif

Below are your order details:

@php
    $bundle_discount_total = 0;
    $subtotal = 0;
@endphp

@foreach ($data as $item)
    @php
        $subtotal += $item['price'] * $item['qty'];
        $bundle_discount_total += $item['bundle_discount'] ?? 0;
    @endphp

---

### 📦 {{ $item['name'] }}

@if (!empty($item['photo']) && $item['photo'] !== 'O')
<img src="{{ url('assets/img/' . $item['photo']) }}" width="150">
@endif

- **Qty:** {{ $item['qty'] }}
- **Unit Price:** {{ $currencySign }}{{ $item['price'] }}

@if (!empty($item['preference_description']))
- **Note:** {{ $item['preference_description'] }}
@endif

@endforeach

---
**Subtotal:** {{ $subtotal + $bundle_discount_total }}{{ $currencySign }}

@if($bundle_discount_total > 0)
**Bundle Discount:** -{{ $bundle_discount_total }}{{ $currencySign }}  
@endif

**Order Total:** {{ $subtotal }}{{ $currencySign }}

<x-mail::button :url="url('/')">
Visit Our Website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
