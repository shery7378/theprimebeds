@extends('master.front')
@section('title')
    {{__('My Merchant Products')}}
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
                    <li>{{__('My Products')}} </li>
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

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">{{__('My Store Products')}}</h5>
                            <p class="mb-0 text-muted">{{__('Manage the products currently active on your storefront.')}}</p>
                        </div>
                        <a href="{{route('user.merchant.catalog')}}" class="btn btn-primary"><i class="icon-plus"></i> {{__('Add Products')}}</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>{{__('Product')}}</th>
                                    <th>{{__('Base Price')}}</th>
                                    <th>{{__('My Selling Price')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Store Link')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($merchantProducts as $mProduct)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{asset('assets/img/'.$mProduct->item->photo)}}" width="50" class="mr-2" style="object-fit: cover;">
                                            <span>{{$mProduct->item->name}}</span>
                                        </div>
                                    </td>
                                    <td>{{\App\Helpers\PriceHelper::setCurrencyPrice($mProduct->item->discount_price)}}</td>
                                    <td>
                                        <form action="{{route('user.merchant.product.update')}}" method="POST" class="d-flex">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{$mProduct->item->id}}">
                                            <input type="number" step="0.01" class="form-control form-control-sm mr-2" name="merchant_price" required min="{{\App\Helpers\PriceHelper::convertPrice($mProduct->item->discount_price)}}" value="{{\App\Helpers\PriceHelper::convertPrice($mProduct->merchant_price)}}" style="width: 100px;">
                                            <button type="submit" class="btn btn-primary btn-sm m-0">{{__('Update')}}</button>
                                        </form>
                                    </td>
                                    <td>
                                        @if($mProduct->status == 'approved')
                                            <span class="badge badge-success">{{__('Approved')}}</span>
                                        @elseif($mProduct->status == 'rejected')
                                            <span class="badge badge-danger">{{__('Rejected')}}</span>
                                        @else
                                            <span class="badge badge-warning text-dark">{{__('Pending')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($mProduct->status == 'approved')
                                        <a href="{{route('front.merchant.product', ['store_name' => $user->store_name, 'slug' => $mProduct->item->slug])}}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="icon-external-link"></i> {{__('View')}}
                                        </a>
                                        @else
                                        <span class="text-muted small">{{__('Not live yet')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route('user.merchant.product.remove', $mProduct->item_id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm m-0"><i class="icon-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{__('You have no products in your store.')}}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{$merchantProducts->links()}}
                    </div>
                </div>
            </div>

          </div>
        </div>
  </div>
@endsection
