@extends('master.front')
@section('title', __('Merchant Catalog'))

@section('content')

<!-- Page Title-->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
                    <li class="separator"></li>
                    <li><a href="{{route('user.merchant.dashboard')}}">{{__('Merchant Dashboard')}}</a> </li>
                    <li class="separator"></li>
                    <li>{{__('Catalog')}} </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Page Content-->
<div class="container padding-bottom-3x mb-1">
    <div class="row">
        @include('includes.merchant_sitebar')
        
        <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>

            <div class="merchant-section-card pb-4">
                <div class="merchant-section-header mb-4">
                    <div>
                        <h5 class="merchant-section-title mb-1" style="font-size: 1.2rem;">
                            <svg width="22" height="22" fill="none" stroke="var(--pb-gold)" viewBox="0 0 24 24" class="mr-2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            {{__('Browse Products to Sell')}}
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">{{__('Select products below and add your custom selling price to list them on your store.')}}</p>
                    </div>
                </div>
                
                <div class="px-4">
                    <div class="row">
                        @foreach($items as $item)
                        <div class="col-md-6 mb-4">
                            <div class="merchant-catalog-card">
                                <div class="catalog-img-wrap">
                                    <img src="{{asset('assets/img/'.$item->photo)}}" alt="{{$item->name}}">
                                    <div class="catalog-price-tag">
                                        <small>{{__('Base')}}</small>
                                        <strong>{{\App\Helpers\PriceHelper::setCurrencyPrice($item->discount_price)}}</strong>
                                    </div>
                                </div>
                                <div class="catalog-body">
                                    <h6 class="catalog-title" title="{{$item->name}}">{{$item->name}}</h6>
                                    
                                    <form action="{{route('user.merchant.product.update')}}" method="POST" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{$item->id}}">
                                        <div class="form-group mb-3">
                                            <label class="catalog-label">{{__('Your Selling Price')}}</label>
                                            <div class="catalog-input-group">
                                                <span class="catalog-currency">{{\App\Helpers\PriceHelper::setCurrencySign()}}</span>
                                                <input type="number" step="0.01" class="catalog-input" name="merchant_price" required min="{{\App\Helpers\PriceHelper::convertPrice($item->discount_price)}}" value="{{\App\Helpers\PriceHelper::convertPrice($item->discount_price)}}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn-merchant-gold btn-block">{{__('Add to My Store')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4 pt-2 border-top">
                        {{$items->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* === CATALOG CARDS === */
.merchant-catalog-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(26,58,92,.08);
    border: 1px solid rgba(26,58,92,.05);
    overflow: hidden;
    transition: all .25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.merchant-catalog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(26,58,92,.15);
    border-color: rgba(201,168,76,.3);
}
.catalog-img-wrap {
    position: relative;
    height: 190px;
    background: #f8fafc;
    overflow: hidden;
}
.catalog-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}
.merchant-catalog-card:hover .catalog-img-wrap img {
    transform: scale(1.05);
}
.catalog-price-tag {
    position: absolute;
    top: 12px; right: 12px;
    background: rgba(26,58,92,.9);
    backdrop-filter: blur(4px);
    color: #fff;
    padding: 6px 12px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1.2;
    box-shadow: 0 4px 10px rgba(0,0,0,.15);
}
.catalog-price-tag small {
    font-size: 0.65rem;
    color: var(--pb-gold-light);
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: .05em;
}
.catalog-price-tag strong {
    font-size: 1rem;
}
.catalog-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.catalog-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--pb-navy-dark);
    margin-bottom: 15px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.catalog-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 6px;
    display: block;
}
.catalog-input-group {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .2s;
}
.catalog-input-group:focus-within {
    border-color: var(--pb-navy);
    box-shadow: 0 0 0 3px rgba(26,58,92,.1);
}
.catalog-currency {
    padding: 10px 14px;
    background: #e2e8f0;
    color: var(--pb-navy-dark);
    font-weight: 700;
}
.catalog-input {
    border: none;
    background: transparent;
    padding: 10px 12px;
    width: 100%;
    font-weight: 700;
    color: var(--pb-navy-dark);
    outline: none;
}
.btn-merchant-gold {
    background: linear-gradient(135deg, var(--pb-gold), #b3913b);
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all .2s;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(201,168,76,.3);
    margin-top: auto;
}
.btn-merchant-gold:hover {
    background: linear-gradient(135deg, #b3913b, #9e7f33);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(201,168,76,.4);
    color: #fff;
}
</style>
@endsection
