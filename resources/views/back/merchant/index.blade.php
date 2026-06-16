@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Merchant List') }}</b></h3>
                <div class="d-flex">
                    <a href="{{ route('back.merchant.pending_prices') }}" class="btn btn-warning btn-sm mr-2">
                        {{ __('Pending Prices') }}
                    </a>
                    <a href="{{ route('back.merchant.payouts') }}" class="btn btn-info btn-sm">
                        {{ __('Payouts') }}
                    </a>
                </div>
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
                            <th>{{ __('Merchant Info') }}</th>
                            <th>{{ __('Store Name') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Earnings Balance') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($merchants as $merchant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $merchant->first_name }} {{ $merchant->last_name }}</strong><br>
                                <small class="text-muted">{{ $merchant->email }}</small>
                            </td>
                            <td>
                                <a href="{{ route('front.merchant.store', $merchant->store_name) }}" target="_blank" class="badge badge-info">
                                    {{ $merchant->store_name }} <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </td>
                            <td>{{ $merchant->phone }}</td>
                            <td>
                                <strong class="text-success">
                                    {{ \App\Helpers\PriceHelper::setCurrencyPrice($merchant->earnings_balance) }}
                                </strong>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-secondary btn-sm mr-1" href="{{ route('back.user.show', $merchant->id) }}" title="{{ __('View Profile') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('back.merchant.payout_history', $merchant->id) }}" class="btn btn-dark btn-sm" title="{{ __('Payout History') }}">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-store fa-2x mb-2 d-block"></i>
                                {{ __('No merchants registered yet.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $merchants->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
