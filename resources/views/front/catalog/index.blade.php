@extends('master.front')
@section('meta')
<meta name="keywords" content="{{$setting->meta_keywords}}">
<meta name="description" content="{{$setting->meta_description}}">
@endsection
@section('title')
    {{__('Products')}}
@endsection

@section('content')
<style>
    /* =============================================
       HERO BANNER
    ============================================= */
    .catalog-hero {
        position: relative;
        min-height: 340px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #1a2332;
    }
    .catalog-hero__bg {
        position: absolute;
        inset: 0;
        background: url('{{ asset("assets/img/shop.png") }}') center/cover no-repeat;
        opacity: 0.75;
        transform: scale(1.04);
        transition: transform 8s ease;
    }
    .catalog-hero:hover .catalog-hero__bg {
        transform: scale(1.08);
    }
    .catalog-hero__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(15,25,45,0.35) 0%, rgba(30,50,90,0.25) 100%);
    }
    .catalog-hero__content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 40px 20px;
    }
    .catalog-hero__eyebrow {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.7);
        margin-bottom: 14px;
        border: 1px solid rgba(255,255,255,0.25);
        padding: 5px 16px;
        border-radius: 50px;
        backdrop-filter: blur(4px);
    }
    .catalog-hero__title {
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 800;
        color: #ffffff;
        line-height: 1.15;
        margin: 0 0 14px;
        letter-spacing: -0.5px;
    }
    .catalog-hero__title span {
        background: linear-gradient(135deg, #7eb3ff, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .catalog-hero__subtitle {
        font-size: 16px;
        color: rgba(255,255,255,0.72);
        max-width: 480px;
        margin: 0 auto 28px;
        line-height: 1.65;
    }
    .catalog-hero__breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255,255,255,0.55);
    }
    .catalog-hero__breadcrumb a {
        color: rgba(255,255,255,0.75);
        text-decoration: none;
        transition: color 0.2s;
    }
    .catalog-hero__breadcrumb a:hover { color: #fff; }
    .catalog-hero__breadcrumb i { font-size: 10px; }

    @media (max-width: 768px) {
        .catalog-hero { min-height: 240px; }
    }

    /* =============================================
       FILTER TOOLBAR
    ============================================= */
    .catalog-toolbar {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.07);
        padding: 16px 20px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        border: 1px solid #edf0f5;
    }
    .catalog-toolbar__filters {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        flex: 1 1 auto;
    }
    .catalog-toolbar__label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #a0aec0;
        margin-right: 4px;
        white-space: nowrap;
    }
    #quick_filter {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #quick_filter li a {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        color: #4a5568;
        background: #f4f6f9;
        border: 1.5px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.22s ease;
        white-space: nowrap;
    }
    #quick_filter li a i {
        font-size: 10px;
        opacity: 0.5;
    }
    #quick_filter li a:hover,
    #quick_filter li.active a {
        color: #fff;
        background: linear-gradient(135deg, #1a2332, #2d4270);
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(26,35,50,0.22);
    }
    .catalog-toolbar__right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }
    .catalog-sort-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .catalog-sort-wrap label {
        font-size: 13px;
        font-weight: 600;
        color: #718096;
        white-space: nowrap;
        margin: 0;
    }
    .catalog-sort-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        padding: 7px 32px 7px 14px;
        font-size: 13px;
        font-weight: 500;
        color: #2d3748;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236c7a8d' fill='none' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 12px center;
        -webkit-appearance: none;
        appearance: none;
        cursor: pointer;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .catalog-sort-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
    }
    .catalog-count-badge {
        font-size: 12.5px;
        color: #718096;
        background: #f4f6f9;
        border-radius: 50px;
        padding: 6px 14px;
        font-weight: 500;
        white-space: nowrap;
    }
    .catalog-view-toggle {
        display: flex;
        gap: 4px;
        background: #f4f6f9;
        border-radius: 10px;
        padding: 4px;
    }
    .catalog-view-toggle .list-view {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #a0aec0;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    .catalog-view-toggle .list-view:hover,
    .catalog-view-toggle .list-view.active {
        background: #fff;
        color: #2d3748;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .catalog-toolbar { padding: 12px 14px; }
        .catalog-toolbar__right { width: 100%; justify-content: space-between; }
        .catalog-count-badge { display: none; }
    }

    /* =============================================
       SIDEBAR
    ============================================= */
    .catalog-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .sidebar-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #edf0f5;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .sidebar-card__header {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f1f4f8;
        background: #fafbfd;
    }
    .sidebar-card__icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, #eef3ff, #dde6fa);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f71d9;
        font-size: 14px;
        flex-shrink: 0;
    }
    .sidebar-card__title {
        font-size: 14px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
        letter-spacing: 0.1px;
    }
    .sidebar-card__body {
        padding: 16px 20px;
    }

    /* Category List */
    #category_list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    #category_list > li > a.category_search {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #2d3748;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
    }
    #category_list > li > a.category_search::after {
        content: '\f105';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 12px;
        color: #a0aec0;
        transition: transform 0.2s ease;
    }
    #category_list > li.expanded > a.category_search::after,
    #category_list > li.active > a.category_search::after {
        transform: rotate(90deg);
        color: #4f71d9;
    }
    #category_list > li > a.category_search:hover,
    #category_list > li.active > a.category_search {
        background: #eef3ff;
        color: #2c4ecb;
    }
    #subcategory_list {
        list-style: none;
        padding: 4px 0 4px 14px;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 1px;
    }
    #subcategory_list li a.subcategory {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #4a5568;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    #subcategory_list li a.subcategory::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #cbd5e0;
        flex-shrink: 0;
        transition: background 0.2s;
    }
    #subcategory_list li a.subcategory:hover::before,
    #subcategory_list li.active a.subcategory::before {
        background: #4f71d9;
    }
    #subcategory_list li a.subcategory:hover,
    #subcategory_list li.active a.subcategory {
        background: #f0f4ff;
        color: #2c4ecb;
    }
    #childcategory_list {
        list-style: none;
        padding: 2px 0 2px 18px;
        margin: 0;
    }
    #childcategory_list li a.childcategory {
        display: block;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        color: #718096;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    #childcategory_list li a.childcategory:hover,
    #childcategory_list li.active a.childcategory {
        background: #f0f4ff;
        color: #2c4ecb;
    }
    .category-scroll {
        max-height: 340px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #e2e8f0 transparent;
    }
    .category-scroll::-webkit-scrollbar { width: 4px; }
    .category-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

    /* Price Filter */
    .price-range-slider {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .ui-range-slider-footer {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }
    #price_filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 38px;
        background: linear-gradient(135deg, #1a2332, #2d4270);
        border: none;
        color: #fff;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(26,35,80,0.18);
    }
    #price_filter i {
        font-size: 12px;
        line-height: 1;
        margin-right: 0 !important;
    }
    #price_filter:hover {
        opacity: 0.94;
        transform: translateY(-1px);
    }
    #price_filter:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(79,113,217,0.2), 0 4px 12px rgba(26,35,80,0.18);
    }
    .ui-range-values {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        color: #2d3748;
        background: #f4f6f9;
        border: 1px solid #e7ecf3;
        padding: 6px 14px;
        border-radius: 999px;
        white-space: nowrap;
    }
    .ui-range-value-min,
    .ui-range-value-max {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        line-height: 1;
    }

    /* Sidebar Toggle (Mobile) */
    .catalog-filter-btn {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        background: linear-gradient(135deg, #1a2332, #2d4270);
        color: #fff;
        border-radius: 12px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 16px;
        border: none;
        width: 100%;
        box-shadow: 0 4px 14px rgba(26,35,80,0.18);
        transition: opacity 0.2s ease;
    }
    .catalog-filter-btn:hover { opacity: 0.88; }
    @media (max-width: 991px) {
        .catalog-filter-btn { display: flex; }

        /* Override any theme fixed/offcanvas positioning on our sidebar */
        #catalogSidebar {
            position: static !important;
            left: auto !important;
            top: auto !important;
            width: 100% !important;
            height: auto !important;
            box-shadow: none !important;
            padding: 0 !important;
            overflow-y: visible !important;
            z-index: auto !important;
            background: transparent !important;
            display: none;
        }
        #catalogSidebar.catalog-sidebar-open {
            display: flex !important;
        }
    }
    /* =============================================
       PAGE LAYOUT
    ============================================= */
    .catalog-section {
        padding: 40px 0 60px;
        background: #f7f9fc;
    }
    .catalog-main-col {
        min-height: 400px;
    }

    /* No products state */
    .catalog-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        text-align: center;
        background: #fff;
        border-radius: 16px;
        border: 1px dashed #e2e8f0;
    }
    .catalog-empty i {
        font-size: 52px;
        color: #cbd5e0;
        margin-bottom: 18px;
    }
    .catalog-empty h4 {
        color: #4a5568;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .catalog-empty p {
        color: #a0aec0;
        font-size: 14px;
        margin: 0;
    }


