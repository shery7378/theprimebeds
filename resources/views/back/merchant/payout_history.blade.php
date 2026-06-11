@extends('master.back')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-0 bc-title">
                        <b>{{ __('Payout History') }} &mdash; {{ $merchant->first_name }} {{ $merchant->last_name }}</b>
                    </h3>
                    <small class="text-muted">{{ $merchant->email }} &bull; Store: {{ $merchant->store_name }}</small>
                </div>
                <a href="{{ route('back.merchant.payouts') }}" class="btn btn-secondary btn-sm">
                    &larr; {{ __('Back to Payouts') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="gd-responsive-table">
                <table class="table table-bordered table-striped" id="admin-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Note') }}</th>
                            <th>{{ __('Paid At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $payout)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong class="text-success">{{ \App\Helpers\PriceHelper::setCurrencyPrice($payout->amount) }}</strong></td>
                            <td>{{ $payout->note ?: '—' }}</td>
                            <td>{{ $payout->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">{{ __('No payout history yet.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $history->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
