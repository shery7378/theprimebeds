@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Merchant Payouts') }}</b></h3>
                <a href="{{ route('back.merchant.pending_prices') }}" class="btn btn-warning btn-sm">
                    {{ __('Pending Prices') }}
                </a>
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
                            <th>{{ __('Store') }}</th>
                            <th>{{ __('Products') }}</th>
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
                            <td><span class="badge badge-info">{{ $merchant->store_name }}</span></td>
                            <td>{{ $merchant->merchantProducts()->where('status', 'approved')->count() }} {{ __('active') }}</td>
                            <td>
                                <strong class="text-success">
                                    {{ \App\Helpers\PriceHelper::setCurrencyPrice($merchant->earnings_balance) }}
                                </strong>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payModal{{ $merchant->id }}">
                                    <i class="fas fa-money-bill-wave"></i> {{ __('Pay') }}
                                </button>
                                <a href="{{ route('back.merchant.payout_history', $merchant->id) }}" class="btn btn-secondary btn-sm ml-1">
                                    <i class="fas fa-history"></i> {{ __('History') }}
                                </a>
                            </td>
                        </tr>

                        {{-- Pay Modal --}}
                        <div class="modal fade" id="payModal{{ $merchant->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Pay') }} {{ $merchant->first_name }} {{ $merchant->last_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <form action="{{ route('back.merchant.pay') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $merchant->id }}">
                                        <div class="modal-body">
                                            <p>{{ __('Current Balance:') }} <strong class="text-success">{{ \App\Helpers\PriceHelper::setCurrencyPrice($merchant->earnings_balance) }}</strong></p>
                                            <div class="form-group">
                                                <label>{{ __('Amount to Pay') }}</label>
                                                <input type="number" step="0.01" name="amount" class="form-control" required min="0.01" max="{{ $merchant->earnings_balance }}" placeholder="0.00">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Note (optional)') }}</label>
                                                <input type="text" name="note" class="form-control" placeholder="{{ __('e.g. Bank transfer ref #12345') }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                            <button type="submit" class="btn btn-success">{{ __('Confirm Payout') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-store fa-2x mb-2 d-block"></i>
                                {{ __('No merchants found.') }}
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