</style>

{{-- HERO BANNER --}}
<section class="catalog-hero">
    <div class="catalog-hero__bg"></div>
    <div class="catalog-hero__overlay"></div>
    <div class="catalog-hero__content">
        <div class="catalog-hero__eyebrow">{{ __('Our Collection') }}</div>
        <h1 class="catalog-hero__title">
            {{ __('Discover') }} <span>{{ __('Premium Beds') }}</span><br>{{ __('& Mattresses') }}
        </h1>
        <p class="catalog-hero__subtitle">
            {{ __('Handcrafted for comfort, designed for style. Find your perfect sleep sanctuary.') }}
        </p>
        <div class="catalog-hero__breadcrumb">
            <a href="{{ url('/') }}"><i class="icon-home"></i> {{ __('Home') }}</a>
            <i class="icon-chevron-right"></i>
            <span>{{ __('Catalog') }}</span>
        </div>
    </div>
</section>

{{-- MAIN CATALOG SECTION --}}
<section class="catalog-section">
    <div class="container">
        <div class="row g-4">

            {{-- SIDEBAR --}}
            <div class="col-lg-3 order-lg-1">
                <button class="catalog-filter-btn" id="catalogFilterBtn" type="button">
                    <i class="fas fa-sliders-h"></i> {{ __('Filters') }}
                </button>

                <aside class="catalog-sidebar" id="catalogSidebar">

                    {{-- Categories Widget --}}
                    <div class="sidebar-card">
                        <div class="sidebar-card__header">
                            <div class="sidebar-card__icon">
                                <i class="fas fa-th-list"></i>
                            </div>
                            <h3 class="sidebar-card__title">{{ __('Shop Categories') }}</h3>
                        </div>
                        <div class="sidebar-card__body" style="padding: 12px 14px;">
                            <ul id="category_list" class="category-scroll">
                                @foreach ($categories as $getcategory)
                                <li class="has-children {{ isset($category) && $category->id == $getcategory->id ? 'expanded active' : '' }}">
                                    <a class="category_search" href="javascript:;" data-href="{{ $getcategory->slug }}">
                                        {{ $getcategory->name }}
                                    </a>
                                    <ul id="subcategory_list">
                                        @foreach ($getcategory->subcategory as $getsubcategory)
                                        <li class="{{ isset($subcategory) && $subcategory->id == $getsubcategory->id ? 'active' : '' }}">
                                            <a class="subcategory" href="javascript:;" data-href="{{ $getsubcategory->slug }}">
                                                {{ $getsubcategory->name }}
                                            </a>
                                            <ul id="childcategory_list">
                                                @foreach ($getsubcategory->childcategory as $getchildcategory)
                                                <li class="{{ isset($childcategory) && $getchildcategory->id == $getchildcategory->id ? 'active' : '' }}">
                                                    <a class="childcategory" href="javascript:;" data-href="{{ $getchildcategory->slug }}">
                                                        {{ $getchildcategory->name }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Price Filter Widget --}}
                    @if ($setting->is_range_search == 1)
                    <div class="sidebar-card">
                        <div class="sidebar-card__header">
                            <div class="sidebar-card__icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <h3 class="sidebar-card__title">{{ __('Filter by Price') }}</h3>
                        </div>
                        <div class="sidebar-card__body">
                            <form class="price-range-slider" method="post"
                                data-start-min="{{ request()->input('minPrice') ? request()->input('minPrice') : '0' }}"
                                data-start-max="{{ request()->input('maxPrice') ? request()->input('maxPrice') : $setting->max_price }}"
                                data-min="0"
                                data-max="{{ $setting->max_price }}"
                                data-step="5">
                                <div class="ui-range-slider"></div>
                                <footer class="ui-range-slider-footer">
                                    <div style="margin-right: 0;">
                                        <button class="btn" id="price_filter" type="button">
                                            <i class="fas fa-check me-1"></i>{{ __('Apply') }}
                                        </button>
                                    </div>
                                    <div class="ui-range-values" style="margin-top: 6px;">
                                        <div class="ui-range-value-min">
                                            {{ PriceHelper::setCurrencySign() }}<span class="min_price"></span>
                                            <input type="hidden">
                                        </div>
                                        <span style="color:#a0aec0; line-height:1;">–</span>
                                        <div class="ui-range-value-max">
                                            {{ PriceHelper::setCurrencySign() }}<span class="max_price"></span>
                                            <input type="hidden">
                                        </div>
                                    </div>
                                </footer>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Need Help Card --}}
                    <div class="sidebar-card" style="background: linear-gradient(135deg, #1a2332, #2d4270); border: none;">
                        <div class="sidebar-card__body" style="padding: 22px 20px; text-align: center;">
                            <div style="width:50px;height:50px;border-radius:50%;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <i class="fas fa-headset" style="color:#fff;font-size:20px;"></i>
                            </div>
                            <h4 style="color:#fff;font-size:15px;font-weight:700;margin:0 0 8px;">{{ __('Need Help?') }}</h4>
                            <p style="color:rgba(255,255,255,0.65);font-size:13px;margin:0 0 16px;line-height:1.55;">
                                {{ __('Our sleep experts are ready to help you find the perfect bed.') }}
                            </p>
                            <a href="{{ route('front.contact') }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;background:rgba(255,255,255,0.15);color:#fff;border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid rgba(255,255,255,0.25);transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                                <i class="fas fa-envelope"></i> {{ __('Contact Us') }}
                            </a>
                        </div>
                    </div>

                </aside>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9 order-lg-2 catalog-main-col">

                {{-- FILTER TOOLBAR --}}
                <div class="catalog-toolbar">
                    <div class="catalog-toolbar__filters">
                        <span class="catalog-toolbar__label">
                            <i class="fas fa-bolt me-1" style="color:#f6ad55;"></i>{{ __('Filter') }}
                        </span>
                        <ul id="quick_filter">
                            <li class="active"><a datahref="">{{ __('All') }}</a></li>
                            <li><a href="javascript:;" data-href="feature">⭐ {{ __('Featured') }}</a></li>
                            <li><a href="javascript:;" data-href="best">🏆 {{ __('Best Sellers') }}</a></li>
                            <li><a href="javascript:;" data-href="top">👍 {{ __('Top Rated') }}</a></li>
                            <li><a href="javascript:;" data-href="new">🆕 {{ __('New Arrival') }}</a></li>
                        </ul>
                    </div>

                    <div class="catalog-toolbar__right">
                        <div class="catalog-sort-wrap">
                            <label for="sorting"><i class="fas fa-sort-amount-down"></i></label>
                            <select class="catalog-sort-select" id="sorting">
                                <option value="">{{ __('Default') }}</option>
                                <option value="low_to_high" {{ request()->input('low_to_high') ? 'selected' : '' }}>{{ __('Price: Low → High') }}</option>
                                <option value="high_to_low" {{ request()->input('high_to_low') ? 'selected' : '' }}>{{ __('Price: High → Low') }}</option>
                            </select>
                        </div>
                        <span class="catalog-count-badge">
                            {{ __('Showing') }} 1–{{ $setting->view_product }}
                        </span>
                        <div class="catalog-view-toggle">
                            <a class="list-view {{ Session::has('view_catalog') && Session::get('view_catalog') == 'grid' ? 'active' : '' }}"
                               data-step="grid"
                               href="javascript:;"
                               data-href="{{ route('front.catalog').'?view_check=grid' }}"
                               title="{{ __('Grid View') }}">
                                <i class="fas fa-th-large"></i>
                            </a>
                            <a class="list-view {{ Session::has('view_catalog') && Session::get('view_catalog') == 'list' ? 'active' : '' }}"
                               href="javascript:;"
                               data-step="list"
                               data-href="{{ route('front.catalog').'?view_check=list' }}"
                               title="{{ __('List View') }}">
                                <i class="fas fa-list"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- PRODUCT GRID --}}
                <div id="list_view_ajax">
                    @include('front.catalog.catalog')
                </div>

            </div>
        </div>
    </div>
