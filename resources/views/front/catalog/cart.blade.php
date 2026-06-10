@extends('master.front')
@section('title')
    {{__('Cart')}}
@endsection
@section('meta')
<meta name="keywords" content="{{$setting->meta_keywords}}">
<meta name="description" content="{{$setting->meta_description}}">
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
                    <li>{{__('Cart')}}</li>
                  </ul>
            </div>
        </div>
    </div>
  </div>

  @if(Session::has('cart') && count(Session::get('cart')) > 0)
  <div class="container  padding-bottom-3x mb-1">

    <!-- Shopping Cart-->
    <div id="view_cart_load">
        @include('includes.cart')
    </div>

</div>
  @else
  <div class="container padding-bottom-3x mb-1">
    <div class="card border-0 shadow-sm rounded-lg text-center" style="padding: 4rem 2rem;">
      <div class="card-body">
        <div class="mb-4 text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart" style="opacity: 0.5;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <h3 class="card-title font-weight-bold mb-3">{{__('Your shopping cart is empty.')}}</h3>
        <p class="text-muted mb-4">{{__('Looks like you haven\'t added any items to the cart yet.')}}</p>
       <a class="btn btn-primary rounded-pill px-4 shadow-sm" href="{{route('front.catalog')}}"><i class="icon-package pr-2"></i>{{__('View our products')}}</a></div>
      </div>
    </div>
  @endif
  <!-- Page Content-->


@endsection

