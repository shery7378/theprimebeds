@extends('master.back')

@section('content')
<style>
    /* Premium Table and Dashboard Styling */
    .proposals-card {
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
        background: #ffffff !important;
    }
    .gd-responsive-table {
        overflow-x: auto !important;
        width: 100% !important;
    }
    .proposals-table {
        min-width: 900px !important;
        width: 100% !important;
        margin: 0 !important;
    }
    .proposals-table th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 0.82rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border-bottom: 2px solid #e2e8f0 !important;
        padding: 16px 20px !important;
        vertical-align: middle !important;
    }
    .proposals-table td {
        padding: 16px 20px !important;
        vertical-align: middle !important;
        color: #334155 !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .merchant-profile-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .merchant-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.05rem;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
        flex-shrink: 0;
    }
    .merchant-info-title {
        font-size: 0.92rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 2px;
    }
    .merchant-meta-item {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .merchant-meta-item i {
        width: 14px;
        color: #94a3b8;
    }
    .store-badge {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        padding: 2px 8px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.72rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .product-thumb-premium {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    .product-title-premium {
        font-size: 0.88rem;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.35;
        margin-bottom: 2px;
    }
    .sku-code {
        font-family: inherit;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .price-badge-base {
        font-weight: 600;
        color: #64748b;
        font-size: 0.9rem;
    }
    .price-badge-proposed {
        font-weight: 700;
        color: #059669;
        font-size: 1rem;
        background: #ecfdf5;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        border: 1px solid #a7f3d0;
    }
    .status-badge-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 4px 10px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge-approved {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 4px 10px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge-rejected {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 4px 10px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-action-approve {
        background: #10b981;
        color: #ffffff !important;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.78rem;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }
    .btn-action-approve:hover {
        background: #059669;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        transform: translateY(-1px);
        text-decoration: none;
    }
    .btn-action-reject {
        background: #ef4444;
        color: #ffffff !important;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.78rem;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }
    .btn-action-reject:hover {
        background: #dc2626;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        transform: translateY(-1px);
        text-decoration: none;
    }
    /* Filter & Search Bar Styling */
    .filter-wrapper select, 
    .filter-wrapper input {
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 8px 12px !important;
        height: auto !important;
        font-size: 0.85rem !important;
        color: #334155 !important;
        transition: all 0.2s;
    }
    .filter-wrapper select:focus, 
    .filter-wrapper input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .btn-search-submit {
        background: #3b82f6 !important;
        color: #ffffff !important;
        border: 1px solid #3b82f6 !important;
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    .btn-search-submit:hover {
        background: #2563eb !important;
        border-color: #2563eb !important;
    }
</style>

<div class="container-fluid">
    <div class="card mb-4 proposals-card">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Merchant Price Proposals') }}</b></h3>
                <form action="{{ route('back.merchant.all_proposals') }}" method="GET" class="form-inline mt-2 mt-sm-0 filter-wrapper">
                    <div class="form-group mr-2">
                        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">{{ __('All Statuses') }}</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search merchant or product...') }}" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-search-submit" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 proposals-card">
        <div class="card-body">
            @include('alerts.alerts')
            <div class="gd-responsive-table">
                <table class="table proposals-table" id="proposals-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Merchant Name') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Base Price') }}</th>
                            <th>{{ __('Proposed Price') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $mp)
                        @php
                            $basePrice = $mp->item->purchase_price > 0 ? $mp->item->purchase_price : $mp->item->discount_price;
                        @endphp
                        <tr>
                            <td>
                                <div class="merchant-info-title">{{ $mp->user->first_name }} {{ $mp->user->last_name }}</div>
                            </td>
                            <td>
                                @if($mp->item->photo)
                                <img src="{{ asset('assets/img/'.$mp->item->photo) }}" class="product-thumb-premium">
                                @else
                                <span class="text-muted">--</span>
                                @endif
                            </td>
                            <td>
                                <div class="product-title-premium">{{ $mp->item->name }}</div>
                            </td>
                            <td><span class="price-badge-base">{{ \App\Helpers\PriceHelper::setCurrencyPrice($basePrice) }}</span></td>
                            <td><span class="price-badge-proposed">{{ \App\Helpers\PriceHelper::setCurrencyPrice($mp->merchant_price) }}</span></td>
                            <td>
                                @if($mp->status === 'pending')
                                    <span class="status-badge-pending"><i class="fas fa-clock"></i>{{ __('Pending') }}</span>
                                @elseif($mp->status === 'approved')
                                    <span class="status-badge-approved"><i class="fas fa-check-circle"></i>{{ __('Approved') }}</span>
                                @elseif($mp->status === 'rejected')
                                    <span class="status-badge-rejected"><i class="fas fa-times-circle"></i>{{ __('Rejected') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($mp->status === 'pending')
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        <a href="{{ route('back.merchant.approve', $mp->id) }}" class="btn-action-approve" onclick="return confirm('{{ __('Approve this price proposal?') }}')">
                                            <i class="fas fa-check"></i> {{ __('Approve') }}
                                        </a>
                                        <a href="{{ route('back.merchant.reject', $mp->id) }}" class="btn-action-reject" onclick="return confirm('{{ __('Reject this price proposal?') }}')">
                                            <i class="fas fa-times"></i> {{ __('Reject') }}
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted">--</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-box-open fa-3x mb-3 d-block text-gray-400"></i>
                                <h5>{{ __('No proposals found.') }}</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $proposals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
