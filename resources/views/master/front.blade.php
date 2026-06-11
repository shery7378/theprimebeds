<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @if (url()->current() == route('front.index'))
        <title>@yield('hometitle')</title>
    @else
        <title>{{ $setting->title }} -@yield('title')</title>
    @endif

    <!-- SEO Meta Tags-->
    @if (url()->current() == route('front.index'))
        <meta name="author" content="GeniusDevs">
        <meta name="distribution" content="web">
        <meta name="description" content="{{ $setting->meta_description }}">
        <meta name="keywords" content="{{ $setting->meta_keywords }}">
        <meta name="image" content="{{ url('assets/img/' . $setting->meta_image) }}">
        <meta property="og:title" content="{{ $setting->title}}">
        <meta property="og:description" content="{{ $setting->meta_description }}">
        <meta property="og:image" content="{{ url('assets/img/' . $setting->meta_image) }}">
        <meta property="og:image:secure_url" content="{{ url('assets/img/' . $setting->meta_image) }}" />
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="627" />
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ $setting->title }}">
        <meta property="og:type" content="website">
    @else
        @yield('meta')
    @endif

    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon Icons-->
    <link rel="icon" type="image/png" href="{{ url('assets/img/04_icon_only.png') }}">
    <link rel="apple-touch-icon" href="{{ url('assets/img/04_icon_only.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('assets/img/04_icon_only.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/04_icon_only.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ url('assets/img/04_icon_only.png') }}">

    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{ asset('assets/front/css/plugins.min.css') }}">

    @yield('styleplugins')

    <link id="mainStyles" rel="stylesheet" media="screen" href="{{ asset('assets/front/css/styles.min.css') }}">

    <link id="mainStyles" rel="stylesheet" media="screen" href="{{ asset('assets/front/css/responsive.css') }}">
    <!-- Color css -->
    <link
        href="{{ asset('assets/front/css/color.php?primary_color=') . str_replace('#', '', $setting->primary_color) }}"
        rel="stylesheet">

    <!-- Modernizr-->
    <script src="{{ asset('assets/front/js/modernizr.min.js') }}"></script>

    @if (DB::table('languages')->where('is_default', 1)->first()->rtl == 1)
        <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
    @endif
    <style>
        {{ $setting->custom_css }}
        /* =============================================
           SLIDER NAVIGATION ARROWS (HIDDEN)
           ============================================= */
        .popular-category-slider .owl-nav,
        .flash-deal-slider .owl-nav,
        .bestseller-slider .owl-nav,
        .newproduct-slider .owl-nav,
        .toprated-slider .owl-nav,
        .home-blog-slider .owl-nav {
            display: none !important;
        }
           GLOBAL PRODUCT CARD REDESIGN (BEIGE LUXURY THEME)
           ============================================= */
        .product-card {
            background: #F8F6F0 !important;
            border: none !important;
            border-radius: 20px !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            transition: transform 0.28s ease, box-shadow 0.28s ease !important;
            position: relative !important;
            box-shadow: none !important;
        }
        .product-card:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08) !important;
            border-color: transparent !important;
        }

        .product-card .product-thumb {
            position: relative !important;
            overflow: hidden !important;
            background: #EBE5DB !important;
            aspect-ratio: 4 / 3 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            padding: 0 !important;
        }
        .product-card .product-thumb img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
            transition: transform 0.55s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        }
        .product-card:hover .product-thumb img {
            transform: scale(1.07) !important;
        }

        /* Badges */
        .product-card .product-badge {
            position: absolute !important;
            top: 15px !important;
            right: 15px !important;
            left: auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            padding: 6px 14px !important;
            border-radius: 50px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            letter-spacing: 0px !important;
            color: #8C7558 !important;
            background: #ffffff !important;
            line-height: 1 !important;
            white-space: nowrap !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
            z-index: 3 !important;
            border: none !important;
            text-transform: none !important;
        }
        .product-card .product-badge.product-badge2 { 
            top: 15px !important; 
        }
        .product-card .product-badge.bg-secondary { 
            top: 55px !important; 
        }

        /* Add to Cart Hover Bar (ONLY for Popular Products Section) */
        .product-card .product-button-group {
            display: none !important; /* Hide it everywhere by default */
        }
        
        .popular-category-slider .product-card .product-button-group {
            position: absolute !important;
            bottom: -50px !important; /* Start hidden below the image */
            left: 0 !important;
            width: 100% !important;
            display: flex !important;
            transition: bottom 0.3s ease !important;
            z-index: 10 !important;
            background: transparent !important; /* Move color to button */
            padding: 0 !important;
            margin: 0 !important;
        }
        .popular-category-slider .product-card .product-thumb:hover .product-button-group {
            bottom: 0 !important; /* Slide up on hover */
        }
        
        /* Hide everything else in the group since wishlist is moved */
        .popular-category-slider .product-card .product-button-group .wishlist_store,
        .popular-category-slider .product-card .product-button-group .product_compare {
            display: none !important;
        }
        
        /* Style the remaining button (Add to Cart / Details) */
        .popular-category-slider .product-card .product-button-group a.product-button {
            width: 100% !important;
            height: 45px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            text-decoration: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: #8C7558 !important; /* Solid Theme Color */
            transition: background 0.2s ease !important;
            margin: 0 !important;
        }
        .popular-category-slider .product-card .product-button-group a.product-button:hover {
            background: #735D43 !important; /* Darker solid color on hover */
        }
        .popular-category-slider .product-card .product-button-group a.product-button i {
            margin-right: 0 !important; /* Removed margin since there is no text */
            font-size: 18px !important; /* Slightly larger icon since it's alone */
        }

        /* Body */
        .product-card .product-card-body {
            padding: 20px !important;
            display: flex !important;
            flex-direction: column !important;
            flex: 1 !important;
            text-align: left !important;
            background: #F8F6F0 !important;
        }
        
        .product-card .product-category {
            display: none !important; /* The image didn't have a category in the new design */
        }
        
        .product-card .product-title {
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #332B23 !important;
            line-height: 1.4 !important;
            margin: 0 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            letter-spacing: 0px !important;
        }
        .product-card .product-title a {
            color: inherit !important;
            text-decoration: none !important;
            transition: color 0.2s !important;
        }
        .product-card .product-title a:hover { color: #8C7558 !important; }

        /* Title Flex Wrapper */
        .product-card-body > div:nth-child(2) {
            margin-bottom: 8px !important;
            align-items: flex-start !important; /* Align to top instead of center */
        }

        /* Wishlist Icon in Card Body */
        .product-card-body .wishlist_store {
            position: relative !important;
            top: -4px !important; /* Nudge up slightly from top */
            right: 6px !important; /* Move left slightly */
            font-size: 26px !important;
            transition: color 0.3s ease !important;
        }
        .product-card-body .wishlist_store.added {
            color: #E33535 !important; /* Red color when added */
        }

        /* Price Row */
        .product-card .product-price {
            display: flex !important;
            flex-direction: row !important;
            justify-content: flex-end !important;
            align-items: center !important;
            text-align: right !important;
            gap: 6px !important;
            margin-top: 5px !important; /* Removed auto so it sits right under the heart */
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #332B23 !important;
            line-height: 1.2 !important;
            margin-bottom: 20px !important;
        }
        .product-card .product-price del {
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #A3917C !important;
            text-decoration: line-through !important;
            line-height: 1.2 !important;
            margin-bottom: 0 !important;
        }

        /* =============================================
           EXPAND CONTAINER ON LARGE SCREENS
           ============================================= */
        @media (min-width: 1400px) {
            .container { max-width: 1320px; }
        }
        @media (min-width: 1600px) {
            .container { max-width: 1500px; }
        }
        @media (min-width: 1900px) {
            .container { max-width: 1700px; }
        }

        /* =============================================
           TOPBAR REDESIGN — Premium Header Styles
           ============================================= */

        .topbar-redesigned {
            padding: 0;
            background: #ffffff;
            border-bottom: 1px solid #e8ecf1;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .topbar-redesigned .topbar-inner {
            gap: 20px;
        }

        /* --- Logo --- */
        .topbar-redesigned .topbar-logo {
            flex-shrink: 0;
            padding: 0;
        }
        .topbar-redesigned .topbar-logo .site-logo {
            display: block;
            width: 140px;
            transition: opacity 0.25s ease;
        }
        .topbar-redesigned .topbar-logo .site-logo:hover {
            opacity: 0.85;   
        }

        /* --- Search Box Wrapper --- */
        .topbar-redesigned .topbar-search-wrap {
            flex: 1 1 auto;
            max-width: 420px;
            min-width: 250px;
            padding: 0;
            margin: 0 15px;
        }
        .topbar-redesigned .topbar-search-wrap .search-box-inner {
            width: 100%;
        }
        .topbar-redesigned .topbar-search-box {
            border: 2px solid #e2e6ec;
            border-radius: 50px;
            overflow: hidden;
            background: #f8f9fb;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .topbar-redesigned .topbar-search-box:focus-within {
            border-color: #377dff;
            box-shadow: 0 0 0 4px rgba(55, 125, 255, 0.1);
            background: #fff;
        }

        /* Category Select */
        .topbar-redesigned .topbar-category-select {
            border: none;
            border-right: 1px solid #e2e6ec;
            background: transparent;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 500;
            color: #3c4858;
            min-width: 140px;
            cursor: pointer;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236c7a8d' fill='none' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 26px;
        }
        .topbar-redesigned .topbar-category-select:focus {
            outline: none;
        }

        /* Search Input */
        .topbar-redesigned .topbar-search-input {
            border: none !important;
            background: transparent !important;
            padding: 11px 18px !important;
            font-size: 14px !important;
            color: #3c4858 !important;
            box-shadow: none !important;
            height: auto !important;
        }
        
        /* Reduce Footer Padding */
        .site-footer {
            padding-top: 10px !important;
        }
        .topbar-redesigned .topbar-search-input::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        /* Search Button */
        .topbar-redesigned .topbar-search-btn {
            background: linear-gradient(135deg, #377dff, #2c5cc5);
            border: none;
            color: #fff;
            padding: 0 20px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.15s ease;
            display: flex;
            align-items: center;
        }
        .topbar-redesigned .topbar-search-btn:hover {
            background: linear-gradient(135deg, #2c5cc5, #1e4ba8);
        }
        .topbar-redesigned .topbar-search-btn:active {
            transform: scale(0.96);
        }
        .topbar-redesigned .topbar-search-btn i {
            font-size: 16px;
        }

        /* --- Catalog Button --- */
        .topbar-catalog-wrap {
            margin-right: 0;
        }
        .topbar-catalog-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: linear-gradient(135deg, #1a2332, #2c3e56);
            color: #fff !important;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 35, 50, 0.2);
            white-space: nowrap;
        }
        .topbar-catalog-btn:hover {
            background: linear-gradient(135deg, #2c3e56, #3d5577);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26, 35, 50, 0.3);
            color: #fff !important;
        }
        .topbar-catalog-btn:active {
            transform: translateY(0);
        }
        .topbar-catalog-btn svg {
            flex-shrink: 0;
        }

        /* --- Divider --- */
        .topbar-divider {
            width: 1px;
            height: 36px;
            background: linear-gradient(to bottom, transparent, #d0d6e0, transparent);
            margin: 0 8px;
            flex-shrink: 0;
        }

        /* --- Contact Info --- */
        .topbar-contact-wrap {
            gap: 12px;
        }
        .topbar-contact-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #eef3ff, #dde6fa);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #377dff;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        .topbar-contact-icon:hover {
            transform: scale(1.08);
        }
        .topbar-contact-info {
            display: flex;
            flex-direction: column;
        }
        .topbar-phone {
            font-size: 13.5px;
            font-weight: 600;
            color: #2d3748 !important;
            text-decoration: none !important;
            line-height: 1.3;
            transition: color 0.25s ease;
        }
        .topbar-phone:hover {
            color: #377dff !important;
        }
        .topbar-email {
            font-size: 12px;
            color: #718096 !important;
            text-decoration: none !important;
            line-height: 1.3;
            transition: color 0.25s ease;
        }
        .topbar-email:hover {
            color: #377dff !important;
        }

        /* --- Cart Item --- */
        .topbar-cart-item {
            position: relative;
            width: auto !important;
            margin-left: 0 !important;
        }
        .topbar-cart-item > a {
            display: flex !important;
            align-items: center;
            position: relative !important;
            width: auto !important;
            height: auto !important;
            padding: 8px 12px !important;
            border-radius: 12px;
            color: #3c4858 !important;
            text-decoration: none;
            transition: background 0.25s ease;
        }
        .topbar-cart-item > a:hover {
            background: #f0f4ff;
        }
        .topbar-cart-item > a > div {
            position: static !important;
            transform: none !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .topbar-cart-item .cart-icon {
            position: relative;
        }
        .topbar-cart-item .cart-icon i {
            font-size: 22px !important;
            margin-bottom: 0 !important;
        }
        .topbar-cart-item .cart-icon .count-label {
            top: -8px !important;
            right: -10px !important;
            background: linear-gradient(135deg, #377dff, #2c5cc5) !important;
            font-size: 10px !important;
            width: 18px !important;
            height: 18px !important;
            line-height: 18px !important;
        }
        .topbar-cart-item .text-label {
            display: inline-block !important;
            font-size: 13px !important;
            font-weight: 600;
            color: #3c4858;
        }

        /* --- Topbar Right Toolbar --- */
        .topbar-right-toolbar {
            gap: 4px;
            flex-shrink: 0;
        }

        /* --- Responsive: Medium screens --- */
        @media (max-width: 1200px) {
            .topbar-redesigned .topbar-search-wrap {
                max-width: 400px;
            }
            .topbar-contact-info {
                display: none;
            }
            .topbar-contact-icon {
                width: 38px;
                height: 38px;
            }
            .topbar-divider {
                margin: 0 8px;
            }
            .topbar-catalog-btn {
                padding: 9px 16px;
                font-size: 12px;
            }
        }

        @media (max-width: 991px) {
            .topbar-redesigned {
                padding: 8px 0;
            }
        }

        /* ===== Branded Social Icons ===== */
        .social-icon-branded {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--brand-bg, #555);
            color: #fff !important;
            font-size: 15px;
            text-decoration: none !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.2s ease;
            flex-shrink: 0;
        }

        .social-icon-branded:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.28);
            opacity: 0.88;
            color: #fff !important;
        }

        .social-icon-branded svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            display: block;
        }

        /* Override old red background on footer social links */
        .footer-social-links a {
            background: transparent !important;
        }

        .footer-social-links a::before {
            display: none !important;
        }
    </style>
    {{-- Google AdSense Start --}}
    @if ($setting->is_google_adsense == '1')
        {!! $setting->google_adsense !!}
    @endif
    {{-- Google AdSense End --}}

    {{-- Google AnalyTics Start --}}
    @if ($setting->is_google_analytics == '1')
        {!! $setting->google_analytics !!}
    @endif
    {{-- Google AnalyTics End --}}

    {{-- Facebook pixel Start --}}
    @if ($setting->is_facebook_pixel == '1')
        {!! $setting->facebook_pixel !!}
    @endif
    {{-- Facebook pixel End --}}
    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            background-color: #25d366;
            padding: 10px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
        }

        .whatsapp-float img {
            width: 30px;
            height: 30px;
            filter: invert(1);
            /* Make icon white */
        }
    </style>

    @stack('styles')
</head>
<!-- Body-->

<body class="
@if ($setting->theme == 'theme1') body_theme1
@elseif($setting->theme == 'theme2')
    body_theme2
@elseif($setting->theme == 'theme3')
    body_theme3
@elseif($setting->theme == 'theme4')
body_theme4 @endif
">
    @if ($setting->is_loader == 1)
        <!-- Preloader Start -->
        @if ($setting->is_loader == 1)
            <div id="preloader">
                <img src="{{ url('assets/img/' . $setting->loader) }}" alt="{{ __('Loading...') }}">
            </div>
        @endif

        <!-- Preloader endif -->
    @endif

    <!-- Header-->

    <header class="site-header navbar-sticky">
        <div class="menu-top-area d-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="t-m-s-a">
                            <a class="track-order-link" href="{{ route('front.order.track') }}"><i
                                    class="icon-map-pin"></i>{{ __('Track Order') }}</a>
                            {{-- <a class="track-order-link compare-mobile d-lg-none"
                                href="{{ route('fornt.compare.index') }}">{{ __('Compare') }}</a> --}}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="right-area">

                            {{-- <a class="track-order-link wishlist-mobile d-inline-block d-lg-none"
                                href="{{ route('user.wishlist.index') }}"><i class="icon-heart"></i>{{ __('Wishlist')
                                }}</a> --}}

                            {{-- <div class="t-h-dropdown ">
                                <a class="main-link" href="#">{{ __('Language') }}<i class="icon-chevron-down"></i></a>
                                <div class="t-h-dropdown-menu">
                                    @foreach (DB::table('languages')->whereType('Website')->get() as $language)
                                    <a class="{{ Session::get('language') == $language->id ? 'active' : ($language->is_default == 1 && !Session::has('language') ? 'active' : '') }}"
                                        href="{{ route('front.language.setup', $language->id) }}"><i
                                            class="icon-chevron-right pr-2"></i>{{ $language->language }}</a>
                                    @endforeach
                                </div>
                            </div> --}}


                            {{-- <div class="t-h-dropdown ">
                                <a class="main-link" href="#">{{ __('Currency') }}<i class="icon-chevron-down"></i></a>
                                <div class="t-h-dropdown-menu">
                                    @foreach (DB::table('currencies')->get() as $currency)
                                    <a class="{{ Session::get('currency') == $currency->id ? 'active' : ($currency->is_default == 1 && !Session::has('currency') ? 'active' : '') }}"
                                        href="{{ route('front.currency.setup', $currency->id) }}"><i
                                            class="icon-chevron-right pr-2"></i>{{ $currency->name }}</a>
                                    @endforeach
                                </div>
                            </div> --}}

                            {{-- <div class="login-register ">
                                @if (!Auth::user())
                                <a class="track-order-link mr-0" href="{{ route('user.login') }}">
                                    {{ __('Login') }}
                                </a>
                                @else
                                <div class="t-h-dropdown">
                                    <div class="main-link">
                                        <i class="icon-user pr-2"></i> <span class="text-label">{{
                                            Auth::user()->first_name }}</span>
                                    </div>
                                    <div class="t-h-dropdown-menu">
                                        <a href="{{ route('user.dashboard') }}"><i
                                                class="icon-chevron-right pr-2"></i>{{ __('Dashboard') }}</a>
                                        <a href="{{ route('user.logout') }}"><i class="icon-chevron-right pr-2"></i>{{
                                            __('Logout') }}</a>
                                    </div>
                                </div>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar-->
        <div class="topbar topbar-redesigned">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="topbar-inner d-flex align-items-center" style="gap: 30px;">
                            <!-- Logo-->
                            <div class="site-branding topbar-logo" style="margin-right: auto;">
                                <a class="site-logo align-self-center" href="{{ route('front.index') }}">
                                    <img src="{{ url('assets/img/prime_beds_logo3_transparent.png') }}" alt="{{ $setting->title }}">
                                </a>
                            </div>

                            <!-- Search / Categories-->
                            <div class="search-box-wrap d-none d-lg-flex align-items-center topbar-search-wrap">
                                <div class="search-box-inner align-self-center">
                                    <div class="search-box d-flex topbar-search-box">
                                        <select name="category" id="category_select" class="categoris topbar-category-select">
                                            <option value="">{{ __('All Categories') }}</option>
                                            @foreach (DB::table('categories')->whereStatus(1)->get() as $category)
                                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <form class="input-group topbar-search-form" id="header_search_form"
                                            action="{{ route('front.catalog') }}" method="get">
                                            <input type="hidden" name="category" value="" id="search__category">
                                            <input class="form-control topbar-search-input" type="text"
                                                data-target="{{ route('front.search.suggest') }}" id="__product__search"
                                                name="search" placeholder="{{ __('Search...') }}">
                                            <span class="input-group-btn">
                                                <button type="submit" class="topbar-search-btn"><i class="icon-search"></i></button>
                                            </span>
                                            <div class="serch-result d-none">
                                                {{-- search result --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <span class="d-block d-lg-none close-m-serch"><i class="icon-x"></i></span>
                            </div>

                            <!-- Right Toolbar Area -->
                            <div class="toolbar d-flex align-items-center topbar-right-toolbar">

                                {{-- Mobile-only items --}}
                                <div class="toolbar-item close-m-serch visible-on-mobile"><a href="#">
                                        <div><i class="icon-search"></i></div>
                                    </a>
                                </div>
                                <div class="toolbar-item visible-on-mobile mobile-menu-toggle"><a href="#">
                                        <div><i class="icon-menu"></i><span class="text-label">{{ __('Menu') }}</span></div>
                                    </a>
                                </div>

                                {{-- Catalog Download Button --}}
                                @if(isset($setting->catalog_file))
                                <div class="d-none d-md-flex align-items-center topbar-catalog-wrap">
                                    <a href="{{ asset('assets/files/' . $setting->catalog_file) }}" class="topbar-catalog-btn" download>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        <span>{{ __('Catalog') }}</span>
                                    </a>
                                </div>
                                @endif

                                {{-- Divider --}}
                                <div class="topbar-divider d-none d-md-block"></div>

                                {{-- Contact Info --}}
                                {{--
                                @if (isset($setting->contact_number))
                                <div class="d-none d-md-flex align-items-center topbar-contact-wrap">
                                    <div class="topbar-contact-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                    </div>
                                    <div class="topbar-contact-info">
                                        <a href="tel:{{ $setting->contact_number }}" class="topbar-phone">
                                            {{ $setting->contact_number }}
                                        </a>
                                        <a href="mailto:{{ $setting->contact_mail }}" class="topbar-email">
                                            {{ $setting->contact_mail }}
                                        </a>
                                    </div>
                                </div>
                                @endif

                                --}}
                                {{-- <div class="topbar-divider d-none d-md-block"></div> --}}

                                {{-- User Login / Profile --}}
                                <div class="d-none d-md-flex align-items-center" style="width: auto; justify-content: center; padding: 0; margin-left: 20px; margin-right: 20px;">
                                    @if (!Auth::user())
                                        <a href="{{ route('user.login') }}"
                                           style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;color:inherit;font-size:.85rem;font-weight:600;transition:color .2s;"
                                           onmouseover="this.style.color='{{ $setting->primary_color ?? '#4e73df' }}'"
                                           onmouseout="this.style.color='inherit'">
                                            <span style="display:inline-flex;align-items:center;justify-content:center;
                                                         width:32px;height:32px;border-radius:50%;
                                                         border:2px solid currentColor;">
                                                <i class="icon-user" style="font-size:15px;line-height:1;margin:0!important;padding:0!important;position:relative;top:2px;"></i>
                                            </span>
                                            <span class="d-none d-lg-inline">{{ __('Login') }}</span>
                                        </a>
                                    @else
                                        <div class="t-h-dropdown">
                                            <div class="main-link" style="display:inline-flex;align-items:center;cursor:pointer;">
                                                <span style="display:inline-flex;align-items:center;justify-content:center;
                                                             width:32px;height:32px;border-radius:50%;
                                                             background:{{ $setting->primary_color ?? '#4e73df' }};
                                                             color:#fff;flex-shrink:0;">
                                                    <i class="icon-user" style="font-size:15px;line-height:1;margin:0!important;padding:0!important;position:relative;top:0px;left:-1px;"></i>
                                                </span>
                                            </div>
                                            <div class="t-h-dropdown-menu" style="min-width:160px;">
                                                <a href="{{ route('user.dashboard') }}">
                                                    <i class="icon-grid pr-2"></i>{{ __('Dashboard') }}
                                                </a>
                                                <a href="{{ route('user.logout') }}">
                                                    <i class="icon-log-out pr-2"></i>{{ __('Logout') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Divider --}}
                                <div class="topbar-divider d-none d-md-block"></div>

                                {{-- Cart --}}
                                <div class="toolbar-item topbar-cart-item">
                                    <a href="{{ route('front.cart') }}">
                                        <div>
                                            <span class="cart-icon"><i class="icon-shopping-cart"></i>
                                                <span class="count-label cart_count">{{ Session::has('cart') ? count(Session::get('cart')) : '0' }}</span>
                                            </span>
                                            <span class="text-label">{{ __('Cart') }}</span>
                                        </div>
                                    </a>
                                    <div class="toolbar-dropdown cart-dropdown widget-cart cart_view_header"
                                        id="header_cart_load" data-target="{{ route('front.header.cart') }}">
                                        @include('includes.header_cart')
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Menu-->
                            <div class="mobile-menu">
                                <!-- Slideable (Mobile) Menu-->
                                <div class="mm-heading-area">
                                    <h4>{{ __('Navigation') }}</h4>
                                    <div class="toolbar-item visible-on-mobile mobile-menu-toggle mm-t-two">
                                        <a href="#">
                                            <div> <i class="icon-x"></i></div>
                                        </a>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation99">
                                        <span class="active" id="mmenu-tab" data-bs-toggle="tab" data-bs-target="#mmenu"
                                            role="tab" aria-controls="mmenu"
                                            aria-selected="true">{{ __('Menu') }}</span>
                                    </li>
                                    <li class="nav-item" role="presentation99">
                                        <span class="" id="mcat-tab" data-bs-toggle="tab" data-bs-target="#mcat"
                                            role="tab" aria-controls="mcat"
                                            aria-selected="false">{{ __('Category') }}</span>
                                    </li>

                                </ul>
                                <div class="tab-content p-0">
                                    <div class="tab-pane fade show active" id="mmenu" role="tabpanel"
                                        aria-labelledby="mmenu-tab">
                                        <nav class="slideable-menu">
                                            <ul>
                                                <li class="{{ request()->routeIs('front.index') ? 'active' : '' }}"><a
                                                        href="{{ route('front.index') }}"><i
                                                            class="icon-chevron-right"></i>{{ __('Home') }}</a>
                                                </li>
                                                @if ($setting->is_shop == 1)
                                                    <li class="{{ request()->routeIs('front.catalog*') ? 'active' : '' }}">
                                                        <a href="{{ route('front.catalog') }}"><i
                                                                class="icon-chevron-right"></i>{{ __('Shop') }}</a>
                                                    </li>
                                                @endif
                                                @if ($setting->is_campaign == 1)
                                                    <li class="{{ request()->routeIs('front.campaign') ? 'active' : '' }}">
                                                        <a href="{{ route('front.campaign') }}"><i
                                                                class="icon-chevron-right"></i>{{ __('Campaign') }}</a>
                                                    </li>
                                                @endif
                                                @if ($setting->is_brands == 1)
                                                    <li class="{{ request()->routeIs('front.brand') ? 'active' : '' }}">
                                                        <a href="{{ route('front.brand') }}"><i
                                                                class="icon-chevron-right"></i>{{ __('Brand') }}</a>
                                                    </li>
                                                @endif

                                                @if ($setting->is_blog == 1)
                                                    <li class="{{ request()->routeIs('front.blog*') ? 'active' : '' }}">
                                                        <a href="{{ route('front.blog') }}"><i
                                                                class="icon-chevron-right"></i>{{ __('Blog') }}</a>
                                                    </li>
                                                @endif
                                                <li class="t-h-dropdown">
                                                    <a class="" href="#"><i
                                                            class="icon-chevron-right"></i>{{ __('Pages') }} <i
                                                            class="icon-chevron-down"></i></a>
                                                    <div class="t-h-dropdown-menu">
                                                        @if ($setting->is_faq == 1)
                                                            <a class="{{ request()->routeIs('front.faq*') ? 'active' : '' }}"
                                                                href="{{ route('front.faq') }}"><i
                                                                    class="icon-chevron-right pr-2"></i>{{ __('Faq') }}</a>
                                                        @endif
                                                        @foreach (DB::table('pages')->wherePos(0)->orwhere('pos', 2)->get() as $page)
                                                            <a class="{{ request()->url() == route('front.page', $page->slug) ? 'active' : '' }} "
                                                                href="{{ route('front.page', $page->slug) }}"><i
                                                                    class="icon-chevron-right pr-2"></i>{{ $page->title }}</a>
                                                        @endforeach
                                                    </div>
                                                </li>

                                                @if ($setting->is_contact == 1)
                                                    <li class="{{ request()->routeIs('front.contact') ? 'active' : '' }}">
                                                        <a href="{{ route('front.contact') }}"><i
                                                                class="icon-chevron-right"></i>{{ __('Contact') }}</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="tab-pane fade" id="mcat" role="tabpanel" aria-labelledby="mcat-tab">
                                        <nav class="slideable-menu">
                                            @include('includes.mobile-category')

                                        </nav>
                                    </div>
                                </div>
                                {{-- ===== Mobile Social Icons ===== --}}
                                @if($socials->isNotEmpty())
                                <div class="d-flex flex-wrap px-3 pb-3" style="gap:10px;border-top:1px solid rgba(255,255,255,.12);margin-top:6px;">
                                    @foreach($socials as $social)
                                        @if(!empty($social->link))
                                            @php
                                                $smColors=["facebook"=>"#1877F2","instagram"=>"#E1306C","linkedin"=>"#0A66C2","tiktok"=>"#010101","twitter"=>"#1DA1F2","youtube"=>"#FF0000","whatsapp"=>"#25D366","pinterest"=>"#E60023","snapchat"=>"#FFFC00","telegram"=>"#26A5E4"];
                                                $ic=$social->icon??"";
                                                $isTT=str_contains(strtolower($ic),"tiktok");
                                                $bc="#888";
                                                foreach($smColors as $p=>$cv){if(str_contains(strtolower($ic),$p)){$bc=$cv;break;}}
                                            @endphp
                                            <a href="{{ $social->link }}" target="_blank" rel="noopener noreferrer"
                                               style="display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:{{ $bc }};color:#fff;font-size:14px;text-decoration:none;">
                                                @php $isImgM=preg_match("/^https?:\/\//i",$ic); @endphp@if($isImgM)<img src="{{ $ic }}" alt="" style="width:14px;height:14px;object-fit:contain;display:block;">@elseif($isTT)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" style="width:14px;height:14px;display:block;"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z"/></svg>@else<i class="{{ $ic }}" style="line-height:1;"></i>@endif
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar-->
        <div class="navbar">
            <div class="container">
                <div class="row g-3 w-100">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <div class="nav-inner">
                            @include('master.inc.site-menu')
                        </div>
                        {{-- ===== Navbar Social Icons =====
                        @if($socials->isNotEmpty())
                        <div class="d-none d-lg-flex align-items-center" style="gap:8px;margin-left:auto;padding-left:20px;">
                            @php
                                $nbColors=["facebook"=>"#1877F2","instagram"=>"#E1306C","linkedin"=>"#0A66C2","tiktok"=>"#010101","twitter"=>"#1DA1F2","youtube"=>"#FF0000","whatsapp"=>"#25D366","pinterest"=>"#E60023","snapchat"=>"#FFFC00","telegram"=>"#26A5E4"];
                            @endphp
                            @foreach($socials as $social)
                                @if(!empty($social->link))
                                    @php
                                        $ic  = $social->icon ?? "";
                                        $isTT = str_contains(strtolower($ic), "tiktok");
                                        $bc  = "#888";
                                        foreach ($nbColors as $p => $cv) { if (str_contains(strtolower($ic), $p)) { $bc = $cv; break; } }
                                        preg_match('/fa-([a-z0-9\-]+)$/i', $ic, $nm);
                                        $pnm = ucfirst(str_replace(['-f','-in','-square','-'], ['','','',' '], $nm[1] ?? 'social'));
                                    @endphp
                                    <a href="{{ $social->link }}" target="_blank" rel="noopener noreferrer"
                                       title="{{ $pnm }}"
                                       style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:{{ $bc }};color:#fff;font-size:12px;text-decoration:none;flex-shrink:0;transition:opacity .2s,transform .2s;"
                                       onmouseover="this.style.opacity='.75';this.style.transform='translateY(-2px)'"
                                       onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
                                        @php $isImg=preg_match("/^https?:\/\//i",$ic); @endphp@if($isImg)<img src="{{ $ic }}" alt="" style="width:12px;height:12px;object-fit:contain;display:block;">@elseif($isTT)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" style="width:12px;height:12px;display:block;"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z"/></svg>@else<i class="{{ $ic }}" style="line-height:1;"></i>@endif
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        @endif --}}
                        @php
                            $free_shipping = DB::table('shipping_services')
                                ->whereStatus(1)
                                ->whereIsCondition(1)
                                ->first();
                        @endphp

                    </div>
                </div>
            </div>
        </div>

    </header>
    <!-- Page Content-->
    @yield('content')

    <!--    announcement banner section start   -->
    {{-- <a class="announcement-banner" href="#announcement-modal"></a>
    <div id="announcement-modal" class="mfp-hide white-popup">
        @if ($setting->announcement_type == 'newletter')
        <div class="announcement-with-content">
            <div class="left-area">
                <img src="{{ url('assets/img/' . $setting->announcement) }}" alt="">
            </div>
            <div class="right-area">
                <h3 class="">{{ $setting->announcement_title }}</h3>
                <p>{{ $setting->announcement_details }}</p>
                <form class="subscriber-form" action="{{ route('front.subscriber.submit') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="email" name="email" placeholder="{{ __('Your e-mail') }}">
                        <span class="input-group-addon"><i class="icon-mail"></i></span>
                    </div>
                    <div aria-hidden="true">
                        <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                    </div>

                    <button class="btn btn-primary btn-block mt-2" type="submit">
                        <span>{{ __('Subscribe') }}</span>
                    </button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ $setting->announcement_link }}">
            <img src="{{ url('assets/img/' . $setting->announcement) }}" alt="">
        </a>
        @endif


    </div> --}}
    <!--    announcement banner section end   -->

    <!-- Site Footer-->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Contact Info-->
                    <section class="widget widget-light-skin">
                        <div class="mb-4">
                            <img src="{{ url('assets/img/prime_beds_logo_transparent.png') }}" alt="{{ $setting->title }}" style="max-width: 180px;">
                        </div>
                        <h3 class="widget-title">{{ __('Get In Touch') }}</h3>
                        <p class="mb-1"><strong>{{ __('Address') }}: </strong> {{ $setting->footer_address }}</p>
                        <p class="mb-1"><strong>{{ __('Phone') }}: </strong> {{ $setting->footer_phone }}</p>
                        <p class="mb-1"><strong>{{ __('Email') }}: </strong> {{ $setting->footer_email }}</p>
                        <ul class="list-unstyled text-sm">
                            <li><span class=""><strong>{{ $setting->working_days_from_to }}:
                                    </strong></span>{{ $setting->friday_start }} - {{ $setting->friday_end }}</li>
                        </ul>
                        @php
                            $socialData   = json_decode($setting->social_link, true) ?? [];
                            $links        = $socialData['links'] ?? [];
                            $icons        = $socialData['icons'] ?? [];

                            // Brand colours keyed by substring of FA class name
                            $socialBrandColors = [
                                'facebook'  => '#1877F2',
                                'instagram' => '#E1306C',
                                'linkedin'  => '#0A66C2',
                                'tiktok'    => '#010101',
                                'twitter'   => '#1DA1F2',
                                'youtube'   => '#FF0000',
                                'whatsapp'  => '#25D366',
                                'snapchat'  => '#FFFC00',
                                'pinterest' => '#E60023',
                            ];

                            // TikTok SVG — FA 5.8.0 does not ship this icon
                            $tiktokSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z"/></svg>';
                        @endphp

                        <div class="footer-social-links d-flex flex-wrap mt-3" style="gap: 10px;">
                            @foreach ($links as $link_key => $link)
                                @if (!empty($link))
                                    @php
                                        $iconClass    = $icons[$link_key] ?? '';
                                        $isTikTok     = str_contains(strtolower($iconClass), 'tiktok');
                                        $brandColor   = '#555';
                                        foreach ($socialBrandColors as $platform => $color) {
                                            if (str_contains(strtolower($iconClass), $platform)) {
                                                $brandColor = $color;
                                                break;
                                            }
                                        }
                                        preg_match('/fa-([a-z0-9\-]+)$/i', $iconClass, $m);
                                        $platformName = ucfirst(str_replace(['-f', '-in', '-square', '-'], ['', '', '', ' '], $m[1] ?? 'social'));
                                    @endphp
                                    <a class="social-icon-branded"
                                       href="{{ $link }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="{{ $platformName }}"
                                       title="{{ $platformName }}"
                                       style="--brand-bg: {{ $brandColor }};">
                                        @if ($isTikTok)
                                            {!! $tiktokSvg !!}
                                        @else
                                            <i class="{{ $iconClass }}"></i>
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </section>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <!-- Customer Info-->
                    <div class="widget widget-links widget-light-skin">
                        <h3 class="widget-title">{{ __('Usefull Links') }}</h3>
                        <ul>
                            @if ($setting->is_faq == 1)
                                <li>
                                    <a class="" href="{{ route('front.faq') }}">{{ __('Faq') }}</a>
                                </li>
                            @endif
                            @foreach (DB::table('pages')->wherePos(2)->orwhere('pos', 1)->get() as $page)
                                <li><a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Subscription-->
                    <section class="widget">
                        <h3 class="widget-title">{{ __('Newsletter') }}</h3>
                        <form class="row subscriber-form" action="{{ route('front.subscriber.submit') }}" method="post">
                            @csrf
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input class="form-control" type="email" name="email"
                                        placeholder="{{ __('Your e-mail') }}">
                                    <span class="input-group-addon"><i class="icon-mail"></i></span>
                                </div>
                                <div aria-hidden="true">
                                    <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                                </div>

                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-block mt-2" type="submit">
                                    <span>{{ __('Subscribe') }}</span>
                                </button>
                            </div>
                            <div class="col-lg-12">
                                <p class="text-sm opacity-80 pt-2">
                                    {{ __('Subscribe to our Newsletter to receive early discount offers, latest news, sales and promo information.') }}
                                </p>
                            </div>
                        </form>
                        <div class="pt-3"><img class="d-block gateway_image"
                                src="{{ $setting->footer_gateway_img ? url('assets/img/' . $setting->footer_gateway_img) : asset('system/resources/assets/images/placeholder.png') }}">
                        </div>
                    </section>
                </div>
            </div>
            <!-- Copyright-->
            <p class="footer-copyright">powered by Quadtrum</p>
        </div>
    </footer>

    {{-- add whatsapp icon --}}

    @if (isset($setting->whatsapp))
        <a href="https://wa.me/{{$setting->whatsapp}}" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v7/icons/whatsapp.svg" alt="WhatsApp" />
        </a>
    @endif


    <!-- Back To Top Button-->
    <a class="scroll-to-top-btn" href="#">
        <i class="icon-chevron-up"></i>
    </a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>

    <!-- Cookie alert dialog  -->
    @if ($setting->is_cookie == 1)
        @include('cookie-consent::index')
    @endif
    <!-- Cookie alert dialog  -->


    @php
        $mainbs = [];
        $mainbs['is_announcement'] = $setting->is_announcement;
        $mainbs['announcement_delay'] = $setting->announcement_delay;
        $mainbs['overlay'] = $setting->overlay;
        $mainbs = json_encode($mainbs);
    @endphp

    <script>
        var mainbs = {!! $mainbs !!};
        var decimal_separator = '{!! $setting->decimal_separator !!}';
        var thousand_separator = '{!! $setting->thousand_separator !!}';
    </script>

    <script>
        let language = {
            Days: '{{ __('Days') }}',
            Hrs: '{{ __('Hrs') }}',
            Min: '{{ __('Min') }}',
            Sec: '{{ __('Sec') }}',
        }
    </script>



    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script type="text/javascript" src="{{ asset('assets/front/js/plugins.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/back/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/front/js/scripts.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.plugin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/myscript.js?v=4') }}"></script>
    
    @if(Auth::check())
    @php
        $wishlist_item_ids = \App\Models\Wishlist::where('user_id', Auth::user()->id)->pluck('item_id')->toArray();
    @endphp
    <script>
        window.user_wishlist_items = @json($wishlist_item_ids);
    </script>
    @endif

    <script>
        $(document).ready(function() {
            $(document).on('click', '.product-card', function(e) {
                // Ignore clicks on links or buttons inside the card
                if (!$(e.target).closest('a, button, .product-button-group, .a-t-c-mr, form').length) {
                    let link = $(this).find('.product-title a').attr('href');
                    if (link) {
                        window.location.href = link;
                    }
                }
            });
            // Update cursor via JS so we don't mess with CSS where it was undone before
            $(document).on('mouseenter', '.product-card', function() {
                $(this).css('cursor', 'pointer');
            });
        });
    </script>
    @yield('script')

    @if ($setting->is_facebook_messenger == '1')
        <!-- Messenger Chat Plugin Code -->
        <div id="fb-root"></div>

        <!-- Your Chat Plugin code -->
        <div id="fb-customer-chat" class="fb-customerchat">
        </div>

        <script>
            var chatbox = document.getElementById('fb-customer-chat');
            chatbox.setAttribute("page_id", "{{ $setting->facebook_messenger }}");
            chatbox.setAttribute("attribution", "biz_inbox");
            window.fbAsyncInit = function () {
                FB.init({
                    xfbml: true,
                    version: 'v11.0'
                });
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    @endif



    <script type="text/javascript">
        let mainurl = '{{ route('front.index') }}';

        let view_extra_index = 0;
        // Notifications
        function SuccessNotification(title) {
            $.notify({
                title: ` <strong>${title}</strong>`,
                message: '',
                icon: 'fas fa-check-circle'
            }, {
                element: 'body',
                position: null,
                type: "success",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class'
            });
        }

        function DangerNotification(title) {
            $.notify({
                // options
                title: ` <strong>${title}</strong>`,
                message: '',
                icon: 'fas fa-exclamation-triangle'
            }, {
                // settings
                element: 'body',
                position: null,
                type: "danger",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class'
            });
        }
        // Notifications Ends
    </script>

    @if (Session::has('error'))
        <script>
            $(document).ready(function () {
                DangerNotification('{{ Session::get('error') }}')
            })
        </script>
    @endif
    @if (Session::has('success'))
        <script>
            $(document).ready(function () {
                SuccessNotification('{{ Session::get('success') }}');
            })
        </script>
    @endif

</body>

</html>
