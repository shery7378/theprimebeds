@extends('master.front')
@section('title')
    {{__('Cart')}}
@endsection
@section('meta')
<meta name="keywords" content="{{$setting->meta_keywords}}">
<meta name="description" content="{{$setting->meta_description}}">
@endsection
@section('content')
    <!-- Page Title-->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
                    <li class="separator"></li>
                    <li>{{__('Cart')}}</li>
                  </ul>
            </div>
        </div>
    </div>
  </div>

  @if(Session::has('cart') && count(Session::get('cart')) > 0)
  <div class="container  padding-bottom-3x mb-1">

    <!-- Shopping Cart-->
    <div id="view_cart_load">
        @include('includes.cart')
    </div>

</div>
  @else
  <style>
    .empty-cart-card {
        background: #ffffff;
        border: 1px solid #EBE5DB;
        border-radius: 24px;
        padding: 5.5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(140, 117, 88, 0.04);
        margin-bottom: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .empty-cart-card:hover {
        box-shadow: 0 16px 48px rgba(140, 117, 88, 0.08);
    }

    .empty-cart-body {
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Illustration / Icon Glow Area */
    .empty-cart-illustration {
        position: relative;
        width: 180px;
        height: 180px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .glow-ring {
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(140, 117, 88, 0.12) 0%, rgba(140, 117, 88, 0) 70%);
        animation: pulseGlow 4s infinite ease-in-out;
    }

    .glow-ring-inner {
        position: absolute;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: #F8F6F0;
        border: 1.5px dashed var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 4px 10px rgba(0, 0, 0, 0.02);
    }

    .icon-container {
        position: relative;
        z-index: 2;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .empty-cart-illustration:hover .icon-container {
        transform: scale(1.08) translateY(-4px);
    }

    /* Floating Sparkles */
    .sparkle {
        position: absolute;
        color: #d0a64b;
        opacity: 0;
        pointer-events: none;
    }

    .sparkle-1 {
        top: 25px;
        left: 30px;
        animation: floatSparkle1 3.5s infinite ease-in-out;
    }

    .sparkle-2 {
        bottom: 35px;
        right: 25px;
        animation: floatSparkle2 4s infinite ease-in-out 1s;
    }

    .sparkle-3 {
        top: 40px;
        right: 30px;
        animation: floatSparkle3 3s infinite ease-in-out 0.5s;
    }

    /* Animations */
    @keyframes pulseGlow {
        0%, 100% {
            transform: scale(1);
            opacity: 0.6;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.85;
        }
    }

    @keyframes floatSparkle1 {
        0% { transform: translateY(0) scale(0.6) rotate(0deg); opacity: 0; }
        50% { opacity: 0.9; }
        100% { transform: translateY(-20px) scale(1.1) rotate(45deg); opacity: 0; }
    }

    @keyframes floatSparkle2 {
        0% { transform: translateY(0) scale(0.5) rotate(0deg); opacity: 0; }
        50% { opacity: 0.9; }
        100% { transform: translateY(-15px) scale(1) rotate(-30deg); opacity: 0; }
    }

    @keyframes floatSparkle3 {
        0% { transform: translateY(0) scale(0.5) rotate(0deg); opacity: 0; }
        50% { opacity: 0.9; }
        100% { transform: translateY(-18px) scale(1) rotate(20deg); opacity: 0; }
    }

    /* Typography */
    .empty-cart-title {
        font-family: 'Playfair Display', Georgia, serif;
        color: #332B23;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.85rem;
        letter-spacing: -0.3px;
    }

    .empty-cart-text {
        font-family: 'Outfit', sans-serif;
        color: #7E7367;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2.5rem;
        font-weight: 400;
    }

    /* Button Call to Action */
    .empty-cart-action {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .empty-cart-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--primary-color);
        color: #ffffff !important;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        padding: 15px 40px;
        border-radius: 50px;
        text-decoration: none !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
    }

    .empty-cart-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.25), transparent);
        transition: all 0.7s ease;
    }

    .empty-cart-btn:hover {
        background: var(--primary-color);
        filter: brightness(85%);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
    }

    .empty-cart-btn:hover::before {
        left: 100%;
    }

    .empty-cart-btn:active {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(140, 117, 88, 0.25);
    }

    .empty-cart-btn .arrow-icon {
        transition: transform 0.3s ease;
    }

    .empty-cart-btn:hover .arrow-icon {
        transform: translateX(4px);
    }
  </style>

  <div class="container padding-bottom-3x mb-1">
    <div class="empty-cart-card">
      <div class="empty-cart-body">
        <!-- Illustration container -->
        <div class="empty-cart-illustration">
          <div class="glow-ring"></div>
          <div class="glow-ring-inner">
            <div class="icon-container">
              <!-- Custom Luxury Bed Illustration SVG -->
              <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Headboard -->
                <path d="M12 40V18C12 15.7909 13.7909 14 16 14H48C50.2091 14 52 15.7909 52 18V40" stroke="var(--primary-color)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                <!-- Headboard Tufting Details -->
                <circle cx="22" cy="22" r="1.2" fill="var(--primary-color)"/>
                <circle cx="32" cy="22" r="1.2" fill="var(--primary-color)"/>
                <circle cx="42" cy="22" r="1.2" fill="var(--primary-color)"/>
                <circle cx="27" cy="28" r="1.2" fill="var(--primary-color)"/>
                <circle cx="37" cy="28" r="1.2" fill="var(--primary-color)"/>
                <!-- Pillows -->
                <rect x="16" y="30" width="13" height="7" rx="2" stroke="var(--primary-color)" stroke-width="1.5" fill="#ffffff"/>
                <rect x="35" y="30" width="13" height="7" rx="2" stroke="var(--primary-color)" stroke-width="1.5" fill="#ffffff"/>
                <!-- Mattress / Bed Base -->
                <path d="M10 40H54V46C54 47.1046 53.1046 48 52 48H12C10.8954 48 10 47.1046 10 46V40Z" stroke="var(--primary-color)" stroke-width="1.8" stroke-linejoin="round" fill="#F8F6F0"/>
                <!-- Duvet Fold -->
                <path d="M10 40C20 40 22 43 32 43C42 43 44 40 54 40" stroke="var(--primary-color)" stroke-width="1.5" stroke-linecap="round"/>
                <!-- Bed Legs -->
                <line x1="14" y1="48" x2="14" y2="52" stroke="var(--primary-color)" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="50" y1="48" x2="50" y2="52" stroke="var(--primary-color)" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
            </div>
          </div>
          <!-- Sparkles -->
          <svg class="sparkle sparkle-1" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 0L14.6 9.4L24 12L14.6 14.6L12 24L9.4 14.6L0 12L9.4 9.4L12 0Z"/>
          </svg>
          <svg class="sparkle sparkle-2" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 0L14.6 9.4L24 12L14.6 14.6L12 24L9.4 14.6L0 12L9.4 9.4L12 0Z"/>
          </svg>
          <svg class="sparkle sparkle-3" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 0L14.6 9.4L24 12L14.6 14.6L12 24L9.4 14.6L0 12L9.4 9.4L12 0Z"/>
          </svg>
        </div>
        
        <h3 class="empty-cart-title">{{__('Your shopping cart is empty.')}}</h3>
        <p class="empty-cart-text">{{__('Looks like you haven\'t added any items to the cart yet.')}}</p>
        
        <div class="empty-cart-action">
          <a class="empty-cart-btn" href="{{route('front.catalog')}}">
            <span>{{__('View our products')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="arrow-icon">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
  @endif
  <!-- Page Content-->


@endsection

