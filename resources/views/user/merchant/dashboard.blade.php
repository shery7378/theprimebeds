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
         @include('includes.user_sitebar')
          <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>

                @if(!$user->is_merchant)
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>{{__('Become a Merchant')}}</h4>
                            <p>{{__('Register your store name to start selling products with your own custom pricing.')}}</p>
                            <form action="{{route('user.merchant.become')}}" method="POST" class="mt-4">
                                @csrf
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-6">
                                        <label for="store_name">{{__('Store Name (URL Slug)')}}</label>
                                        <input class="form-control" type="text" id="store_name" name="store_name" required placeholder="my-awesome-store">
                                        <small class="form-text text-muted">{{__('Your store link will be: ')}} {{url('/store')}}/<span id="store_preview">my-awesome-store</span></small>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">{{__('Register as Merchant')}}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>{{__('Welcome to your Merchant Dashboard!')}}</h5>
                                    <p><strong>{{__('Your Store Link:')}}</strong> <a href="{{route('front.merchant.store', $user->store_name)}}" target="_blank">{{route('front.merchant.store', $user->store_name)}}</a></p>
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
                                        <p class="mt-3">{{__('My Products')}}</p>
                                        <h4><b>{{$user->merchantProducts()->count()}}</b></h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-4">
                            <a href="{{route('user.merchant.catalog')}}" class="text-decoration-none text-dark">
                                <div class="card round">
                                    <div class="card-body text-center">
                                        <i class="icon-plus-circle"></i>
                                        <p class="mt-3">{{__('Browse Catalog')}}</p>
                                        <h4><b>{{__('Add')}}</b></h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
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