</section>

{{-- HIDDEN SEARCH FORM (used by catalog.js) --}}
<form id="search_form" class="d-none" action="{{ route('front.catalog') }}" method="GET">
    <input type="text" name="maxPrice"      id="maxPrice"      value="{{ request()->input('maxPrice') ? request()->input('maxPrice') : '' }}">
    <input type="text" name="minPrice"      id="minPrice"      value="{{ request()->input('minPrice') ? request()->input('minPrice') : '' }}">
    <input type="text" name="brand"         id="brand"         value="{{ isset($brand) ? $brand->slug : '' }}">
    <input type="text" name="category"      id="category"      value="{{ isset($category) ? $category->slug : '' }}">
    <input type="text" name="quick_filter"  id="quick_filter"  value="">
    <input type="text" name="childcategory" id="childcategory" value="{{ isset($childcategory) ? $childcategory->slug : '' }}">
    <input type="text" name="page"          id="page"          value="{{ isset($page) ? $page : '' }}">
    <input type="text" name="attribute"     id="attribute"     value="{{ isset($attribute) ? $attribute : '' }}">
    <input type="text" name="option"        id="option"        value="{{ isset($option) ? $option : '' }}">
    <input type="text" name="subcategory"   id="subcategory"   value="{{ isset($subcategory) ? $subcategory->slug : '' }}">
    <input type="text" name="sorting"       id="sorting"       value="{{ isset($sorting) ? $sorting : '' }}">
    <input type="text" name="view_check"    id="view_check"    value="{{ isset($view_check) ? $view_check : '' }}">
    <button type="submit" id="search_button" class="d-none">
    </button>
</form>
<script>
(function () {
    var btn = document.getElementById('catalogFilterBtn');
    var sidebar = document.getElementById('catalogSidebar');
    if (!btn || !sidebar) return;

    btn.addEventListener('click', function () {
        var isOpen = sidebar.classList.contains('catalog-sidebar-open');
        if (isOpen) {
            sidebar.classList.remove('catalog-sidebar-open');
            btn.innerHTML = '<i class="fas fa-sliders-h"></i> {{ __("Filters") }}';
        } else {
            sidebar.classList.add('catalog-sidebar-open');
            btn.innerHTML = '<i class="fas fa-times"></i> {{ __("Close Filters") }}';
        }
    });
})();
</script>
@endsection
