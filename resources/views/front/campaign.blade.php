@extends('master.front')
@section('meta')
<meta name="keywords" content="{{$setting->meta_keywords}}">
<meta name="description" content="{{$setting->meta_description}}">
@endsection
@section('title')
    {{__('Campaign Products')}}@if(isset($category)) - {{ $category->name }}@endif
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
        background: var(--primary-color);
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
        background: #ffffff !important;
        border-radius: 20px !important;
        border: 1px solid #ebdcd0 !important;
        box-shadow: 0 8px 24px rgba(44, 41, 36, 0.02) !important;
        padding: 14px 24px !important;
        margin-bottom: 28px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: wrap !important;
        gap: 16px !important;
    }
    .catalog-toolbar__filters {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        flex-wrap: wrap !important;
        flex: 1 1 auto !important;
    }
    .catalog-toolbar__label {
        font-size: 13px !important;
        font-weight: 800 !important;
        letter-spacing: 0.8px !important;
        text-transform: uppercase !important;
        color: #2c2924 !important;
        margin-right: 8px !important;
        white-space: nowrap !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
    }
    #catalog_quick_filter_list {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    #catalog_quick_filter_list li a {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 8px 16px !important;
        border-radius: 50px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #5a5045 !important;
        background: #ffffff !important;
        border: 1.5px solid #ebdcd0 !important;
        cursor: pointer !important;
        text-decoration: none !important;
        transition: all 0.22s ease !important;
        white-space: nowrap !important;
    }
    #catalog_quick_filter_list li a:hover {
        color: var(--primary-color) !important;
        background: rgba(0, 0, 0, 0.03) !important;
        border-color: var(--primary-color) !important;
    }
    #catalog_quick_filter_list li.active a {
        color: #ffffff !important;
        background: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
    }
    .catalog-toolbar__right {
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
        flex-shrink: 0 !important;
    }
    .catalog-sort-wrap {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    .catalog-sort-wrap label {
        font-size: 13px !important;
        color: #718096 !important;
        margin: 0 !important;
        display: none !important;
    }
    .catalog-sort-select {
        border: 1.5px solid #ebdcd0 !important;
        border-radius: 50px !important;
        padding: 8px 32px 8px 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #2c2924 !important;
        background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23b59469' fill='none' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 14px center !important;
        -webkit-appearance: none !important;
        appearance: none !important;
        cursor: pointer !important;
        outline: none !important;
        transition: all 0.2s !important;
    }
    .catalog-sort-select:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05) !important;
    }
    .catalog-count-badge {
        font-size: 13px !important;
        color: #5a5045 !important;
        background: #faf8f5 !important;
        border: 1.5px solid #ebdcd0 !important;
        border-radius: 50px !important;
        padding: 8px 16px !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
    }
    .catalog-view-toggle {
        display: flex !important;
        gap: 6px !important;
        background: #faf8f5 !important;
        border: 1.5px solid #ebdcd0 !important;
        border-radius: 50px !important;
        padding: 4px !important;
    }
    .catalog-view-toggle .list-view {
        width: 32px !important;
        height: 32px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important;
        color: #a0aec0 !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        font-size: 13px !important;
    }
    .catalog-view-toggle .list-view:hover,
    .catalog-view-toggle .list-view.active {
        background: #ffffff !important;
        color: var(--primary-color) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
    }

    @media (max-width: 768px) {
        .catalog-toolbar { padding: 12px 14px !important; }
        .catalog-toolbar__right { width: 100% !important; justify-content: space-between !important; }
        .catalog-count-badge { display: none !important; }
    }

    /* =============================================
       SIDEBAR
    ============================================= */
    .catalog-sidebar {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    .sidebar-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2dcd0;
        box-shadow: 0 10px 30px rgba(44, 41, 36, 0.03);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .sidebar-card:hover {
        box-shadow: 0 16px 40px rgba(44, 41, 36, 0.06);
        border-color: var(--primary-color);
    }
    .sidebar-card__header {
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid rgba(226, 220, 208, 0.5);
        background: #faf9f6;
    }
    .sidebar-card__icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #faf8f5;
        border: 1px solid #ebdcd0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .sidebar-card__title {
        font-size: 14px;
        font-weight: 800;
        color: #2c2924;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .sidebar-card__body {
        padding: 24px;
    }

    #category_list {
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0 !important;
    }
    #category_list > li {
        background: transparent !important;
        border: none !important;
        border-bottom: 1px solid rgba(226, 220, 208, 0.5) !important;
        border-radius: 0 !important;
        overflow: visible !important;
        box-shadow: none !important;
        transition: all 0.25s ease !important;
    }
    #category_list > li:last-child {
        border-bottom: none !important;
    }
    #category_list > li > a.category_search {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 14px 4px !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #2c2924 !important;
        text-decoration: none !important;
        cursor: pointer !important;
        transition: all 0.25s ease !important;
        background: transparent !important;
        border: none !important;
        border-radius: 0 !important;
    }
    #category_list > li.expanded > a.category_search,
    #category_list > li.active > a.category_search {
        color: var(--primary-color) !important;
    }
    .category-chevron {
        transition: transform 0.3s ease, color 0.3s ease !important;
        font-size: 11px !important;
        color: #718096 !important;
    }
    #category_list > li.expanded > a.category_search .category-chevron {
        transform: rotate(180deg) !important;
        color: var(--primary-color) !important;
    }
    
    .subcategory-list-container {
        display: none !important;
        list-style: none !important;
        padding: 16px !important;
        margin: 0 0 16px 0 !important;
        flex-direction: column !important;
        gap: 8px !important;
        background: #faf8f5 !important;
        border: 1px solid rgba(226, 220, 208, 0.5) !important;
        border-radius: 12px !important;
    }
    #category_list > li.expanded > .subcategory-list-container {
        display: flex !important;
    }
    
    .subcategory-search-box {
        position: relative !important;
        width: 100% !important;
        margin-bottom: 10px !important;
        border: 1px solid #ebdcd0 !important;
        border-radius: 8px !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
    }
    .subcategory-search-box .search-icon {
        position: absolute !important;
        left: 10px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        font-size: 12px !important;
        color: #a0aec0 !important;
        pointer-events: none !important;
    }
    .subcategory-search-input {
        width: 100% !important;
        border: none !important;
        outline: none !important;
        padding: 8px 12px 8px 30px !important;
        font-size: 13px !important;
        border-radius: 8px !important;
        color: #2c2924 !important;
        box-sizing: border-box !important;
    }
    .subcategory-search-input::placeholder {
        color: #a0aec0 !important;
    }
    
    .subcategory-list-scroll {
        max-height: 200px !important;
        overflow-y: auto !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
        scrollbar-width: thin !important;
        scrollbar-color: #a0aec0 #f1f2f6 !important;
    }
    
    .subcategory-list-scroll::-webkit-scrollbar {
        width: 6px !important;
    }
    .subcategory-list-scroll::-webkit-scrollbar-track {
        background: #f1f2f6 !important;
        border-radius: 10px !important;
    }
    .subcategory-list-scroll::-webkit-scrollbar-thumb {
        background: #a0aec0 !important;
        border-radius: 10px !important;
    }
    .subcategory-list-scroll::-webkit-scrollbar-thumb:hover {
        background: #718096 !important;
    }
    
    #category_list li a.subcategory {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 8px 14px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #5a5045 !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
        background: transparent !important;
    }
    #category_list li a.subcategory:hover {
        background: rgba(0, 0, 0, 0.03) !important;
        color: var(--primary-color) !important;
    }
    #category_list li.active > a.subcategory {
        background: var(--primary-color) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    
    #childcategory_list {
        list-style: none !important;
        padding: 4px 0 4px 18px !important;
        margin: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
    }
    #childcategory_list li a.childcategory {
        display: block !important;
        padding: 6px 12px !important;
        border-radius: 6px !important;
        font-size: 12.5px !important;
        font-weight: 500 !important;
        color: #6a5f51 !important;
        text-decoration: none !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
        background: transparent !important;
    }
    #childcategory_list li a.childcategory:hover {
        background: rgba(0, 0, 0, 0.03) !important;
        color: var(--primary-color) !important;
    }
    #childcategory_list li.active > a.childcategory {
        background: var(--primary-color) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    /* Price Filter Redesign */
    .price-filter-card {
        border: 1px solid #e2dcd0 !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(44, 41, 36, 0.03) !important;
        overflow: hidden !important;
    }
    .price-filter-card:hover {
        box-shadow: 0 16px 40px rgba(44, 41, 36, 0.06) !important;
        border-color: var(--primary-color) !important;
    }
    .price-filter-header {
        padding: 22px 24px !important;
        display: flex !important;
        align-items: center !important;
        gap: 14px !important;
        border-bottom: 1px solid rgba(226, 220, 208, 0.5) !important;
        background: #faf9f6 !important;
    }
    .price-filter-header.second-header {
        border-top: 1px solid rgba(226, 220, 208, 0.5) !important;
    }
    .price-filter-icon-box {
        width: 36px !important;
        height: 36px !important;
        border-radius: 10px !important;
        background: #faf8f5 !important;
        border: 1px solid #ebdcd0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: var(--primary-color) !important;
        font-size: 14px !important;
        flex-shrink: 0 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02) !important;
    }
    .price-filter-title {
        font-size: 14px !important;
        font-weight: 800 !important;
        color: #2c2924 !important;
        margin: 0 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
    }
    .price-filter-body {
        padding: 24px !important;
    }
    .price-range-slider {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }
    
    .price-range-slider .noUi-target,
    .price-range-slider .ui-slider {
        height: 2px !important;
        border-radius: 0px !important;
        background: #ebdcd0 !important;
        border: none !important;
        margin: 15px 10px !important;
        position: relative !important;
        box-shadow: none !important;
    }
    .price-range-slider .noUi-base {
        background: #ebdcd0 !important;
    }
    .price-range-slider .noUi-connect,
    .price-range-slider .ui-slider-range {
        background: #333333 !important;
        border-radius: 0px !important;
        position: absolute !important;
        height: 100% !important;
        top: 0 !important;
        box-shadow: none !important;
    }
    .price-range-slider .noUi-handle,
    .price-range-slider .ui-slider-handle {
        width: 6px !important;
        height: 16px !important;
        border-radius: 2px !important;
        background: #333333 !important;
        border: none !important;
        box-shadow: none !important;
        cursor: pointer !important;
        top: -7px !important;
        margin-left: -3px !important;
        outline: none !important;
        position: absolute !important;
        z-index: 2 !important;
        transition: none !important;
    }
    .price-range-slider .noUi-horizontal .noUi-handle {
        right: -3px !important;
        top: -7px !important;
    }
    .price-range-slider .noUi-handle::before,
    .price-range-slider .noUi-handle::after {
        display: none !important;
    }
    .price-range-slider .noUi-handle:hover,
    .price-range-slider .noUi-handle:focus,
    .price-range-slider .ui-slider-handle:hover,
    .price-range-slider .ui-slider-handle:focus {
        transform: none !important;
    }
    .ui-range-slider-footer {
        display: block !important;
        width: 100% !important;
        margin-top: 10px !important;
    }
    
    .price-inputs-pill-wrapper {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: 1.5px solid #ebdcd0 !important;
        border-radius: 50px !important;
        padding: 0 16px !important;
        background: #ffffff !important;
        width: 100% !important;
        height: 44px !important;
        box-sizing: border-box !important;
    }
    .price-inputs-pill-wrapper .ui-range-value-min,
    .price-inputs-pill-wrapper .ui-range-value-max {
        flex: 1 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-sizing: border-box !important;
    }
    .price-range-input {
        width: 100% !important;
        background: transparent !important;
        border: none !important;
        text-align: center !important;
        color: #2c2924 !important;
        font-weight: 700 !important;
        font-size: 14.5px !important;
        outline: none !important;
        height: 40px !important;
        box-sizing: border-box !important;
    }
    .price-inputs-divider {
        color: var(--primary-color) !important;
        font-weight: 700 !important;
        font-size: 14.5px !important;
        padding: 0 10px !important;
        user-select: none !important;
    }

    /* Sidebar Toggle (Mobile) */
    .catalog-filter-btn {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        background: var(--primary-color);
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
        <div class="catalog-hero__eyebrow">{{ __('Special Deals') }}</div>
        <h1 class="catalog-hero__title">
            {{ __('Deals Of') }} <span>{{ __('The Week') }}</span>
        </h1>
        <p class="catalog-hero__subtitle">
            {{ __('Get premium handcrafted beds and mattresses at exclusive, limited-time prices.') }}
        </p>
        <div class="catalog-hero__breadcrumb">
            <a href="{{ url('/') }}"><i class="icon-home"></i> {{ __('Home') }}</a>
            <i class="icon-chevron-right"></i>
            <span>{{ __('Deals of the Week') }}</span>
        </div>
    </div>
</section>

{{-- MAIN SECTION --}}
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
                    <div class="sidebar-card price-filter-card">
                        <div class="sidebar-card__header price-filter-header">
                            <div class="sidebar-card__icon price-filter-icon-box">
                                <i class="fas fa-th-list"></i>
                            </div>
                            <h3 class="sidebar-card__title price-filter-title">{{ __('Shop Categories') }}</h3>
                        </div>
                        <div class="sidebar-card__body category-widget-body" style="padding: 8px 24px 16px;">
                            <ul id="category_list">
                                @foreach ($categories as $getcategory)
                                <li class="has-children {{ isset($category) && $category->id == $getcategory->id ? 'expanded active' : '' }}">
                                    <a class="category_search" href="javascript:;" data-href="{{ $getcategory->slug }}">
                                        {{ $getcategory->name }}
                                        @if($getcategory->subcategory->count() > 0)
                                        <i class="fas fa-chevron-down category-chevron"></i>
                                        @endif
                                    </a>
                                    @if($getcategory->subcategory->count() > 0)
                                    <ul id="subcategory_list" class="subcategory-list-container">
                                        <div class="subcategory-search-box">
                                            <i class="fas fa-search search-icon"></i>
                                            <input type="text" class="subcategory-search-input" placeholder="{{ __('Search...') }}">
                                        </div>
                                        <div class="subcategory-list-scroll">
                                            @foreach ($getcategory->subcategory as $getsubcategory)
                                            <li class="{{ isset($subcategory) && $subcategory->id == $getsubcategory->id ? 'active' : '' }}">
                                                <a class="subcategory" href="javascript:;" data-href="{{ $getsubcategory->slug }}">
                                                    {{ $getsubcategory->name }}
                                                </a>
                                                @if($getsubcategory->childcategory->count() > 0)
                                                <ul id="childcategory_list">
                                                    @foreach ($getsubcategory->childcategory as $getchildcategory)
                                                    <li class="{{ isset($childcategory) && $getchildcategory->id == $getchildcategory->id ? 'active' : '' }}">
                                                        <a class="childcategory" href="javascript:;" data-href="{{ $getchildcategory->slug }}">
                                                            {{ $getchildcategory->name }}
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </div>
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Price Filter Widget --}}
                        @if ($setting->is_range_search == 1)
                        <div class="sidebar-card__header price-filter-header second-header">
                            <div class="sidebar-card__icon price-filter-icon-box">
                                <i class="fas fa-tag"></i>
                            </div>
                            <h3 class="sidebar-card__title price-filter-title">{{ __('Filter by Price') }}</h3>
                        </div>
                        <div class="sidebar-card__body price-filter-body">
                            <form class="price-range-slider" method="post"
                                data-start-min="{{ request()->input('minPrice') ? request()->input('minPrice') : '0' }}"
                                data-start-max="{{ request()->input('maxPrice') ? request()->input('maxPrice') : $setting->max_price }}"
                                data-min="0"
                                data-max="{{ $setting->max_price }}"
                                data-step="5">
                                <div class="ui-range-slider"></div>
                                <footer class="ui-range-slider-footer">
                                    <div style="display:none;">
                                        <button class="btn" id="price_filter" type="button">{{ __('Apply') }}</button>
                                    </div>
                                    <div class="price-inputs-pill-wrapper">
                                        <div class="ui-range-value-min">
                                            <span class="min_price" style="display:none;"></span>
                                            <input type="text" class="price-range-input" id="min_price_input" readonly>
                                        </div>
                                        <div class="price-inputs-divider">–</div>
                                        <div class="ui-range-value-max">
                                            <span class="max_price" style="display:none;"></span>
                                            <input type="text" class="price-range-input" id="max_price_input" readonly>
                                        </div>
                                    </div>
                                </footer>
                            </form>
                        </div>
                        @endif

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                function formatNumber(num) {
                                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                                }
                                
                                setTimeout(function() {
                                    var slider = document.querySelector(".ui-range-slider");
                                    if (slider && slider.noUiSlider) {
                                        slider.noUiSlider.on("update", function(values, handle) {
                                            var val = Math.round(values[handle]);
                                            if (handle === 0) {
                                                document.getElementById("min_price_input").value = formatNumber(val);
                                                document.querySelector(".min_price").textContent = val;
                                            } else {
                                                document.getElementById("max_price_input").value = formatNumber(val);
                                                document.querySelector(".max_price").textContent = val;
                                            }
                                        });
                                        slider.noUiSlider.on("change", function(values, handle) {
                                            document.getElementById("price_filter").click();
                                        });
                                    }
                                }, 500);

                                $(document).on("click", "#category_list > li.has-children > a.category_search", function(e) {
                                    var $li = $(this).parent();
                                    var isExpanded = $li.hasClass("expanded");
                                    
                                    if (isExpanded) {
                                        $li.removeClass("expanded");
                                    } else {
                                        $("#category_list > li.has-children").removeClass("expanded");
                                        $li.addClass("expanded");
                                    }
                                });

                                $(document).on("click", ".subcategory-list-container", function(e) {
                                    e.stopPropagation();
                                });

                                $(document).on("input", ".subcategory-search-input", function() {
                                    var query = $(this).val().toLowerCase();
                                    var $container = $(this).closest(".subcategory-list-container");
                                    $container.find(".subcategory-list-scroll > li").each(function() {
                                        var text = $(this).find("a.subcategory").text().toLowerCase();
                                        if (text.indexOf(query) > -1) {
                                            $(this).show();
                                        } else {
                                            $(this).hide();
                                        }
                                    });
                                });

                                $(document).on("click", "#catalog_quick_filter_list li a", function (e) {
                                    e.preventDefault();
                                    $("#catalog_quick_filter_list li").removeClass("active");
                                    $(this).parent().addClass("active");
                                    var filter = $(this).attr("data-href") || "";
                                    $("#search_form #quick_filter").val(filter);
                                    $("#search_form #page").val("");
                                    $("#search_button").click();
                                });
                            });
                        </script>
                    </div>

                    {{-- Help Card --}}
                    <div class="sidebar-card" style="background: var(--primary-color); border: none;">
                        <div class="sidebar-card__body" style="padding: 22px 20px; text-align: center;">
                            <div style="width:50px;height:50px;border-radius:50%;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <i class="fas fa-headset" style="color:#fff;font-size:20px;"></i>
                            </div>
                            <h4 style="color:#fff;font-size:15px;font-weight:700;margin:0 0 8px;">{{ __('Need Help?') }}</h4>
                            <p style="color:rgba(255,255,255,0.65);font-size:13px;margin:0 0 16px;line-height:1.55;">
                                {{ __('Our sleep experts are ready to help you find the perfect bed.') }}
                            </p>
                            <a href="{{ route('front.contact') }}" class="contact-us-widget-btn">
                                <i class="fas fa-envelope"></i> {{ __('Contact Us') }}
                            </a>
                        </div>
                    </div>

                </aside>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9 order-lg-2 catalog-main-col">

                {{-- TOOLBAR --}}
                <div class="catalog-toolbar">
                    <div class="catalog-toolbar__filters">
                        <span class="catalog-toolbar__label">
                            <i class="fas fa-bolt me-1" style="color:#f6ad55;"></i>{{ __('Filter') }}
                        </span>
                        @php
                            $qf = request()->input('quick_filter');
                        @endphp
                        <ul id="catalog_quick_filter_list">
                            <li class="{{ !$qf ? 'active' : '' }}"><a href="javascript:;" data-href="">{{ __('All') }}</a></li>
                            <li class="{{ $qf == 'feature' ? 'active' : '' }}"><a href="javascript:;" data-href="feature">⭐ {{ __('Featured') }}</a></li>
                            <li class="{{ $qf == 'best' ? 'active' : '' }}"><a href="javascript:;" data-href="best">🏆 {{ __('Best Sellers') }}</a></li>
                            <li class="{{ $qf == 'top' ? 'active' : '' }}"><a href="javascript:;" data-href="top">👍 {{ __('Top Rated') }}</a></li>
                            <li class="{{ $qf == 'new' ? 'active' : '' }}"><a href="javascript:;" data-href="new">🆕 {{ __('New Arrival') }}</a></li>
                        </ul>
                    </div>

                    <div class="catalog-toolbar__right">
                        <div class="catalog-sort-wrap">
                            <label for="sorting"><i class="fas fa-sort-amount-down"></i></label>
                            <select class="catalog-sort-select" id="sorting">
                                <option value="">{{ __('Default') }}</option>
                                <option value="low_to_high" {{ request()->input('sorting') == 'low_to_high' ? 'selected' : '' }}>{{ __('Price: Low → High') }}</option>
                                <option value="high_to_low" {{ request()->input('sorting') == 'high_to_low' ? 'selected' : '' }}>{{ __('Price: High → Low') }}</option>
                            </select>
                        </div>
                        <span class="catalog-count-badge">
                            {{ __('Showing') }} 1–{{ $setting->view_product }}
                        </span>
                        <div class="catalog-view-toggle">
                            <a class="list-view {{ Session::has('view_catalog') && Session::get('view_catalog') == 'grid' ? 'active' : '' }}"
                               data-step="grid"
                               href="javascript:;"
                               data-href="{{ route('front.campaign').'?view_check=grid' }}"
                               title="{{ __('Grid View') }}">
                                <i class="fas fa-th-large"></i>
                            </a>
                            <a class="list-view {{ Session::has('view_catalog') && Session::get('view_catalog') == 'list' ? 'active' : '' }}"
                               href="javascript:;"
                               data-step="list"
                               data-href="{{ route('front.campaign').'?view_check=list' }}"
                               title="{{ __('List View') }}">
                                <i class="fas fa-list"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- PRODUCTS AJAX GRID --}}
                <div id="list_view_ajax">
                    @include('front.catalog.catalog')
                </div>

            </div>
        </div>
    </div>
</section>

{{-- HIDDEN SEARCH FORM --}}
<form id="search_form" class="d-none" action="{{ route('front.campaign') }}" method="GET">
    <input type="text" name="maxPrice"      id="maxPrice"      value="{{ request()->input('maxPrice') ? request()->input('maxPrice') : '' }}">
    <input type="text" name="minPrice"      id="minPrice"      value="{{ request()->input('minPrice') ? request()->input('minPrice') : '' }}">
    <input type="text" name="brand"         id="brand"         value="{{ isset($brand) ? $brand->slug : '' }}">
    <input type="text" name="category"      id="category"      value="{{ isset($category) ? $category->slug : '' }}">
    <input type="text" name="quick_filter"  id="quick_filter"  value="{{ request()->input('quick_filter') ? request()->input('quick_filter') : '' }}">
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
