@extends('master.front')
@section('title')
    {{ $merchant->first_name }}'s Store
@endsection
@section('meta')
    <meta name="keywords" content="{{ $merchant->first_name }}, store, products">
    <meta name="description" content="Shop products from {{ $merchant->first_name }}'s store">
@endsection
@section('content')

<!-- Page Title-->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
                    <li class="separator"></li>
                    <li>{{ $merchant->first_name }}'s {{__('Store')}}</li>
                  </ul>
            </div>
        </div>
    </div>
</div>

  <!-- Page Content-->
<div class="container padding-bottom-3x mb-1">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3>{{__('Welcome to')}} {{ $merchant->first_name }}'s {{__('Store')}}</h3>
            <p class="text-muted">{{__('Browse their curated collection of products.')}}</p>
        </div>
    </div>

    <div class="row">
        @forelse($merchantProducts as $mProduct)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="product-card">
                @if ($mProduct->item->is_stock())
                    <div class="product-badge bg-success">{{__('In Stock')}}</div>
                @else
                    <div class="product-badge bg-secondary border-default text-body">{{__('Out of stock')}}</div>
                @endif

                @if($mProduct->item->is_type == 'feature')
                <div class="product-badge bg-warning" style="margin-top: 25px;">{{__('Feature')}}</div>
                @endif
                
                <a class="product-thumb" href="{{route('front.merchant.product', ['store_name' => $merchant->store_name, 'slug' => $mProduct->item->slug])}}">
                    <img src="{{asset('assets/img/'.$mProduct->item->photo)}}" alt="{{$mProduct->item->name}}" style="height: 250px; object-fit: cover;">
                </a>
                
                <div class="product-card-body">
                    <div class="product-category"><a href="#">{{$mProduct->item->category->name ?? ''}}</a></div>
                    <h3 class="product-title"><a href="{{route('front.merchant.product', ['store_name' => $merchant->store_name, 'slug' => $mProduct->item->slug])}}">{{ strlen(strip_tags($mProduct->item->name)) > 35 ? substr(strip_tags($mProduct->item->name), 0, 35) . '...' : strip_tags($mProduct->item->name) }}</a></h3>
                    <h4 class="product-price">
                        {{\App\Helpers\PriceHelper::setCurrencyPrice($mProduct->merchant_price)}}
                    </h4>
                </div>
                <div class="product-button-group">
                    <a class="product-button" href="{{route('front.merchant.product', ['store_name' => $merchant->store_name, 'slug' => $mProduct->item->slug])}}">
                        <i class="icon-arrow-right"></i><span>{{__('Details')}}</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <h4 class="text-muted">{{__('This merchant has not added any products to their store yet.')}}</h4>
        </div>
        @endforelse
    </div>

    <!-- Pagination-->
    <div class="row mt-15" id="item_pagination">
        <div class="col-lg-12 text-center">
            {{$merchantProducts->links()}}
        </div>
    </div>
</div>
@endsection
