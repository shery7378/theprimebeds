@extends('master.front')

@section('title')
    {{ $page->title }}
@endsection

@section('content')

    @if(Str::contains(Str::lower($page->slug), ['our-story', 'ourstory', 'about']))
        {{-- Our Story Custom Design --}}
        <style>
            .story-hero {
                background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://picsum.photos/seed/hero1/1600/900') center/cover no-repeat;
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
                color: rgba(255, 255, 255, 0.8);
            }

            .story-hero .breadcrumb-item a {
                color: #fff;
                text-decoration: none;
            }

            .story-hero .breadcrumb-item+.breadcrumb-item::before {
                color: rgba(255, 255, 255, 0.6);
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
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                cursor: pointer;
                aspect-ratio: 4/3;
            }

            .gallery-item:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
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
                background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
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
                background: var(--primary-color);
                color: #fff;
                padding: 10px 24px;
                border-radius: 25px;
                font-size: 0.9rem;
                font-weight: 700;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                z-index: 1;
                transition: all 0.3s ease;
                white-space: nowrap;
            }

            .gallery-item:hover .gallery-label {
                background: #2c2c2c;
                color: #fff;
                transform: translateX(-50%) translateY(-5px);
                box-shadow: 0 6px 30px rgba(0, 0, 0, 0.3);
            }

            /* Redesigned story-features section */
            .story-features {
                padding: 90px 0;
                background: linear-gradient(135deg, #fdfbf7 0%, #ffffff 100%);
                border-top: 1px solid rgba(0, 0, 0, 0.05);
                position: relative;
                overflow: hidden;
            }

            .feature-card {
                background: #ffffff;
                border: 1px solid rgba(0, 0, 0, 0.05);
                border-radius: 16px;
                padding: 40px 24px 35px;
                text-align: center;
                position: relative;
                overflow: hidden;
                box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 50%;
                height: 100%;
                background: linear-gradient(to right,
                        rgba(255, 255, 255, 0) 0%,
                        rgba(255, 255, 255, 0.3) 100%);
                transform: skewX(-25deg);
                transition: 0.75s;
                pointer-events: none;
                z-index: 1;
            }

            .feature-card:hover::before {
                left: 125%;
            }

            .feature-card:hover {
                transform: translateY(-8px);
                border-color: rgba(197, 160, 89, 0.35);
                box-shadow: 0 20px 40px -15px rgba(197, 160, 89, 0.18);
            }

            .feature-icon-wrapper {
                width: 80px;
                height: 80px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: linear-gradient(135deg, #fbf8f2 0%, #f4eae0 100%);
                border: 1px solid rgba(197, 160, 89, 0.12);
                color: #c5a059;
                font-size: 30px;
                box-shadow: 0 8px 20px rgba(197, 160, 89, 0.05);
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .feature-card:hover .feature-icon-wrapper {
                background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
                color: #f4eae0;
                border-color: #1a1a1a;
                transform: scale(1.08) rotate(5deg);
                box-shadow: 0 12px 24px rgba(26, 26, 26, 0.15);
            }

            .feature-card-title {
                font-size: 0.88rem;
                font-weight: 700;
                margin-top: 24px;
                margin-bottom: 8px;
                color: #1a1a1a;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                transition: color 0.3s ease;
            }

            .feature-card:hover .feature-card-title {
                color: #c5a059;
            }

            .feature-card-desc {
                font-size: 0.85rem;
                color: #777;
                margin: 0;
                line-height: 1.5;
            }

            @media (max-width: 768px) {
                .story-hero h1 {
                    font-size: 2.5rem;
                }

                .story-intro {
                    padding: 50px 0 40px;
                }

                .story-gallery {
                    padding: 50px 0;
                }

                .gallery-grid {
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 20px;
                }

                .story-features {
                    padding: 60px 0;
                }
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
                <p>{{ __("If you're reading this, you're part of our story already. Dive a little deeper into the fun we've had along the way.") }}
                </p>
            </div>
        </div>

        {{-- Image Gallery --}}
        <div class="story-gallery">
            <div class="container">
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/start/800/600" alt="The Start">
                        <div class="gallery-label">{{ __('The Start') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/team/800/600" alt="The Team">
                        <div class="gallery-label">{{ __('The Team') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/friends/800/600" alt="Customers to Friends">
                        <div class="gallery-label">{{ __('Customers to Friends') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/stars/800/600" alt="Selling to the Stars">
                        <div class="gallery-label">{{ __('Selling to the Stars') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/designs/800/600" alt="Our Famous Designs">
                        <div class="gallery-label">{{ __('Our Famous Designs') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/community/800/600" alt="Community">
                        <div class="gallery-label">{{ __('Community') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/hq/800/600" alt="LBC HQ">
                        <div class="gallery-label">{{ __('LBC HQ') }}</div>
                    </div>

                    <div class="gallery-item">
                        <img src="https://picsum.photos/seed/uk/800/600" alt="UK">
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
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="icon-truck"></i>
                            </div>
                            <h5 class="feature-card-title">{{ __('FAST SHIPPING') }}</h5>
                            <p class="feature-card-desc">{{ __('Return of Choice') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="icon-credit-card"></i>
                            </div>
                            <h5 class="feature-card-title">{{ __('ONLINE PAYMENT') }}</h5>
                            <p class="feature-card-desc">{{ __('Safe & Secure') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="icon-headphones"></i>
                            </div>
                            <h5 class="feature-card-title">{{ __('DEDICATED CUSTOMER CARE') }}</h5>
                            <p class="feature-card-desc">{{ __('Friendly Helpdesk') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="icon-shield"></i>
                            </div>
                            <h5 class="feature-card-title">{{ __('100% SAFE') }}</h5>
                            <p class="feature-card-desc">{{ __('SSL Certified') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Default Page Layout --}}
        <style>
            .default-page-hero {
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://picsum.photos/seed/hero2/1600/900') center/cover no-repeat;
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
                color: rgba(255, 255, 255, 0.8);
            }

            .default-page-hero .breadcrumb-item a {
                color: #fff;
                text-decoration: none;
            }

            .default-page-hero .breadcrumb-item+.breadcrumb-item::before {
                color: rgba(255, 255, 255, 0.6);
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
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
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

            .d-page-content h1,
            .d-page-content h2,
            .d-page-content h3,
            .d-page-content h4,
            .d-page-content h5,
            .d-page-content h6 {
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
                .default-page-hero h1 {
                    font-size: 2rem;
                }

                .page-content-card {
                    padding: 30px 20px;
                }

                .page-content-section {
                    padding: 50px 0;
                }
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