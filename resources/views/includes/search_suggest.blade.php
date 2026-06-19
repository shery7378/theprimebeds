
@if ($items->count() > 0)
<div class="s-r-inner">
    @foreach ($items as $item)
    <div class="product-card p-col">
        <a class="product-thumb" href="{{route('front.product',$item->slug)}}">
            <img class="lazy" alt="Product" src="{{url('assets/img/'.$item->thumbnail)}}" style=""></a>
        <div class="product-card-body">
            <h3 class="product-title"><a href="{{route('front.product',$item->slug)}}">
                {{ Str::limit($item->name, 35) }}
            </a></h3>
            {{-- <div class="rating-stars">
                {!! Helper::renderStarRating($item->reviews->avg('rating')) !!}
            </div> --}}
            <h4 class="product-price">
                {{PriceHelper::grandCurrencyPrice($item)}}
            </h4>
        </div>
    </div>
    @endforeach
    
</div>
<div class="bottom-area">
    <a id="view_all_search_" href="javascript:;">{{ __('View all result') }}</a>
</div>
@else
<div class="s-r-inner" style="display: flex; align-items: center; justify-content: center; padding: 24px 15px; min-height: 80px;">
    <p style="margin: 0; font-family: 'Outfit', sans-serif; font-size: 14px; color: #796e65; font-weight: 500; text-align: center;">
        <i class="fas fa-search-minus" style="margin-right: 6px; color: #c4b8a7;"></i>
        {{ __('No search results found') }}
    </p>
</div>
@endif