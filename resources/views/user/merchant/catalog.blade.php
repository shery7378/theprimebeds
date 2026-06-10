@extends('master.front')
@section('title')
    {{__('Merchant Catalog')}}
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
         @include('includes.user_sitebar')
          <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>

            <div class="card">
                <div class="card-body">
                    <h5>{{__('Browse Products to Sell')}}</h5>
                    <p>{{__('Select products below and add your custom selling price.')}}</p>
                    
                    <div class="row">
                        @foreach($items as $item)
                        <div class="col-md-6 mb-4">
                            <div class="card border">
                                <img src="{{asset('assets/img/'.$item->photo)}}" class="card-img-top" alt="{{$item->name}}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{$item->name}}</h6>
                                    <p class="card-text text-muted">
                                        {{__('Base Price:')}} {{\App\Helpers\PriceHelper::setCurrencyPrice($item->discount_price)}}
                                    </p>
                                    
                                    <form action="{{route('user.merchant.product.update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{$item->id}}">
                                        <div class="form-group">
                                            <label>{{__('Your Selling Price')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{\App\Helpers\PriceHelper::setCurrencySign()}}</span>
                                                </div>
                                                <input type="number" step="0.01" class="form-control" name="merchant_price" required min="{{\App\Helpers\PriceHelper::convertPrice($item->discount_price)}}" value="{{\App\Helpers\PriceHelper::convertPrice($item->discount_price)}}">
                                            </div>
                                            <small class="form-text text-muted">{{__('Must be at least base price')}}</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">{{__('Add to My Store')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{$items->links()}}
                    </div>
                </div>
            </div>

          </div>
        </div>
  </div>
@endsection
