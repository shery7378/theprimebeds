@extends('master.back')

@section('content')

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Merchant Dashboard') }}</b></h3>
                <div class="d-flex align-items-center">
                    <span class="badge badge-info mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                        <i class="fas fa-store mr-1"></i> {{ $user->store_name }}
                    </span>
                    <a href="{{ route('front.merchant.store', $user->store_name) }}" target="_blank" class="btn btn-secondary btn-sm">
                        <i class="fas fa-external-link-alt mr-1"></i> {{ __('View Store') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('alerts.alerts')

    <!-- Stats Cards -->
    <div class="row">
        <!-- Earnings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats card-round shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small" style="background: linear-gradient(135deg, #2ecc71, #27ae60); color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="mb-0 text-muted"><b>{{ __('Total Earnings') }}</b></p>
                                <h4 class="card-title font-weight-bold text-success">{{ \App\Helpers\PriceHelper::setCurrencyPrice($totalEarnings) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats card-round shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small" style="background: linear-gradient(135deg, #3498db, #2980b9); color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="mb-0 text-muted"><b>{{ __('Active Products') }}</b></p>
                                <h4 class="card-title font-weight-bold text-info">{{ $activeProductsCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats card-round shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small" style="background: linear-gradient(135deg, #f1c40f, #f39c12); color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="mb-0 text-muted"><b>{{ __('Pending Approval') }}</b></p>
                                <h4 class="card-title font-weight-bold text-warning">{{ $pendingProductsCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejected Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats card-round shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="mb-0 text-muted"><b>{{ __('Rejected Products') }}</b></p>
                                <h4 class="card-title font-weight-bold text-danger">{{ $rejectedProductsCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('My Recent Listed Products') }}</h6>
                </div>
                <div class="card-body">
                    @if($recentProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Base Price') }}</th>
                                    <th>{{ __('My Selling Price') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProducts as $mProduct)
                                <tr>
                                    <td>
                                        <img src="{{ asset('assets/images/'.$mProduct->item->photo) }}" alt="" style="width: 50px; height: auto;">
                                    </td>
                                    <td>
                                        <strong>{{ $mProduct->item->name }}</strong>
                                    </td>
                                    <td>
                                        {{ \App\Helpers\PriceHelper::setCurrencyPrice($mProduct->item->discount_price) }}
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            {{ \App\Helpers\PriceHelper::setCurrencyPrice($mProduct->merchant_price) }}
                                        </strong>
                                    </td>
                                    <td>
                                        @if($mProduct->status == 'approved')
                                            <span class="badge badge-success">{{ __('Live / Approved') }}</span>
                                        @elseif($mProduct->status == 'pending')
                                            <span class="badge badge-warning">{{ __('Pending Review') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <p class="mb-0">{{ __('No products listed in your store yet.') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
