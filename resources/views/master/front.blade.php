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
        :root {
            --primary-color: {{ $setting->primary_color ?? '#8C7558' }};
        }
        /* Fix search result dropdown overlapping the search bar */
        .site-header .search-box-wrap .input-group .serch-result {
            margin-top: 8px !important;
            border-top: 1px solid #e0e0e0 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }
        {{ $setting->custom_css }}
        /* =============================================
    SLIDER NAVIGATION ARROWS (HIDDEN)
    ============================================= */
        .popular-category-slider .owl-nav,
        .flash-deal-slider .owl-nav,
        .bestseller-slider .owl-nav,
        .newproduct-slider .owl-nav,
        .toprated-slider .owl-nav,
        .most-selling-slider .owl-nav,
        .home-blog-slider .owl-nav {
            display: none !important;
        }

        GLOBAL PRODUCT CARD REDESIGN (BEIGE LUXURY THEME)=============================================*/ .product-card {
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
            color: var(--primary-color) !important;
            background: #ffffff !important;
            line-height: 1 !important;
            white-space: nowrap !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
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

        /* Add to Cart Hover Bar (Global for all Product Cards) */
        .product-card .product-button-group {
            position: absolute !important;
            bottom: -50px !important;
            /* Start hidden below the image */
            left: 0 !important;
            width: 100% !important;
            display: flex !important;
            transition: bottom 0.3s ease !important;
            z-index: 10 !important;
            background: transparent !important;
            /* Move color to button */
            padding: 0 !important;
            margin: 0 !important;
        }

        .product-card .product-thumb:hover .product-button-group {
            bottom: 0 !important;
            /* Slide up on hover */
        }

        /* Hide all icons inside the hover bar by default */
        .product-card .product-button-group>a.product-button {
            display: none !important;
        }

        /* Explicitly ONLY show the final action button (Add to Cart / Details fallback) */
        .product-card .product-button-group>a.product-button.final-action-btn {
            display: flex !important;
            width: 100% !important;
            height: 45px !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            text-decoration: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: var(--primary-color) !important;
            /* Solid Theme Color */
            transition: background 0.2s ease, filter 0.2s ease !important;
            margin: 0 !important;
            pointer-events: auto !important;
        }

        .product-card .product-button-group a.product-button:hover {
            background: var(--primary-color) !important;
            filter: brightness(85%) !important;
        }

        .product-card .product-button-group a.product-button i {
            margin-right: 8px !important;
            /* Spacing between icon and text if we add text */
            font-size: 1.1rem !important;
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
            display: none !important;
            /* The image didn't have a category in the new design */
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

        .product-card .product-title a:hover {
            color: var(--primary-color) !important;
        }

        /* Title Flex Wrapper */
        .product-card-body>div:nth-child(2) {
            margin-bottom: 8px !important;
            align-items: flex-start !important;
            /* Align to top instead of center */
        }

        /* Wishlist Icon in Card Body */
        .product-card-body .wishlist_store {
            position: relative !important;
            top: -4px !important;
            /* Nudge up slightly from top */
            right: 6px !important;
            /* Move left slightly */
            font-size: 26px !important;
            transition: color 0.3s ease !important;
        }

        .product-card-body .wishlist_store.added {
            color: #E33535 !important;
            /* Red color when added */
        }

        /* Price Row */
        .product-card .product-price {
            display: flex !important;
            flex-direction: row !important;
            justify-content: flex-end !important;
            align-items: center !important;
            text-align: right !important;
            gap: 6px !important;
            margin-top: 5px !important;
            /* Removed auto so it sits right under the heart */
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
            .container {
                max-width: 1320px;
            }
        }

        @media (min-width: 1600px) {
            .container {
                max-width: 1500px;
            }
        }

        @media (min-width: 1900px) {
            .container {
                max-width: 1700px;
            }
        }

        /* ============================================================
           GLOBAL BREADCRUMB HERO STRIP REDESIGN (MATCHING PRODUCT PAGE)
           ============================================================ */
        .page-title {
            background: var(--primary-color) !important;
            padding: 18px 0 !important;
            position: relative !important;
            overflow: hidden !important;
            border: none !important;
            margin-bottom: 40px !important;
            border-top: none !important;
            height: auto !important;
        }

        .page-title::before {
            content: '' !important;
            position: absolute !important;
            inset: 0 !important;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") !important;
            z-index: 1 !important;
            opacity: 1 !important;
        }

        .page-title>.container {
            display: block !important;
            position: relative !important;
            z-index: 2 !important;
        }

        .breadcrumbs {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
        }

        .breadcrumbs>li {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: rgba(255, 255, 255, 0.65) !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hide the legacy separator li elements */
        .breadcrumbs>li.separator {
            display: none !important;
        }

        /* Re-use CSS / slash separator */
        .breadcrumbs>li:not(:last-child)::after {
            content: '/' !important;
            color: rgba(255, 255, 255, 0.35) !important;
            font-size: 12px !important;
        }

        .breadcrumbs>li>a {
            color: rgba(255, 255, 255, 0.65) !important;
            text-decoration: none !important;
            transition: color 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        .breadcrumbs>li>a:hover {
            color: #ffffff !important;
        }

        /* Active current item */
        .breadcrumbs>li:last-child {
            color: #ffffff !important;
            font-weight: 600 !important;
        }

        /* Ensure font awesome icon or home icon displays correctly in white */
        .breadcrumbs>li:first-child>a::before {
            color: rgba(255, 255, 255, 0.75) !important;
            font-size: 13px !important;
            margin-right: 6px !important;
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
        /* --- Search Box Wrapper --- */
        .topbar-redesigned .topbar-search-wrap {
            flex: 1 1 auto;
            max-width: 440px;
            min-width: 250px;
            padding: 0;
            margin: -3px 15px 0 35px;
            /* Moved up and right */
        }

        .topbar-redesigned .topbar-search-wrap .search-box-inner {
            width: 100%;
        }

        .topbar-redesigned .topbar-search-box {
            border: 2px solid #e2e6ec;
            border-radius: 50px;
            overflow: visible !important;
            background: #f8f9fb;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            display: flex;
            align-items: center;
            height: 44px;
            position: relative;
        }

        .topbar-redesigned .topbar-search-box:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.04);
            background: #fff;
        }

        /* Category Select */
        .topbar-redesigned .topbar-category-select {
            display: none !important;
        }

        /* Custom Premium Select Dropdown */
        .topbar-redesigned .custom-category-select-wrapper {
            position: relative;
            height: 100%;
            min-width: 195px;
            display: flex;
            align-items: center;
        }

        .topbar-redesigned .custom-category-select-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
            padding: 0 18px 0 28px;
            border-right: 1px solid #ebdcd0;
            font-size: 13.5px;
            font-weight: 600;
            color: #2c2924;
            cursor: pointer;
            user-select: none;
            transition: color 0.2s ease;
            font-family: 'Outfit', sans-serif;
        }

        .topbar-redesigned .custom-category-select-trigger:hover {
            color: var(--primary-color);
        }

        .topbar-redesigned .custom-category-select-trigger i {
            font-size: 10px;
            color: #b59469; /* matching theme arrow color */
            transition: transform 0.3s ease, color 0.2s ease;
            margin-left: 8px;
        }

        .topbar-redesigned .custom-category-select-wrapper.open .custom-category-select-trigger i {
            transform: rotate(180deg);
            color: var(--primary-color);
        }

        .topbar-redesigned .custom-category-select-options {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            border: 1.5px solid #ebdcd0;
            border-radius: 14px;
            padding: 8px 0;
            box-shadow: 0 10px 30px rgba(44, 41, 36, 0.05);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.25s;
            z-index: 1050;
            list-style: none;
            margin: 0;
        }

        .topbar-redesigned .custom-category-select-wrapper.open .custom-category-select-options {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .topbar-redesigned .custom-category-select-option {
            padding: 10px 20px;
            font-size: 13.5px;
            font-weight: 600;
            color: #5a5045;
            cursor: pointer;
            transition: all 0.22s ease;
            font-family: 'Outfit', sans-serif;
        }

        .topbar-redesigned .custom-category-select-option:hover {
            background: rgba(197, 160, 89, 0.06);
            color: var(--primary-color);
            padding-left: 24px;
        }

        .topbar-redesigned .custom-category-select-option.active {
            background: rgba(197, 160, 89, 0.1);
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Search Input */
        .topbar-redesigned .topbar-search-input {
            border: none !important;
            background: transparent !important;
            padding: 0 18px !important;
            font-size: 14px !important;
            color: #3c4858 !important;
            box-shadow: none !important;
            height: 100% !important;
            flex: 1;
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
            background: transparent;
            border: none;
            color: var(--primary-color);
            /* Blue icon to match theme */
            padding: 0 18px;
            cursor: pointer;
            transition: transform 0.15s ease, color 0.2s ease;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .topbar-redesigned .topbar-search-btn:hover {
            color: var(--primary-color);
            opacity: 0.85;
        }

        .topbar-redesigned .topbar-search-btn:active {
            transform: scale(0.92);
        }

        .topbar-redesigned .topbar-search-btn i {
            font-size: 18px;
            position: relative;
            top: -5px;
            /* Moved further up */
            left: 5px;
            /* Moved right slightly */
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
            background: var(--primary-color);
            color: #fff !important;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
        }

        .topbar-catalog-btn:hover {
            background-color: #2c2c2c !important;
            background-image: none !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(44, 44, 44, 0.3);
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
            background: #FAF7F2;
            border: 1px solid #EBE5DB;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
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
            color: var(--primary-color) !important;
        }

        .topbar-email {
            font-size: 12px;
            color: #718096 !important;
            text-decoration: none !important;
            line-height: 1.3;
            transition: color 0.25s ease;
        }

        .topbar-email:hover {
            color: var(--primary-color) !important;
        }

        /* --- Cart Item --- */
        .topbar-cart-item {
            position: relative;
            width: auto !important;
            margin-left: 0 !important;
        }

        .topbar-cart-item>a {
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

        .topbar-cart-item>a:hover {
            background: #f8f6f0;
        }

        /* Disable hover dropdown for cart specifically */
        .site-header .toolbar .toolbar-item.topbar-cart-item:not(.show-dropdown):hover>.toolbar-dropdown,
        .site-header .toolbar .toolbar-item.topbar-cart-item:not(.show-dropdown)>.toolbar-dropdown {
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(15px) !important;
            pointer-events: none !important;
            display: none !important;
        }

        /* Enable click dropdown for cart */
        .site-header .toolbar .toolbar-item.topbar-cart-item.show-dropdown>.toolbar-dropdown {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            pointer-events: auto !important;
            display: block !important;
            animation: 0.35s submenu-show;
        }

        .topbar-cart-item>a>div {
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
            background: var(--primary-color) !important;
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

        /* ===== Branded Social Icons & Redesigned Site Footer ===== */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@300;400;500;600;700&display=swap');

        .site-footer {
            background: #ffffff !important;
            /* Pristine luxury white background */
            color: #3F3A36 !important;
            /* Soft dark charcoal text */
            padding: 90px 0 0 !important;
            font-family: 'Outfit', sans-serif !important;
            border-top: 1px solid #EBE5DB !important;
            /* Elegant warm off-white border */
            position: relative !important;
        }

        .site-footer .widget {
            margin-bottom: 40px !important;
        }

        .site-footer .widget-title {
            color: var(--primary-color) !important;
            /* Gold title */
            font-family: 'Playfair Display', Georgia, serif !important;
            font-size: 19px !important;
            font-weight: 600 !important;
            text-transform: capitalize !important;
            letter-spacing: 0.5px !important;
            margin-bottom: 28px !important;
            position: relative !important;
            padding-bottom: 0 !important;
            border-bottom: none !important;
        }

        .site-footer .widget-title::after {
            content: none !important;
            display: none !important;
        }

        .site-footer p {
            color: #4E453E !important;
            /* Warm dark brown-gray */
            font-size: 14px !important;
            line-height: 1.8 !important;
            margin-bottom: 12px !important;
        }

        .site-footer .brand-description {
            font-size: 14px !important;
            line-height: 1.8 !important;
            color: #4E453E !important;
            /* Muted dark brown-gray matched with main footer text color */
            margin-bottom: 28px !important;
        }

        .site-footer p strong {
            color: var(--primary-color) !important;
            /* Bronze label */
            font-weight: 600 !important;
        }

        .site-footer ul {
            padding-left: 0 !important;
            list-style: none !important;
        }

        .site-footer ul li {
            margin-bottom: 14px !important;
            font-size: 14px !important;
            color: #4E453E !important;
            display: flex !important;
            align-items: flex-start !important;
            line-height: 1.6 !important;
        }

        /* Contact Info Styling */
        .site-footer .contact-icon {
            color: var(--primary-color) !important;
            margin-right: 12px !important;
            font-size: 16px !important;
            width: 20px !important;
            display: inline-block !important;
            flex-shrink: 0 !important;
            text-align: center !important;
            margin-top: 3px !important;
        }

        /* Footer Logo */
        .site-footer .footer-logo {
            max-width: 383px !important;
            opacity: 0.95 !important;
            transition: opacity 0.3s ease !important;
        }

        .site-footer .footer-logo:hover {
            opacity: 1 !important;
        }

        /* Redesigned Footer Links with sliding line indicator */
        .site-footer .widget-links ul>li {
            display: block !important;
            padding-left: 0 !important;
            position: relative !important;
        }

        /* Hide the default feather icon chevron */
        .site-footer .widget-links ul>li::before {
            display: none !important;
            content: none !important;
        }

        .site-footer .widget-links ul li a {
            color: #4E453E !important;
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            display: inline-flex !important;
            align-items: center !important;
            padding: 4px 0 !important;
        }

        /* Animated horizontal gold line indicator on hover */
        .site-footer .widget-links ul li a::before {
            content: '' !important;
            display: inline-block !important;
            width: 0 !important;
            height: 1px !important;
            background-color: var(--primary-color) !important;
            margin-right: 0 !important;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            opacity: 0 !important;
        }

        .site-footer .widget-links ul li a:hover {
            color: var(--primary-color) !important;
            transform: translateX(6px) !important;
            /* Elegant shift to the right */
        }

        .site-footer .widget-links ul li a:hover::before {
            width: 12px !important;
            margin-right: 8px !important;
            opacity: 1 !important;
        }

        /* Branded Social Links with overrides to prevent theme pollution */
        .footer-social-links {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
            margin-top: 24px !important;
        }

        .site-footer .footer-social-links a.social-icon-branded {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            background: transparent !important;
            background-color: transparent !important;
            color: #4E453E !important;
            border: 1px solid #D9D2C9 !important;
            font-size: 15px !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            box-shadow: none !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            padding: 0 !important;
            flex-shrink: 0 !important;
            position: relative !important;
        }

        /* Completely disable the standard background slide effect from theme stylesheet */
        .site-footer .footer-social-links a.social-icon-branded::before {
            display: none !important;
            content: none !important;
        }

        .site-footer .footer-social-links a.social-icon-branded svg,
        .site-footer .footer-social-links a.social-icon-branded i {
            width: 15px !important;
            height: 15px !important;
            fill: currentColor !important;
            color: currentColor !important;
            transition: all 0.3s ease !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            z-index: 2 !important;
        }

        .site-footer .footer-social-links a.social-icon-branded:hover {
            background: var(--brand-bg, var(--primary-color)) !important;
            background-color: var(--brand-bg, var(--primary-color)) !important;
            border-color: var(--brand-bg, var(--primary-color)) !important;
            color: #ffffff !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 15px rgba(140, 117, 88, 0.25) !important;
        }

        .site-footer .footer-social-links a.social-icon-branded:hover svg,
        .site-footer .footer-social-links a.social-icon-branded:hover i {
            fill: #ffffff !important;
            color: #ffffff !important;
        }

        /* Newsletter Form Redesign */
        .subscriber-form {
            margin-top: 20px !important;
        }

        .subscriber-form .input-group {
            position: relative !important;
            display: flex !important;
            width: 100% !important;
        }

        .subscriber-form .form-control {
            background-color: transparent !important;
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid #D9D2C9 !important;
            border-radius: 0 !important;
            padding: 12px 12px 12px 30px !important;
            color: #1E1B18 !important;
            font-size: 14px !important;
            height: auto !important;
            transition: border-color 0.3s ease !important;
            width: 100% !important;
            box-shadow: none !important;
        }

        .subscriber-form .form-control::placeholder {
            color: #9C9083 !important;
        }

        .subscriber-form .form-control:focus {
            border-bottom-color: var(--primary-color) !important;
            box-shadow: none !important;
            background-color: transparent !important;
        }

        .subscriber-form .input-group-addon {
            position: absolute !important;
            left: 0 !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: var(--primary-color) !important;
            z-index: 10 !important;
            pointer-events: none !important;
            font-size: 16px !important;
            display: flex !important;
            align-items: center !important;
        }

        .subscriber-form .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #6E5B45 100%) !important;
            border: none !important;
            border-radius: 30px !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            padding: 14px 28px !important;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            box-shadow: 0 4px 15px rgba(140, 117, 88, 0.15) !important;
            font-size: 12px !important;
            cursor: pointer !important;
            width: 100% !important;
            display: block !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
        }

        .subscriber-form .btn-primary:hover {
            background-color: #2c2c2c !important;
            background-image: none !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 24px rgba(44, 44, 44, 0.4) !important;
        }

        .subscriber-form .btn-primary:active {
            transform: translateY(0) !important;
        }

        .contact-us-widget-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: rgba(255, 255, 255, 0.15);
            color: #fff !important;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.3s ease !important;
        }

        .contact-us-widget-btn:hover {
            background-color: #2c2c2c !important;
            background-image: none !important;
            border-color: #2c2c2c !important;
            box-shadow: 0 6px 15px rgba(44, 44, 44, 0.25);
            color: #fff !important;
        }

        .gateway_image {
            opacity: 0.8 !important;
            transition: opacity 0.3s ease !important;
            filter: grayscale(100%) contrast(120%) !important;
        }

        .gateway_image:hover {
            opacity: 1 !important;
            filter: none !important;
        }

        /* Copyright Bottom Bar */
        .footer-copyright {
            margin: 60px 0 0 !important;
            padding: 30px 0 !important;
            border-top: 1px solid #EBE5DB !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            font-size: 13px !important;
            color: #7E7468 !important;
            letter-spacing: 0.5px !important;
        }

        .footer-copyright a {
            color: #7E7468 !important;
            text-decoration: none !important;
            transition: color 0.3s ease !important;
        }

        .footer-copyright a:hover {
            color: var(--primary-color) !important;
        }

        .footer-copyright-links {
            display: flex !important;
            gap: 20px !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        @media (max-width: 768px) {
            .footer-copyright {
                flex-direction: column !important;
                justify-content: center !important;
                text-align: center !important;
                gap: 15px !important;
                padding: 24px 0 !important;
            }

            .footer-copyright-links {
                justify-content: center !important;
            }
        }

        /* ===== Attractive & Premium Feature Cards Redesign ===== */
        .service-section {
            padding: 50px 0 20px !important;
            background-color: #faf8f5 !important;
            /* Extremely soft warm luxury backdrop */
        }

        .single-service.single-service2 {
            background: #ffffff !important;
            border: 1px solid #ebe5db !important;
            /* Elegant warm off-white border */
            border-radius: 16px !important;
            /* Smooth premium rounded corners */
            padding: 20px 20px 20px 96px !important;
            /* Fixed padding leaving room on the left */
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
            box-shadow: 0 4px 20px rgba(140, 117, 88, 0.04) !important;
            /* Subtle warm golden shadow */
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            position: relative !important;
            overflow: hidden !important;
            text-align: left !important;
        }

        /* Gold squircle icon backdrop using ::before */
        .single-service.single-service2::before {
            content: '' !important;
            position: absolute !important;
            left: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 56px !important;
            height: 56px !important;
            background: #fcfaf6 !important;
            /* Inner card background for icon contrast */
            border-radius: 14px !important;
            border: 1px solid #f2ede4 !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            z-index: 1 !important;
        }

        .single-service.single-service2:hover::before {
            background: var(--primary-color) !important;
            /* Fills squircle with gold on card hover */
            border-color: var(--primary-color) !important;
            transform: translateY(-50%) scale(1.1) rotate(5deg) !important;
        }

        /* Hover slide-up accent line at bottom */
        .single-service.single-service2::after {
            content: '' !important;
            position: absolute !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 0 !important;
            height: 4px !important;
            background: linear-gradient(90deg, var(--primary-color) 0%, #b89d77 100%) !important;
            transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            z-index: 3 !important;
        }

        .single-service.single-service2:hover::after {
            width: 100% !important;
        }

        /* Hover animation for the whole card */
        .single-service.single-service2:hover {
            transform: translateY(-6px) !important;
            border-color: #dcd2c3 !important;
            box-shadow: 0 12px 30px rgba(140, 117, 88, 0.1) !important;
        }

        /* Icon styling */
        .single-service.single-service2 img {
            position: absolute !important;
            left: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 56px !important;
            height: 56px !important;
            object-fit: contain !important;
            padding: 14px !important;
            /* Keeps drawing sized correctly */
            background: transparent !important;
            /* Keep background transparent to see ::before backdrop */
            border: none !important;
            margin-bottom: 0 !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            flex-shrink: 0 !important;
            z-index: 2 !important;
            pointer-events: none !important;
        }

        /* Icon transform on hover */
        .single-service.single-service2:hover img {
            filter: brightness(0) invert(1) !important;
            /* Flips dark drawing color to white */
            transform: translateY(-50%) scale(1.1) rotate(5deg) !important;
        }

        /* Content block */
        .single-service.single-service2 .content {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
        }

        /* Title inside content */
        .single-service.single-service2 .content h6,
        .single-service.single-service2 .content .contactLink {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            line-height: 1.4 !important;
            color: #2c2724 !important;
            margin: 0 !important;
            text-decoration: none !important;
            transition: color 0.3s ease !important;
            display: block !important;
        }

        .single-service.single-service2:hover .content h6,
        .single-service.single-service2:hover .content .contactLink {
            color: var(--primary-color) !important;
            /* Accent color on card hover */
        }

        /* Description text */
        .single-service.single-service2 .content p {
            font-family: 'Outfit', sans-serif !important;
            font-size: 13px !important;
            line-height: 1.5 !important;
            color: #796e65 !important;
            margin: 0 !important;
        }
        /* ===== User Dropdown Redesign ===== */
        .user-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50px;
            transition: background 0.3s ease;
        }

        .user-dropdown-trigger:hover {
            background: #f4f1eb;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #6E5B45 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(140, 117, 88, 0.2);
            transition: transform 0.3s ease;
        }

        .user-dropdown-trigger:hover .user-avatar {
            transform: scale(1.05);
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 15px);
            right: -10px;
            width: 260px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #ebe5db;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1050;
            overflow: hidden;
        }

        .user-dropdown-wrap:hover .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown-header {
            padding: 20px;
            background: #faf8f5;
            border-bottom: 1px solid #ebe5db;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-dropdown-header .header-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .user-dropdown-header .header-info {
            overflow: hidden;
        }

        .user-dropdown-header .header-info h6 {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #2c2724;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-dropdown-header .header-info p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #796e65;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-dropdown-links {
            padding: 10px;
        }

        .dropdown-link-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 12px;
            text-decoration: none !important;
            color: #4e453e;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .dropdown-link-item:hover {
            background: #faf8f5;
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-link-item .icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f4f1eb;
            color: #796e65;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .dropdown-link-item:hover .icon-wrap {
            background: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 10px rgba(140, 117, 88, 0.2);
        }

        .dropdown-link-item .link-arrow {
            font-size: 12px;
            color: #c4b8a7;
            transition: all 0.3s ease;
            margin-left: auto;
        }

        .dropdown-link-item:hover .link-arrow {
            color: var(--primary-color);
            transform: translateX(3px);
        }

        .dropdown-link-item.logout-link {
            margin-top: 5px;
            border-top: 1px dashed #ebe5db;
            border-radius: 0 0 12px 12px;
        }
        
        .dropdown-link-item.logout-link:hover {
            color: #e63946;
            background: #fff0f1;
        }

        .dropdown-link-item.logout-link:hover .icon-wrap {
            background: #e63946;
            box-shadow: 0 4px 10px rgba(230, 57, 70, 0.2);
            color: #fff;
        }

        .dropdown-link-item.logout-link:hover .link-arrow {
            color: #e63946;
        }

        /* Global Premium Form Controls & Select Dropdowns */
        .form-control-premium {
            background-color: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            font-size: 14.5px !important;
            color: #374151 !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            height: auto !important; /* Fix vertical clipping */
            font-family: 'Outfit', sans-serif !important;
        }
        .form-control-premium:focus {
            background-color: #fff !important;
            border-color: var(--primary-color, #8C7558) !important;
            box-shadow: 0 0 0 4px rgba(140, 117, 88, 0.1) !important;
        }
        select.form-control-premium {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%238C7558' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 16px center !important;
            background-size: 12px !important;
            padding-right: 44px !important;
            cursor: pointer !important;
        }

        /* ===== Premium Search Suggest Box ===== */
        .site-header .search-box-wrap .input-group .serch-result {
            position: absolute !important;
            top: calc(100% + 8px) !important;
            right: 0 !important;
            left: auto !important;
            width: 420px !important; /* A bit wider to look perfect and spacious */
            height: auto !important; /* Dynamically adjust height to content */
            background: #ffffff !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            border: 1px solid #ebe5db !important;
            z-index: 9999 !important;
            overflow: hidden !important;
            padding: 8px 0 0 0 !important;
            transition: all 0.3s ease !important;
        }

        .site-header .search-box-wrap .input-group .serch-result .s-r-inner {
            height: auto !important; /* Dynamically adjust height to content */
            max-height: 320px !important;
            overflow-y: auto !important;
            padding: 0 8px !important;
        }

        /* Custom Scrollbar for search results */
        .site-header .search-box-wrap .input-group .serch-result .s-r-inner::-webkit-scrollbar {
            width: 6px !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .s-r-inner::-webkit-scrollbar-track {
            background: #faf8f5 !important;
            border-radius: 10px !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .s-r-inner::-webkit-scrollbar-thumb {
            background: #c4b8a7 !important;
            border-radius: 10px !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .s-r-inner::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color, #8C7558) !important;
        }

        /* Each product card in search suggest list */
        .site-header .search-box-wrap .input-group .serch-result .product-card {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 10px !important;
            border-bottom: 1px solid #f4f1eb !important;
            background: transparent !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            margin-bottom: 4px !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            width: 100% !important;
            box-shadow: none !important;
            position: relative !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .product-card:hover {
            background: #faf8f5 !important;
            transform: translateX(3px) !important;
        }

        .site-header .search-box-wrap .input-group .serch-result .product-card .product-thumb {
            width: 50px !important;
            height: 50px !important;
            flex-shrink: 0 !important;
            border-radius: 6px !important;
            overflow: hidden !important;
            border: 1px solid #ebe5db !important;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .product-card .product-thumb img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 0 !important;
        }

        .site-header .search-box-wrap .input-group .serch-result .product-card .product-card-body {
            flex-grow: 1 !important;
            padding: 0 !important;
            background: transparent !important;
            text-align: left !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 2px !important;
            border: none !important;
            justify-content: center !important;
            align-items: flex-start !important;
        }

        .site-header .search-box-wrap .input-group .serch-result .product-card .product-card-body .product-title {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #2c2724 !important;
            line-height: 1.25 !important;
            position: static !important;
            float: none !important;
            display: block !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .product-card .product-card-body .product-title a {
            color: #2c2724 !important;
            text-decoration: none !important;
            transition: color 0.2s !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .product-card .product-card-body .product-title a:hover {
            color: var(--primary-color, #8C7558) !important;
        }

        .site-header .search-box-wrap .input-group .serch-result .product-card .product-card-body .product-price {
            margin: 0 !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: var(--primary-color, #8C7558) !important;
            position: static !important;
            float: none !important;
            display: block !important;
        }

        /* View all results footer */
        .site-header .search-box-wrap .input-group .serch-result .bottom-area {
            background: #faf8f5 !important;
            border-top: 1px solid #ebe5db !important;
            padding: 10px 12px !important;
            text-align: center !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .bottom-area a {
            font-family: 'Outfit', sans-serif !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: var(--primary-color, #8C7558) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            transition: opacity 0.2s !important;
        }
        .site-header .search-box-wrap .input-group .serch-result .bottom-area a:hover {
            opacity: 0.8 !important;
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
                                    <img src="{{ url('assets/img/prime_beds_logo3_transparent.png') }}"
                                        alt="{{ $setting->title }}">
                                </a>
                            </div>

                            <!-- Search / Categories-->
                            <div class="search-box-wrap d-none d-lg-flex align-items-center topbar-search-wrap">
                                <div class="search-box-inner align-self-center">
                                    <div class="search-box d-flex topbar-search-box">
                                        <div class="custom-category-select-wrapper">
                                            <div class="custom-category-select-trigger">
                                                <span class="selected-text">{{ __('All Categories') }}</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <ul class="custom-category-select-options">
                                                <li class="custom-category-select-option active" data-value="">{{ __('All Categories') }}</li>
                                                @foreach (DB::table('categories')->whereStatus(1)->get() as $category)
                                                    <li class="custom-category-select-option" data-value="{{ $category->slug }}">{{ $category->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <select name="category" id="category_select"
                                            class="categoris topbar-category-select">
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
                                                <button type="submit" class="topbar-search-btn"><i
                                                        class="icon-search"></i></button>
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
                                        <div><i class="icon-menu"></i><span class="text-label">{{ __('Menu') }}</span>
                                        </div>
                                    </a>
                                </div>

                                {{-- Catalog Download Button --}}
                                @if(isset($setting->catalog_file))
                                    <div class="d-none d-md-flex align-items-center topbar-catalog-wrap">
                                        <a href="{{ asset('assets/files/' . $setting->catalog_file) }}"
                                            class="topbar-catalog-btn" download>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                <polyline points="7 10 12 15 17 10" />
                                                <line x1="12" y1="15" x2="12" y2="3" />
                                            </svg>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
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
                                <div class="d-none d-md-flex align-items-center"
                                    style="width: auto; justify-content: center; padding: 0; margin-left: 20px; margin-right: 20px; position: relative; left: 10px;">
                                    @if (!Auth::user())
                                        <a href="{{ route('user.login') }}"
                                            style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;color:inherit;font-size:.85rem;font-weight:600;transition:color .2s;"
                                            onmouseover="this.style.color='{{ $setting->primary_color ?? '#4e73df' }}'"
                                            onmouseout="this.style.color='inherit'">
                                            <span style="display:inline-flex;align-items:center;justify-content:center;
                                                                                     width:32px;height:32px;border-radius:50%;
                                                                                     border:2px solid currentColor;">
                                                <i class="icon-user"
                                                    style="font-size:15px;line-height:1;margin:0!important;padding:0!important;position:relative;top:2px;"></i>
                                            </span>
                                            <span class="d-none d-lg-inline">{{ __('Login') }}</span>
                                        </a>
                                    @else
                                        <div class="user-dropdown-wrap">
                                            <div class="user-dropdown-trigger">
                                                <div class="user-avatar">
                                                    <i class="icon-user"></i>
                                                </div>
                                            </div>
                                            <div class="user-dropdown-menu">
                                                <div class="user-dropdown-header">
                                                    <div class="header-avatar">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <div class="header-info">
                                                        <h6>{{ Auth::user()->first_name }} {{ Auth::user()->last_name ?? '' }}</h6>
                                                        <p>{{ Auth::user()->email }}</p>
                                                    </div>
                                                </div>
                                                <div class="user-dropdown-links">
                                                    <a href="{{ route('user.dashboard') }}" class="dropdown-link-item">
                                                        <div class="icon-wrap"><i class="icon-grid"></i></div>
                                                        <span>{{ __('Dashboard') }}</span>
                                                        <i class="icon-chevron-right link-arrow"></i>
                                                    </a>
                                                    <a href="{{ route('user.logout') }}" class="dropdown-link-item logout-link">
                                                        <div class="icon-wrap"><i class="icon-log-out"></i></div>
                                                        <span>{{ __('Logout') }}</span>
                                                        <i class="icon-chevron-right link-arrow"></i>
                                                    </a>
                                                </div>
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
                                                <span
                                                    class="count-label cart_count">{{ Session::has('cart') ? count(Session::get('cart')) : '0' }}</span>
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
                                    <div class="d-flex flex-wrap px-3 pb-3"
                                        style="gap:10px;border-top:1px solid rgba(255,255,255,.12);margin-top:6px;">
                                        @foreach($socials as $social)
                                            @if(!empty($social->link))
                                                @php
                                                    $smColors = ["facebook" => "#1877F2", "instagram" => "#E1306C", "linkedin" => "#0A66C2", "tiktok" => "#010101", "twitter" => "#1DA1F2", "youtube" => "#FF0000", "whatsapp" => "#25D366", "pinterest" => "#E60023", "snapchat" => "#FFFC00", "telegram" => "#26A5E4"];
                                                    $ic = $social->icon ?? "";
                                                    $isTT = str_contains(strtolower($ic), "tiktok");
                                                    $bc = "#888";
                                                    foreach ($smColors as $p => $cv) {
                                                        if (str_contains(strtolower($ic), $p)) {
                                                            $bc = $cv;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <a href="{{ $social->link }}" target="_blank" rel="noopener noreferrer"
                                                    style="display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:{{ $bc }};color:#fff;font-size:14px;text-decoration:none;">
                                                    @php $isImgM = preg_match("/^https?:\/\//i", $ic); @endphp@if($isImgM)<img
                                                        src="{{ $ic }}" alt=""
                                                    style="width:14px;height:14px;object-fit:contain;display:block;">@elseif($isTT)<svg
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"
                                                            style="width:14px;height:14px;display:block;">
                                                            <path
                                                                d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z" />
                                                        </svg>@else<i class="{{ $ic }}" style="line-height:1;"></i>@endif
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
                        <div class="d-none d-lg-flex align-items-center"
                            style="gap:8px;margin-left:auto;padding-left:20px;">
                            @php
                            $nbColors=["facebook"=>"#1877F2","instagram"=>"#E1306C","linkedin"=>"#0A66C2","tiktok"=>"#010101","twitter"=>"#1DA1F2","youtube"=>"#FF0000","whatsapp"=>"#25D366","pinterest"=>"#E60023","snapchat"=>"#FFFC00","telegram"=>"#26A5E4"];
                            @endphp
                            @foreach($socials as $social)
                            @if(!empty($social->link))
                            @php
                            $ic = $social->icon ?? "";
                            $isTT = str_contains(strtolower($ic), "tiktok");
                            $bc = "#888";
                            foreach ($nbColors as $p => $cv) { if (str_contains(strtolower($ic), $p)) { $bc = $cv;
                            break; } }
                            preg_match('/fa-([a-z0-9\-]+)$/i', $ic, $nm);
                            $pnm = ucfirst(str_replace(['-f','-in','-square','-'], ['','','',' '], $nm[1] ?? 'social'));
                            @endphp
                            <a href="{{ $social->link }}" target="_blank" rel="noopener noreferrer" title="{{ $pnm }}"
                                style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:{{ $bc }};color:#fff;font-size:12px;text-decoration:none;flex-shrink:0;transition:opacity .2s,transform .2s;"
                                onmouseover="this.style.opacity='.75';this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
                                @php $isImg=preg_match("/^https?:\/\//i",$ic); @endphp@if($isImg)<img src="{{ $ic }}"
                                    alt=""
                                    style="width:12px;height:12px;object-fit:contain;display:block;">@elseif($isTT)<svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"
                                    style="width:12px;height:12px;display:block;">
                                    <path
                                        d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z" />
                                </svg>@else<i class="{{ $ic }}" style="line-height:1;"></i>@endif
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
    <a class="announcement-banner" href="#announcement-modal"></a>
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


    </div>
    <!--    announcement banner section end   -->

    <!-- Site Footer-->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <!-- Column 1: Brand Info & Socials -->
                <div class="col-lg-4 col-md-6">
                    <section class="widget widget-light-skin">
                        <div class="mb-4">
                            <img class="footer-logo" src="{{ url('assets/img/footer_logo_monochrome.png') }}"
                                alt="{{ $setting->title }}">
                        </div>
                        <p class="brand-description">
                            {{ __('Crafting the ultimate sleep sanctuaries. The Prime Beds combines premium materials with master craftsmanship for nights of pure luxury and tranquility.') }}
                        </p>
                        @php
                            $socialData = json_decode($setting->social_link, true) ?? [];
                            $links = $socialData['links'] ?? [];
                            $icons = $socialData['icons'] ?? [];
                            $socialBrandColors = [
                                'facebook' => '#1877F2',
                                'instagram' => '#E1306C',
                                'linkedin' => '#0A66C2',
                                'tiktok' => '#010101',
                                'twitter' => '#000000',
                                'youtube' => '#FF0000',
                                'whatsapp' => '#25D366',
                                'snapchat' => '#FFFC00',
                                'pinterest' => '#E60023',
                            ];

                            $defaultIcons = [
                                0 => 'fab fa-facebook-f',
                                1 => 'fab fa-instagram',
                                2 => 'fab fa-linkedin-in',
                                3 => 'fab fa-twitter',
                                4 => 'fab fa-youtube',
                                5 => 'fab fa-whatsapp',
                            ];

                            $tiktokSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                                                                                                                                                                                                                <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z" />
                                                                                                                                                                                                                            </svg>';
                            $xSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                                                 </svg>';
                        @endphp

                        <div class="footer-social-links d-flex flex-wrap">
                            @foreach ($links as $link_key => $link)
                                @if (!empty($link))
                                    @php
                                        $iconClass = $icons[$link_key] ?? $defaultIcons[$link_key] ?? 'fab fa-link';
                                        $isTikTok = str_contains(strtolower($iconClass), 'tiktok');
                                        $brandColor = $setting->primary_color ?? '#8C7558';

                                        foreach ($socialBrandColors as $platform => $color) {
                                            if (str_contains(strtolower($iconClass), $platform) || str_contains(strtolower($link), $platform)) {
                                                $brandColor = $color;
                                                break;
                                            }
                                        }

                                        preg_match('/fa-([a-z0-9\-]+)$/i', $iconClass, $m);
                                        $platformName = ucfirst(str_replace(['-f', '-in', '-square', '-'], ['', '', '', ' '], $m[1] ?? 'social'));
                                    @endphp
                                    <a class="social-icon-branded" href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                                        aria-label="{{ $platformName }}" title="{{ $platformName }}"
                                        style="--brand-bg: {{ $brandColor }};">
                                        @if ($isTikTok)
                                            {!! $tiktokSvg !!}
                                        @elseif(str_contains(strtolower($iconClass), 'twitter') || str_contains(strtolower($link), 'twitter') || str_contains(strtolower($link), 'x.com'))
                                            {!! $xSvg !!}
                                        @else
                                            <i class="{{ $iconClass }}"></i>
                                        @endif
                                    </a>
                                @endif
                            @endforeach

                            @if (empty($links))
                                <a class="social-icon-branded" href="#" title="Facebook" style="--brand-bg: #1877F2;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="social-icon-branded" href="#" title="Instagram" style="--brand-bg: #E1306C;">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a class="social-icon-branded" href="#" title="LinkedIn" style="--brand-bg: #0A66C2;">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a class="social-icon-branded" href="#" title="X (Twitter)" style="--brand-bg: #000000;">
                                    {!! $xSvg !!}
                                </a>
                                <a class="social-icon-branded" href="#" title="YouTube" style="--brand-bg: #FF0000;">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a class="social-icon-branded" href="#" title="WhatsApp" style="--brand-bg: #25D366;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </section>
                </div>

                <!-- Column 2: Useful Links -->
                <div class="col-lg-2 col-sm-6">
                    <div class="widget widget-links widget-light-skin">
                        <h3 class="widget-title">{{ __('Useful Links') }}</h3>
                        <ul>
                            @if ($setting->is_faq == 1)
                                <li>
                                    <a href="{{ route('front.faq') }}">{{ __('Faq') }}</a>
                                </li>
                            @endif
                            @foreach (DB::table('pages')->wherePos(2)->orwhere('pos', 1)->get() as $page)
                                <li><a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Column 3: Contact Info -->
                <div class="col-lg-3 col-sm-6">
                    <section class="widget widget-light-skin">
                        <h3 class="widget-title">{{ __('Get In Touch') }}</h3>
                        <ul class="list-unstyled text-sm contact-list">
                            @if(!empty($setting->footer_address))
                                <li>
                                    <i class="icon-map-pin contact-icon"></i>
                                    <span>{{ $setting->footer_address }}</span>
                                </li>
                            @endif
                            @if(!empty($setting->footer_phone))
                                <li>
                                    <i class="icon-phone contact-icon"></i>
                                    <span>{{ $setting->footer_phone }}</span>
                                </li>
                            @endif
                            @if(!empty($setting->footer_email))
                                <li>
                                    <i class="icon-mail contact-icon"></i>
                                    <span>{{ $setting->footer_email }}</span>
                                </li>
                            @endif
                            @if(!empty($setting->working_days_from_to))
                                <li>
                                    <i class="icon-clock contact-icon"></i>
                                    <span>
                                        <strong>{{ $setting->working_days_from_to }}:</strong><br>
                                        {{ $setting->friday_start }} - {{ $setting->friday_end }}
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </section>
                </div>

                <!-- Column 4: Newsletter -->
                <div class="col-lg-3 col-md-6">
                    <section class="widget">
                        <h3 class="widget-title">{{ __('Newsletter') }}</h3>
                        <form class="row subscriber-form" action="{{ route('front.subscriber.submit') }}" method="post">
                            @csrf
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input class="form-control" type="email" name="email"
                                        placeholder="{{ __('Your e-mail') }}" required>
                                    <span class="input-group-addon"><i class="icon-mail"></i></span>
                                </div>
                                <div aria-hidden="true">
                                    <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-block mt-3" type="submit">
                                    <span>{{ __('Subscribe') }}</span>
                                </button>
                            </div>
                            <div class="col-lg-12">
                                <p class="text-sm opacity-80 pt-3"
                                    style="line-height: 1.5; font-size: 13px !important; color: #8A7F73 !important;">
                                    {{ __('Subscribe to our Newsletter to receive early discount offers, latest news, sales and promo information.') }}
                                </p>
                            </div>
                        </form>
                        <div class="pt-3">
                            <img class="d-block gateway_image"
                                src="{{ $setting->footer_gateway_img ? url('assets/img/' . $setting->footer_gateway_img) : asset('system/resources/assets/images/placeholder.png') }}"
                                alt="Payment Gateways" style="max-height: 35px; object-fit: contain;">
                        </div>
                    </section>
                </div>
            </div>

            <!-- Copyright Footer Bottom -->
            <div class="footer-copyright">
                <div>
                    &copy; {{ date('Y') }} <a href="{{ route('front.index') }}">{{ $setting->title }}</a>. All rights
                    reserved.
                </div>
                <div>
                    <ul class="footer-copyright-links">
                        <li><a href="{{ route('front.faq') }}">{{ __('FAQ') }}</a></li>
                        <li>powered by Quadtrum</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    {{-- add whatsapp icon --}}

    @if (isset($setting->whatsapp))
        <a href="https://wa.me/{{$setting->whatsapp}}" class="whatsapp-float" target="_blank"
            title="Chat with us on WhatsApp">
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
            Days: '{{ __('
            Days ') }}',
            Hrs: '{{ __('
            Hrs ') }}',
            Min: '{{ __('
            Min ') }}',
            Sec: '{{ __('
            Sec ') }}',
        }
    </script>



    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script type="text/javascript" src="{{ asset('assets/front/js/plugins.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/back/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/front/js/scripts.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.plugin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/myscript.js?v=12') }}"></script>

    @if(Auth::check())
        @php
            $wishlist_item_ids = \App\Models\Wishlist::where('user_id', Auth::user()->id)->pluck('item_id')->toArray();
        @endphp
        <script>
            window.user_wishlist_items = @json($wishlist_item_ids);
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $(document).on('click', '.product-card', function (e) {
                // Ignore clicks if they were on links/buttons, OR if the target was detached from DOM (like when Add to Cart spinner is added)
                if (!$(e.target).closest('a, button, .product-button-group, .a-t-c-mr, form').length && $.contains(document, e.target)) {
                    let link = $(this).find('.product-title a').attr('href');
                    if (link) {
                        window.location.href = link;
                    }
                }
            });
            // Update cursor via JS so we don't mess with CSS where it was undone before
            $(document).on('mouseenter', '.product-card', function () {
                $(this).css('cursor', 'pointer');
            });

            // Cart click dropdown toggle
            $(document).on('click', '.topbar-cart-item > a', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).parent().toggleClass('show-dropdown');
            });

            // Close cart dropdown when clicking outside
            $(document).on('click', function (e) {
                if (!document.body.contains(e.target)) {
                    return;
                }
                if (!$(e.target).closest('.topbar-cart-item').length) {
                    $('.topbar-cart-item').removeClass('show-dropdown');
                }
            });

            // Custom select category dropdown toggle
            $(document).on('click', '.custom-category-select-trigger', function (e) {
                e.stopPropagation();
                $(this).parent().toggleClass('open');
            });

            // Close custom select when clicking outside
            $(document).on('click', function () {
                $('.custom-category-select-wrapper').removeClass('open');
            });

            // Option selection on custom select
            $(document).on('click', '.custom-category-select-option', function () {
                let value = $(this).attr('data-value');
                let text = $(this).text();
                
                // Update trigger text
                $(this).closest('.custom-category-select-wrapper').find('.selected-text').text(text);
                
                // Set active class
                $(this).addClass('active').siblings().removeClass('active');
                
                // Sync with original select
                $('#category_select').val(value).trigger('change');
                
                // Close dropdown
                $(this).closest('.custom-category-select-wrapper').removeClass('open');
            });

            // Init custom select option matching initial select value
            let initialVal = $('#category_select').val();
            if (initialVal) {
                let activeOption = $(`.custom-category-select-option[data-value="${initialVal}"]`);
                if (activeOption.length) {
                    $('.custom-category-select-trigger .selected-text').text(activeOption.text());
                    activeOption.addClass('active').siblings().removeClass('active');
                }
            }
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