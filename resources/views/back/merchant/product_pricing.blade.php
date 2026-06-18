@extends('master.back')

@section('content')
<style>
    .gd-responsive-table {
        overflow-x: auto !important;
        width: 100% !important;
    }
    #pricing-table {
        min-width: 900px !important;
        width: 100% !important;
    }
    /* Premium Modal Styling */
    .premium-modal .modal-dialog {
        max-width: 420px;
        margin: 1.75rem auto;
    }
    .premium-modal .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        background: #ffffff;
    }
    .premium-modal .modal-header {
        border-bottom: 1px solid rgba(0,0,0,0.06);
        padding: 14px 20px;
        background: #fdfdfd;
    }
    .premium-modal .modal-title {
        font-size: 1.05rem;
        color: #1e293b;
        font-weight: 700;
    }
    .premium-modal .close {
        color: #94a3b8;
        opacity: 0.8;
        transition: all 0.2s ease;
        outline: none;
        font-size: 1.25rem;
        padding: 1rem 1.25rem;
    }
    .premium-modal .close:hover {
        color: #ef4444;
        transform: rotate(90deg);
    }
    .premium-modal .modal-body {
        padding: 20px;
    }
    .product-preview-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }
    .product-preview-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        border: 2px solid #ffffff;
        transition: transform 0.3s ease;
    }
    .product-preview-image:hover {
        transform: scale(1.05);
    }
    .product-preview-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #0f172a;
        margin-top: 8px;
        margin-bottom: 4px;
    }
    .base-price-badge {
        display: inline-block;
        background: #e0f2fe;
        color: #0369a1;
        padding: 4px 10px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.78rem;
        border: 1px solid #bae6fd;
    }
    .price-input-wrapper {
        position: relative;
    }
    .price-input-label {
        font-weight: 600;
        font-size: 0.78rem;
        color: #475569;
        margin-bottom: 6px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .price-input-wrapper .input-group-text {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-right: none;
        color: #64748b;
        font-weight: 600;
        font-size: 1rem;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        padding-left: 14px;
        padding-right: 14px;
    }
    .price-input-wrapper .form-control {
        border: 1px solid #cbd5e1;
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        padding: 10px 14px;
        height: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01) inset;
        transition: all 0.2s ease-in-out;
    }
    .price-input-wrapper .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        background: #ffffff;
    }
    .premium-modal .modal-footer {
        border-top: 1px solid rgba(0,0,0,0.06);
        padding: 12px 20px;
        background: #fdfdfd;
        gap: 10px;
    }
    .btn-premium-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.82rem;
        transition: all 0.2s;
    }
    .btn-premium-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .btn-premium-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.82rem;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-premium-primary:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        transform: translateY(-1px);
        color: #ffffff;
        text-decoration: none;
    }
    .btn-premium-primary:active {
        transform: translateY(1px);
    }
</style>
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-0 bc-title"><b>{{ __('Product Pricing & Catalog') }}</b></h3>
                <form action="{{ route('back.merchant.product_pricing') }}" method="GET" class="form-inline mt-2 mt-sm-0">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search products...') }}" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @include('alerts.alerts')
            <div class="gd-responsive-table">
                <table class="table table-bordered table-striped" id="pricing-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('SKU') }}</th>
                            <th>{{ __('Base Price') }}</th>
                            <th>{{ __('My Price') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        @php
                            $proposedPrice = $myProposals[$item->id] ?? null;
                            $status = $myStatuses[$item->id] ?? null;
                            $basePrice = $item->purchase_price > 0 ? $item->purchase_price : $item->discount_price;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration + ($items->firstItem() - 1) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->photo)
                                    <img src="{{ asset('assets/img/'.$item->photo) }}" width="45" class="mr-2 rounded" style="object-fit:cover; height:45px;">
                                    @endif
                                    <div>
                                        <strong>{{ $item->name }}</strong><br>
                                        <small class="text-muted">{{ $item->category->name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $item->sku }}</code></td>
                            <td>{{ \App\Helpers\PriceHelper::setCurrencyPrice($basePrice) }}</td>
                            <td>
                                @if($proposedPrice)
                                    <strong class="text-success">{{ \App\Helpers\PriceHelper::setCurrencyPrice($proposedPrice) }}</strong>
                                @else
                                    <span class="text-muted">--</span>
                                @endif
                            </td>
                            <td>
                                @if($status === 'pending')
                                    <span class="badge badge-warning text-white"><i class="fas fa-clock mr-1"></i>{{ __('Pending') }}</span>
                                @elseif($status === 'approved')
                                    <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>{{ __('Approved') }}</span>
                                @elseif($status === 'rejected')
                                    <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i>{{ __('Rejected') }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ __('Not Offered') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#priceModal{{ $item->id }}">
                                        <i class="fas fa-edit mr-1"></i> {{ $proposedPrice ? __('Update Price') : __('Propose Price') }}
                                    </button>

                                    @if($proposedPrice)
                                    <form action="{{ route('back.merchant.delete_price', $item->id) }}" method="POST" class="ml-1" onsubmit="return confirm('{{ __('Are you sure you want to remove this proposal?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Propose Price Modal --}}
                        <div class="modal fade premium-modal" id="priceModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $proposedPrice ? __('Update Price Proposal') : __('Propose Price') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('back.merchant.submit_price') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <div class="modal-body">
                                            <div class="product-preview-card text-center">
                                                @if($item->photo)
                                                <img src="{{ asset('assets/img/'.$item->photo) }}" class="product-preview-image mb-2">
                                                @endif
                                                <div class="product-preview-title">{{ $item->name }}</div>
                                                <div class="mt-2">
                                                    <span class="base-price-badge">{{ __('Base Price:') }} {{ \App\Helpers\PriceHelper::setCurrencyPrice($basePrice) }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group price-input-wrapper">
                                                <label for="merchant_price" class="price-input-label">{{ __('Proposed Price') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">{{ \App\Helpers\PriceHelper::setCurrencySign() }}</span>
                                                    </div>
                                                    <input type="number" step="0.01" name="merchant_price" id="merchant_price" class="form-control" required min="0" value="{{ $proposedPrice ?? $basePrice }}" placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-premium-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                            <button type="submit" class="btn btn-premium-primary">{{ __('Submit Proposal') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                {{ __('No products found.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
