@php
    $user = Auth::user();
    $currentRoute = request()->path();
@endphp

<div class="col-lg-4 mb-4">

    {{-- ===== MERCHANT PROFILE CARD ===== --}}
    <div class="merchant-profile-card mb-3">
        <div class="merchant-profile-bg"></div>
        <div class="merchant-profile-body">
            <div class="merchant-avatar-wrap">
                <img id="avater_photo_view"
                     src="{{ $user->photo ? url('assets/img/'.$user->photo) : url('assets/img/placeholder.png') }}"
                     alt="Merchant Avatar"
                     class="merchant-avatar">
                <span class="merchant-badge-dot"></span>
                <button type="button" class="merchant-avatar-edit" onclick="document.getElementById('merchant_avatar_upload').click()" title="{{ __('Edit Avatar') }}">
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
            </div>

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" id="merchant_avatar_form" style="display:none;">
                @csrf
                <input type="file" name="photo" id="merchant_avatar_upload" accept="image/jpeg,image/jpg,image/png,image/svg+xml" onchange="document.getElementById('merchant_avatar_form').submit();">
                <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="hidden" name="phone" value="{{ $user->phone }}">
            </form>
            <h5 class="merchant-name">{{ $user->first_name }} {{ $user->last_name }}</h5>
            <span class="merchant-role-tag">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-right:4px;margin-bottom:2px"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                {{ __('Merchant') }}
            </span>
            @if($user->store_name)
            <div class="mt-2">
                <a href="{{ route('front.merchant.store', $user->store_name) }}" target="_blank" class="merchant-store-link">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    {{ $user->store_name }}
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== NAVIGATION ===== --}}
    <nav class="merchant-nav">
        <a href="{{ route('user.merchant.dashboard') }}"
           class="merchant-nav-item {{ request()->is('user/merchant/dashboard') ? 'active' : '' }}">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </span>
            <span>{{ __('Dashboard') }}</span>
        </a>

        <a href="{{ route('user.merchant.my_products') }}"
           class="merchant-nav-item {{ request()->is('user/merchant/my-products') ? 'active' : '' }}">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </span>
            <span>{{ __('My Products') }}</span>
        </a>

        <a href="{{ route('user.merchant.catalog') }}"
           class="merchant-nav-item {{ request()->is('user/merchant/catalog') ? 'active' : '' }}">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </span>
            <span>{{ __('Browse Catalog') }}</span>
        </a>

        <a href="{{ route('user.profile') }}"
           class="merchant-nav-item {{ request()->is('user/profile') ? 'active' : '' }}">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </span>
            <span>{{ __('Profile Settings') }}</span>
        </a>

        <a href="{{ route('user.ticket') }}"
           class="merchant-nav-item {{ request()->is('user/ticket') ? 'active' : '' }}">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </span>
            <span>{{ __('Support') }}</span>
        </a>

        <div class="merchant-nav-divider"></div>

        <a href="javascript:;" class="merchant-nav-item text-danger remove-account" data-bs-toggle="modal" data-bs-target=".modal-merchant">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </span>
            <span>{{ __('Delete Account') }}</span>
        </a>

        <a href="{{ route('user.logout') }}" class="merchant-nav-item text-muted">
            <span class="merchant-nav-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </span>
            <span>{{ __('Log Out') }}</span>
        </a>
    </nav>

    {{-- DELETE ACCOUNT MODAL --}}
    <div class="modal modal-merchant" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">{{ __('Delete Account') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted">{{ __('This will permanently remove your merchant account and all associated data. This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a href="{{ route('user.account.remove') }}" class="btn btn-danger">{{ __('Yes, Delete') }}</a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ===== MERCHANT SIDEBAR STYLES ===== --}}
<style>
/* === PRIME BEDS BRAND VARIABLES === */
:root {
    --pb-navy:      #1a3a5c;
    --pb-navy-dark: #0f2540;
    --pb-navy-mid:  #244e7a;
    --pb-gold:      #c9a84c;
    --pb-gold-light:#e8cc82;
    --pb-gold-pale: #fdf6e3;
    --pb-gold-bg:   #f7efd4;
    --pb-navy-pale: #e8eef5;
}

/* === PROFILE CARD === */
.merchant-profile-card {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(26,58,92,.16);
    background: #fff;
    position: relative;
}
.merchant-profile-bg {
    height: 80px;
    background: linear-gradient(135deg, var(--pb-navy-dark) 0%, var(--pb-navy) 55%, var(--pb-navy-mid) 100%);
    position: relative;
    overflow: hidden;
}
.merchant-profile-bg::after {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 100px; height: 100px;
    background: rgba(201,168,76,.15);
    border-radius: 50%;
}
.merchant-profile-body {
    padding: 0 20px 22px;
    text-align: center;
    position: relative;
}
.merchant-avatar-wrap {
    position: relative;
    display: inline-block;
    margin-top: -38px;
    margin-bottom: 10px;
}
.merchant-avatar {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    border: 4px solid #fff;
    background-color: #fff;
    object-fit: cover;
    object-position: center;
    box-shadow: 0 4px 14px rgba(26,58,92,.22);
    display: block;
}
.merchant-badge-dot {
    position: absolute;
    bottom: 5px; left: 5px;
    width: 14px; height: 14px;
    background: #22c55e;
    border-radius: 50%;
    border: 2px solid #fff;
}
.merchant-avatar-edit {
    position: absolute;
    bottom: 2px; right: 2px;
    width: 20px; height: 20px;
    background: #fff;
    border-radius: 50%;
    border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center;
    color: #4b5563;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: all .2s;
    padding: 0;
    z-index: 10;
}
.merchant-avatar-edit:hover {
    color: var(--pb-navy);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transform: scale(1.05);
}
.merchant-name {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--pb-navy-dark);
    margin-bottom: 4px;
}
.merchant-role-tag {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, var(--pb-gold), var(--pb-gold-light));
    color: var(--pb-navy-dark);
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
    letter-spacing: .05em;
    text-transform: uppercase;
}
.merchant-store-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.82rem;
    color: var(--pb-navy);
    font-weight: 500;
    text-decoration: none;
    padding: 4px 12px;
    background: var(--pb-navy-pale);
    border-radius: 20px;
    transition: background .2s;
}
.merchant-store-link:hover {
    background: #c8d8e8;
    color: var(--pb-navy-dark);
    text-decoration: none;
}

