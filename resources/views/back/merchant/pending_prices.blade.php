@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Pending Merchant Price Proposals') }}</b></h3>
                <a href="{{ route('back.merchant.payouts') }}" class="btn btn-info btn-sm">{{ __('Merchant Payouts') }}</a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @include('alerts.alerts')
            <div class="gd-responsive-table">
                <table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Merchant') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Base Price') }}</th>
                            <th>{{ __('Proposed Price') }}</th>
                            <th>{{ __('Submitted') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingProducts as $mp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div>
                                    <strong>{{ $mp->user->first_name }} {{ $mp->user->last_name }}</strong><br>
                                    <small class="text-muted">{{ $mp->user->email }}</small><br>
                                    <small><span class="badge badge-secondary">{{ $mp->user->store_name }}</span></small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($mp->item->photo)
                                    <img src="{{ asset('assets/img/'.$mp->item->photo) }}" width="45" class="mr-2 rounded" style="object-fit:cover; height:45px;">
                                    @endif
                                    <span>{{ $mp->item->name }}</span>
                                </div>
                            </td>
                            <td>{{ \App\Helpers\PriceHelper::setCurrencyPrice($mp->item->discount_price) }}</td>
                            <td><strong class="text-success">{{ \App\Helpers\PriceHelper::setCurrencyPrice($mp->merchant_price) }}</strong></td>
                            <td><small>{{ $mp->updated_at->diffForHumans() }}</small></td>
                            <td>
                                <a href="{{ route('back.merchant.approve', $mp->id) }}" class="btn btn-success btn-sm" onclick="return confirm('{{ __('Approve this price?') }}')">
                                    <i class="fas fa-check"></i> {{ __('Approve') }}
                                </a>
                                <a href="{{ route('back.merchant.reject', $mp->id) }}" class="btn btn-danger btn-sm ml-1" onclick="return confirm('{{ __('Reject this price?') }}')">
                                    <i class="fas fa-times"></i> {{ __('Reject') }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success d-block"></i>
                                {{ __('No pending price proposals. All clear!') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $pendingProducts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
