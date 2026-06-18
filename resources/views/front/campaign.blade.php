@extends('master.front')

@section('title')
    {{__('Campaign Product')}}@if(isset($category)) - {{ $category->name }}@endif
@endsection

@section('meta')
<meta name="keywords" content="{{$setting->meta_keywords}}">
<meta name="description" content="{{$setting->meta_description}}">
@endsection

@section('content')
<div class="page-title">
    <div class="container">
      <div class="row">
          <div class="col-lg-12">
            <ul class="breadcrumbs">
                <li><a href="{{route('front.index')}}">{{__('Home')}}</a>
                </li>
                <li class="separator"></li>
                <li><a href="{{route('front.campaign')}}">{{__('Campaign Products')}}</a>
                </li>
                @if(isset($category))
                    <li class="separator"></li>
                    <li><a href="{{route('front.campaign', ['category' => $category->slug])}}">{{ $category->name }}</a></li>
                @endif
              </ul>
          </div>
      </div>
    </div>
  </div>
  <!-- Page Content-->

    {{-- Deal of day / campaign products listing --}}
    <div class="deal-of-day-section pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2 class="h3">{{ $setting->campaign_title }}@if(isset($category)) - {{ $category->name }}@endif</h2>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                @foreach ($campaign_items as $compaign_item)
                <div class="col-gd">
                <div class="product-card">
                    <div class="product-thumb">
                        @if (!$compaign_item->item->is_stock())
                            <div class="product-badge bg-secondary border-default text-body">{{__('out of stock')}}</div>
                        @endif

                            @php $discPct = PriceHelper::DiscountPercentage($compaign_item->item); @endphp
                            @if($discPct)
                            <div class="product-badge product-badge2 bg-info">-{{ $discPct }}</div>
                            @endif

                        <img src="{{url('assets/img/'.$compaign_item->item->thumbnail)}}" alt="Product">
                        <div class="product-button-group">
                            <a class="product-button wishlist_store" href="{{route('user.wishlist.store',$compaign_item->item->id)}}" title="{{__('Wishlist')}}"><i class="icon-heart"></i></a>
                            <a data-target="{{route('fornt.compare.product',$compaign_item->item->id)}}" class="product-button product_compare" href="javascript:;" title="{{__('Compare')}}"><i class="icon-repeat"></i></a>
                            @include('includes.item_footer',['sitem' => $compaign_item->item])
                        </div>
                    </div>
                    <div class="product-card-body">

                        <div class="product-category"><a href="{{route('front.catalog').'?category='.$compaign_item->item->category->slug}}">{{$compaign_item->item->category->name}}</a></div>
                        <h3 class="product-title"><a href="{{route('front.product',$compaign_item->item->slug)}}">
                            {{ Str::limit($compaign_item->item->name, 35) }}
                        </a></h3>
                        {{-- <div class="rating-stars">
                            {!! Helper::renderStarRating($compaign_item->item->reviews->avg('rating')) !!}
                        </div> --}}
                        <h4 class="product-price">
                        @if ($compaign_item->item->previous_price != 0)
                        <del>{{PriceHelper::setPreviousPrice($compaign_item->item->previous_price)}}</del>
                        @endif
                        {{PriceHelper::grandCurrencyPrice($compaign_item->item)}}
                        </h4>

                    </div>

                </div>
            </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection
