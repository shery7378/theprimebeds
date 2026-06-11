@extends('master.front')
@section('title', __('My Merchant Products'))

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

            <div class="merchant-section-card pb-4">
                <div class="merchant-section-header mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="merchant-section-title mb-1" style="font-size: 1.2rem;">
                            <svg width="22" height="22" fill="none" stroke="var(--pb-navy)" viewBox="0 0 24 24" class="mr-2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            {{__('My Store Products')}}
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">{{__('Manage the products currently listed on your storefront.')}}</p>
                    </div>
                    <a href="{{route('user.merchant.catalog')}}" class="btn-merchant-navy">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mr-1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        {{__('Add Products')}}
                    </a>
                </div>
                
                <div class="px-4">
                    <div class="table-responsive merchant-table-wrap">
                        <table class="table merchant-table">
                            <thead>
                                <tr>
                                    <th>{{__('Product')}}</th>
                                    <th>{{__('Base Price')}}</th>
                                    <th>{{__('My Selling Price')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th class="text-right">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($merchantProducts as $mProduct)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="merchant-table-img">
                                                <img src="{{asset('assets/img/'.$mProduct->item->photo)}}" alt="{{$mProduct->item->name}}">
                                            </div>
                                            <span class="merchant-table-title">{{$mProduct->item->name}}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-muted font-weight-bold">
                                        {{\App\Helpers\PriceHelper::setCurrencyPrice($mProduct->item->discount_price)}}
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{route('user.merchant.product.update')}}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{$mProduct->item->id}}">
                                            <div class="merchant-inline-input">
                                                <span>{{\App\Helpers\PriceHelper::setCurrencySign()}}</span>
                                                <input type="number" step="0.01" name="merchant_price" required min="{{\App\Helpers\PriceHelper::convertPrice($mProduct->item->discount_price)}}" value="{{\App\Helpers\PriceHelper::convertPrice($mProduct->merchant_price)}}">
                                            </div>
                                            <button type="submit" class="btn-merchant-update ml-2">{{__('Update')}}</button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        @if($mProduct->status == 'approved')
                                            <span class="mps-badge mps-approved">
                                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                                {{__('Live')}}
                                            </span>
                                        @elseif($mProduct->status == 'rejected')
                                            <span class="mps-badge mps-rejected">
                                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                                {{__('Rejected')}}
                                            </span>
                                        @else
                                            <span class="mps-badge mps-pending">
                                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/></svg>
                                                {{__('Pending')}}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-right">
                                        <div class="d-flex justify-content-end align-items-center">
                                            @if($mProduct->status == 'approved')
                                            <a href="{{route('front.merchant.product', ['store_name' => $user->store_name, 'slug' => $mProduct->item->slug])}}" target="_blank" class="merchant-action-btn view-btn mr-2" title="{{__('View in Store')}}">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            @else
                                            <span class="merchant-not-live mr-2" title="{{__('Not live yet')}}">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                            </span>
                                            @endif
                                            
                                            <form action="{{route('user.merchant.product.remove', $mProduct->item_id)}}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="merchant-action-btn delete-btn" title="{{__('Remove')}}">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="merchant-empty-icon mb-3" style="font-size: 2.5rem; opacity: 0.5;">🛒</div>
                                        <h6 class="text-muted">{{__('You have no products in your store.')}}</h6>
                                        <a href="{{route('user.merchant.catalog')}}" class="btn-merchant-navy mt-2">{{__('Browse Catalog')}}</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4 pt-2 border-top">
                        {{$merchantProducts->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* === BUTTONS === */
.btn-merchant-navy {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, var(--pb-navy), var(--pb-navy-mid));
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.88rem;
    transition: all .2s;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(26,58,92,.2);
}
.btn-merchant-navy:hover {
    background: linear-gradient(135deg, var(--pb-navy-dark), var(--pb-navy));
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(26,58,92,.3);
    text-decoration: none;
}

/* === TABLE UI === */
.merchant-table-wrap {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #f1f5f9;
}
.merchant-table {
    margin-bottom: 0;
}
.merchant-table thead th {
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    border-top: none;
    color: #64748b;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    padding: 12px 16px;
}
.merchant-table tbody td {
    padding: 16px;
    vertical-align: middle;
    border-color: #f1f5f9;
}
.merchant-table-img {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 12px;
    background: #f8fafc;
    flex-shrink: 0;
    border: 1px solid #e2e8f0;
}
.merchant-table-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.merchant-table-title {
    font-weight: 600;
    color: var(--pb-navy-dark);
    font-size: 0.9rem;
    line-height: 1.3;
}

/* === INLINE INPUT === */
.merchant-inline-input {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    width: 110px;
    transition: border-color .2s;
}
.merchant-inline-input:focus-within {
    border-color: var(--pb-navy);
}
.merchant-inline-input span {
    padding: 6px 10px;
    background: #e2e8f0;
    color: var(--pb-navy-dark);
    font-weight: 700;
    font-size: 0.85rem;
}
.merchant-inline-input input {
    border: none;
    background: transparent;
    padding: 6px 8px;
    width: 100%;
    font-weight: 700;
    color: var(--pb-navy-dark);
    outline: none;
    font-size: 0.85rem;
}
.btn-merchant-update {
    background: rgba(26,58,92,.1);
    color: var(--pb-navy);
    border: none;
    padding: 7px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all .2s;
}
.btn-merchant-update:hover {
    background: var(--pb-navy);
    color: #fff;
}

/* === ACTION BUTTONS === */
.merchant-action-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all .2s;
    border: none;
    cursor: pointer;
}
.merchant-action-btn.view-btn {
    background: rgba(201,168,76,.15);
    color: var(--pb-gold);
}
.merchant-action-btn.view-btn:hover {
    background: var(--pb-gold);
    color: #fff;
}
.merchant-action-btn.delete-btn {
    background: #fee2e2;
    color: #ef4444;
}
.merchant-action-btn.delete-btn:hover {
    background: #ef4444;
    color: #fff;
}
.merchant-not-live {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
}
</style>
@endsection
