@extends('master.front')

@section('title')
    {{ $page->title }}
@endsection

@section('content')

@if(Str::contains(Str::lower($page->slug), ['our-story', 'ourstory', 'about']))
{{-- Our Story Custom Design --}}
<style>
    .story-hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1540518614846-7eded433c457?w=1600&q=80') center/cover no-repeat;
        min-height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        position: relative;
    }
    .story-hero::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to bottom, transparent, #f8f9fa);
        pointer-events: none;
    }
    .story-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        letter-spacing: -1px;
    }
    .story-hero .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        justify-content: center;
    }
    .story-hero .breadcrumb-item {
        color: rgba(255,255,255,0.8);
    }
    .story-hero .breadcrumb-item a {
        color: #fff;
        text-decoration: none;
    }
    .story-hero .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
        content: "/";
    }

    .story-intro {
        padding: 80px 0 60px;
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        text-align: center;
    }
    .story-intro h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }
    .story-intro p {
        font-size: 1.1rem;
        color: #666;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
    }

    .story-gallery {
        padding: 80px 0;
        background: #fff;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }
    .gallery-item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        aspect-ratio: 4/3;
    }
    .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        text-align: center;
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .gallery-item:hover .gallery-caption {
        transform: translateY(0);
    }
    .gallery-label {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        color: #1a1a1a;
        padding: 10px 24px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 700;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        z-index: 1;
        transition: all 0.3s ease;
    }
    .gallery-item:hover .gallery-label {
        background: #1a1a1a;
        color: #fff;
        transform: translateX(-50%) translateY(-5px);
        box-shadow: 0 6px 30px rgba(0,0,0,0.3);
    }

    .story-features {
        padding: 80px 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
        border-top: 1px solid #e5e5e5;
    }
    .feature-box {
        text-align: center;
        padding: 30px 20px;
        transition: transform 0.3s ease;
    }
    .feature-box:hover {
        transform: translateY(-5px);
    }
    .feature-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #1a1a1a;
        font-size: 28px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .feature-box:hover .feature-icon {
        transform: scale(1.1);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
        color: #fff;
    }
    .feature-box h5 {
        font-size: 0.8rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .feature-box p {
        font-size: 0.85rem;
        color: #888;
        margin: 0;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .story-hero h1 { font-size: 2.5rem; }
        .story-intro { padding: 50px 0 40px; }
        .story-gallery { padding: 50px 0; }
        .gallery-grid { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .story-features { padding: 50px 0; }
    }
</style>

{{-- Hero Banner --}}
<div class="story-hero">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Intro Section --}}
<div class="story-intro">
    <div class="container">
        <h2>{{ $page->title }}</h2>
        <p>{{ __("If you're reading this, you're part of our story already. Dive a little deeper into the fun we've had along the way.") }}</p>
    </div>
</div>

{{-- Image Gallery --}}
<div class="story-gallery">
    <div class="container">
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1615873968403-89e068629265?w=800&q=80" alt="The Start">
                <div class="gallery-label">{{ __('The Start') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&q=80" alt="The Team">
                <div class="gallery-label">{{ __('The Team') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=800&q=80" alt="Customers to Friends">
                <div class="gallery-label">{{ __('Customers to Friends') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80" alt="Selling to the Stars">
                <div class="gallery-label">{{ __('Selling to the Stars') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1505693314120-0d443867891c?w=800&q=80" alt="Our Famous Designs">
                <div class="gallery-label">{{ __('Our Famous Designs') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&q=80" alt="Community">
                <div class="gallery-label">{{ __('Community') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80" alt="LBC HQ">
                <div class="gallery-label">{{ __('LBC HQ') }}</div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=800&q=80" alt="UK">
                <div class="gallery-label">{{ __('UK') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Features Section --}}
<div class="story-features">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-truck"></i>
                    </div>
                    <h5>{{ __('FAST SHIPPING') }}</h5>
                    <p>{{ __('Return of Choice') }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-credit-card"></i>
                    </div>
                    <h5>{{ __('ONLINE PAYMENT') }}</h5>
                    <p>{{ __('Safe & Secure') }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-headphones"></i>
                    </div>
                    <h5>{{ __('DEDICATED CUSTOMER CARE') }}</h5>
                    <p>{{ __('Friendly Helpdesk') }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-shield"></i>
                    </div>
                    <h5>{{ __('100% SAFE') }}</h5>
                    <p>{{ __('SSL Certified') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@else
{{-- Default Page Layout --}}
<style>
    .default-page-hero {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?w=1600&q=80') center/cover no-repeat;
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
    }
    .default-page-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .default-page-hero .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        justify-content: center;
    }
    .default-page-hero .breadcrumb-item {
        color: rgba(255,255,255,0.8);
    }
    .default-page-hero .breadcrumb-item a {
        color: #fff;
        text-decoration: none;
    }
    .default-page-hero .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
        content: "/";
    }
    .page-content-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    .page-content-card {
        background: #fff;
        border-radius: 16px;
        padding: 50px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }
    .page-content-card h4 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1a1a1a;
        text-align: center;
    }
    .d-page-content {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
    }
    .d-page-content h1, .d-page-content h2, .d-page-content h3,
    .d-page-content h4, .d-page-content h5, .d-page-content h6 {
        color: #1a1a1a;
        margin-top: 30px;
        margin-bottom: 15px;
        font-weight: 700;
    }
    .d-page-content p {
        margin-bottom: 20px;
    }
    .d-page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    @media (max-width: 768px) {
        .default-page-hero h1 { font-size: 2rem; }
        .page-content-card { padding: 30px 20px; }
        .page-content-section { padding: 50px 0; }
    }
</style>

{{-- Hero Banner --}}
<div class="default-page-hero">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Page Content --}}
<div class="page-content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content-card">
                    <div class="d-page-content">
                        {!! $page->details !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@endsection