/* === NAVIGATION === */
.merchant-nav {
    background: #fff;
    border-radius: 20px;
    padding: 10px 8px;
    box-shadow: 0 4px 24px rgba(26,58,92,.10);
}
.merchant-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 12px;
    font-size: 0.93rem;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    transition: all .18s ease;
    margin-bottom: 2px;
    cursor: pointer;
}
.merchant-nav-item:hover {
    background: var(--pb-navy-pale);
    color: var(--pb-navy);
    text-decoration: none;
    transform: translateX(3px);
}
.merchant-nav-item.active {
    background: linear-gradient(135deg, var(--pb-navy-dark), var(--pb-navy));
    color: #fff !important;
    box-shadow: 0 4px 14px rgba(26,58,92,.30);
}
.merchant-nav-item.active .merchant-nav-icon {
    background: rgba(201,168,76,.25);
    color: var(--pb-gold-light);
}
.merchant-nav-icon {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px;
    background: #f3f4f6;
    flex-shrink: 0;
    transition: all .18s;
}
.merchant-nav-item:hover .merchant-nav-icon {
    background: var(--pb-navy-pale);
    color: var(--pb-navy);
}
.merchant-nav-item.text-danger:hover {
    background: #fef2f2;
    color: #ef4444 !important;
}
.merchant-nav-item.text-danger:hover .merchant-nav-icon {
    background: #fee2e2;
}
.merchant-nav-item.text-muted:hover {
    background: #f9fafb;
    color: #6b7280 !important;
}
.merchant-nav-divider {
    height: 1px;
    background: #f0f0f0;
    margin: 8px 6px;
}
</style>
