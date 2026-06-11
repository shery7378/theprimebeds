@extends('master.front')
@section('title')
    {{__('Merchant Dashboard')}}
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
                    <li>{{__('Merchant Dashboard')}} </li>
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
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{__('Welcome back,')}} <strong>{{$user->first_name}}!</strong></h5>
                                <p><strong>{{__('Your Store Link:')}}</strong>
                                    <a href="{{route('front.merchant.store', $user->store_name)}}" target="_blank">
                                        {{route('front.merchant.store', $user->store_name)}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row u-d-d">
                    <div class="col-md-4 mb-4">
                        <div class="card round">
                            <div class="card-body text-center">
                                <i class="icon-dollar-sign"></i>
                                <p class="mt-3">{{__('Total Earnings')}}</p>
                                <h4><b>{{\App\Helpers\PriceHelper::setCurrencyPrice($user->earnings_balance)}}</b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <a href="{{route('user.merchant.my_products')}}" class="text-decoration-none text-dark">
                            <div class="card round">
                                <div class="card-body text-center">
                                    <i class="icon-package"></i>
                                    <p class="mt-3">{{__('Active Products')}}</p>
                                    <h4><b>{{$activeProductsCount}}</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-4">
                        <a href="{{route('user.merchant.my_products')}}" class="text-decoration-none text-dark">
                            <div class="card round">
                                <div class="card-body text-center">
                                    <i class="icon-clock"></i>
                                    <p class="mt-3">{{__('Pending Approval')}}</p>
                                    <h4><b>{{$user->merchantProducts()->where('status','pending')->count()}}</b></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
          </div>
        </div>
  </div>

  <script>
      document.getElementById('store_name')?.addEventListener('input', function(e) {
          let val = e.target.value.toLowerCase().replace(/[^a-z0-9-]/g, '-');
          e.target.value = val;
          document.getElementById('store_preview').innerText = val;
      });
  </script>
@endsection
