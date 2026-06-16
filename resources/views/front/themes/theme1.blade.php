@extends('master.front')
@section('meta')
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
    <meta name="description" content="{{ $setting->meta_description }}">
@endsection

@section('content')
<style>
    .contactLink{
        cursor: pointer;
        text-decoration: none;
    }
    .contactLink:hover{
        color:{{$setting->primary_color}}
    }
    
    /* -------------------------------------
       PREMIUM PRODUCT CARD STYLES
       ------------------------------------- */
    .product-card {
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        background-color: #ffffff;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        margin-bottom: 20px;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .product-thumb {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .product-card:hover .product-thumb img {
        transform: scale(1.08);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .product-badge2 {
        top: 45px;
    }

    .product-button-group {
        position: absolute;
        bottom: -50px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 10px;
        background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 3;
    }

    .product-card:hover .product-button-group {
        bottom: 0;
        opacity: 1;
    }

    .product-button-group a {
        background-color: #ffffff;
        color: #333;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .product-button-group a:hover {
        background-color: {{$setting->primary_color}};
        color: #ffffff;
        transform: scale(1.1);
    }

    .product-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        text-align: left;
    }

    .product-category {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .product-category a {
        color: #888;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .product-category a:hover {
        color: {{$setting->primary_color}};
    }

    .product-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .product-title a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .product-title a:hover {
        color: {{$setting->primary_color}};
    }

    .product-price {
        margin-top: auto;
        font-size: 1.15rem;
        font-weight: 800;
        color: {{$setting->primary_color}};
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .product-price del {
        font-size: 0.9rem;
        color: #a0a0a0;
        font-weight: 500;
    }
</style>

    {{-- ==================== NEW TOP BANNER (from new column) ==================== --}}
    @if (isset($top_banner) && $top_banner && isset($top_banner['top_banner_img']))
        <div class="top-banner-section mt-1 mb-4">
            <style>
                .top-banner-img {
                    width: 100%;
                    height: auto; /* Natural height by default */
                    object-fit: cover;
                    object-position: center;
                    display: block;
                }
                /* On large screens, allow the image to show its full natural height up to a max, preventing the top/bottom cropping that looks like it's hiding under the header */
                @media (min-width: 992px) {
                    .top-banner-img { 
                        height: auto !important; 
                        max-height: 600px; 
                    }
                }
                /* On smaller screens, enforce a minimum fixed height so the banner doesn't become tiny */
                @media (max-width: 991px) and (min-width: 768px) {
                    .top-banner-img { height: 350px !important; }
                }
                @media (max-width: 767px) {
                    .top-banner-img { height: 300px !important; }
                }
                @media (max-width: 575px) {
                    .top-banner-img { height: 260px !important; }
                }
                
                /* Custom Fade Transition for Carousel */
                .carousel-fade .carousel-item {
                    opacity: 0;
                    transition: opacity 0.3s ease-in-out;
                    transform: none !important;
                }
                .carousel-fade .carousel-item.active,
                .carousel-fade .carousel-item-next.carousel-item-left,
                .carousel-fade .carousel-item-prev.carousel-item-right {
                    z-index: 1;
                    opacity: 1;
                }
                .carousel-fade .active.carousel-item-left,
                .carousel-fade .active.carousel-item-right {
                    z-index: 0;
                    opacity: 0;
                    transition: opacity 0s 0.3s;
                }
            </style>
            <div class="container-fluid p-0">
                <div id="topBannerCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner" style="overflow: hidden;">
                        @php $first = true; @endphp
                        @for($i = 1; $i <= 3; $i++)
                            @php
                                $img_key = 'img' . $i;
                                $url_key = 'url' . $i;
                                $title_key = 'title' . $i;
                                $color_key = 'title_color' . $i;
                                
                                // Fallback for old single image setup
                                if ($i == 1 && !isset($top_banner[$img_key]) && isset($top_banner['top_banner_img'])) {
                                    $top_banner[$img_key] = $top_banner['top_banner_img'];
                                    $top_banner[$url_key] = isset($top_banner['top_banner_url']) ? $top_banner['top_banner_url'] : '#';
                                    $top_banner[$title_key] = isset($top_banner['top_banner_title']) ? $top_banner['top_banner_title'] : '';
                                    $top_banner[$color_key] = isset($top_banner['top_banner_title_color']) ? $top_banner['top_banner_title_color'] : '#ffffff';
                                }
                            @endphp
                            
                            @if(isset($top_banner[$img_key]))
                                <div class="carousel-item {{ $first ? 'active' : '' }}">
                                    <a href="{{ isset($top_banner[$url_key]) && $top_banner[$url_key] ? $top_banner[$url_key] : '#' }}" class="d-block w-100 position-relative">
                                        <img src="{{ url('assets/img/' . $top_banner[$img_key]) }}" class="top-banner-img w-100" alt="{{ isset($top_banner[$title_key]) ? $top_banner[$title_key] : 'Banner' }}">
                                        @if(isset($top_banner[$title_key]) && $top_banner[$title_key])
                                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 10px; padding: 15px; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); width: auto;">
                                                <h3 style="color: {{ $setting->slider_color ?: (isset($top_banner[$color_key]) ? $top_banner[$color_key] : '#ffffff') }} !important; margin: 0;">{{ $top_banner[$title_key] }}</h3>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                @php $first = false; @endphp
                            @endif
                        @endfor
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var bannerCarousel = document.getElementById('topBannerCarousel');
                if (bannerCarousel) {
                    var firstImg = bannerCarousel.querySelector('.carousel-item:first-child img');
                    function setBannerHeight() {
                        if (firstImg) {
                            firstImg.style.height = 'auto';
                            var targetHeight = firstImg.offsetHeight;
                            if (targetHeight > 0) {
                                var items = bannerCarousel.querySelectorAll('.carousel-item img');
                                items.forEach(function(img) {
                                    if (img !== firstImg) {
                                        img.style.height = targetHeight + 'px';
                                        img.style.objectFit = 'cover';
                                        img.style.width = '100%';
                                    }
                                });
                            }
                        }
                    }
                    // Run on load
                    if (firstImg.complete) {
                        setBannerHeight();
                    } else {
                        firstImg.addEventListener('load', setBannerHeight);
                    }
                    // Run on resize
                    window.addEventListener('resize', setBannerHeight);
                }
            });
        </script>
    @endif
    {{-- ==================== END NEW TOP BANNER ==================== --}}

    @if ($setting->is_slider == 1)
        <div class="slider-area-wrapper d-none" style="display: none !important;">
            <div class="container-fluid p-0">
                <div class="row m-0">
                    <div class="col-lg-12 p-0">
                        <style>
                            .slider-area-wrapper {
                                margin-top: 0 !important;
                            }
                            .hero-slider {
                                border-radius: 0 !important;
                                margin-bottom: 30px;
                            }
                            .hero-slider-main .item {
                                position: relative;
                                width: 100%;
                                aspect-ratio: 1920 / 720; /* Adjust to match your slider image's actual width/height ratio */
                                height: auto;
                                padding: 0 !important;
                                display: block;
                                overflow: hidden;
                                background-color: #0d2d4e; /* fallback color matching banner if letterboxing occurs */
                            }
                            .hero-slider-main .item img.slider-bg-img {
                                width: 100%;
                                height: 100%;
                                max-height: none !important;
                                object-fit: cover; /* Fill the box uniformly - prevents stretching/half-cut images */
                                object-position: center;
                                display: block;
                            }
                            .hero-slider-main .item .item-inner {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                padding: 5%;
                                z-index: 2;
                                pointer-events: none; /* Let clicks pass through to the slider link if needed */
                            }
                            .hero-slider-main .item .item-inner * {
                                pointer-events: auto; /* Re-enable clicks on buttons inside */
                            }

                            /* Responsive aspect ratios to keep the slider proportional on smaller screens */
                            @media (max-width: 991px) and (min-width: 768px) {
                                .hero-slider-main .item { aspect-ratio: 4 / 3; }
                            }
                            @media (max-width: 767px) {
                                .hero-slider-main .item { aspect-ratio: 1 / 1; }
                            }
                            @media (max-width: 575px) {
                                .hero-slider-main .item { aspect-ratio: 4 / 5; }
                            }

                            @media (min-width: 1400px) {
                                .sright-image {
                                    height: 311px !important;
                                }
                            }
                        </style>
                        <div class="hero-slider">
                            <div class="hero-slider-main owl-carousel dots-inside">
                                @foreach ($sliders as $slider)
                                    <a href="{{ $slider->link != '#' ? $slider->link : 'javascript:;' }}" class="item
                                                @if (DB::table('languages')->where('is_default', 1)->first()->rtl == 1) d-flex justify-content-end @endif
                                                ">
                                        <img src="{{ url('assets/img/' . $slider->photo) }}" class="slider-bg-img" alt="Slider Image">
                                        
                                        @if($slider->title || $slider->details)
                                        <div class="item-inner">
                                            <div class="from-bottom">
                                                <div class="title text-body"
                                                    style="color:{{ $setting->slider_color ?: ($slider->text_color ?? '#fff') }} !important">
                                                    {{ $slider->title }}</div>
                                                <div class="subtitle text-body"
                                                    style="color:{{ $setting->slider_color ?: ($slider->text_color ?? '#fff') }} !important">
                                                    {{ $slider->details }}</div>
                                            </div>
                                            @if ($slider->link != '#')
                                                <span class="btn btn-primary scale-up delay-1 mt-3" style="width: max-content;">
                                                    <span>{{ __('Buy Now') }}</span>
                                                </span>
                                            @endif
                                        </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- 
                    @if (isset($hero_banner))
                        <div class="col-lg-4 d-none d-lg-block">
                            <a href="{{ $hero_banner['url1'] }}" class="sright-image">
                                <img src="{{ url('assets/img/' . $hero_banner['img1']) }}" alt="" style="object-fit: cover; width: 100%; height: 100%;">
                                <div class="inner-content">

                                    @if (isset($hero_banner['subtitle1']))
                                        <p
                                            style="color:{{ isset($hero_banner['subtitle_color1']) && $hero_banner['subtitle_color1'] ? $hero_banner['subtitle_color1'] : (isset($setting->slider_color) ? $setting->slider_color : '#fff') }} !important">
                                            {{ $hero_banner['subtitle1'] }}</p>
                                    @endif

                                    @if (isset($hero_banner['title1']))
                                        <h4
                                            style="color:{{ isset($hero_banner['title_color1']) && $hero_banner['title_color1'] ? $hero_banner['title_color1'] : (isset($setting->slider_color) ? $setting->slider_color : '#fff') }} !important">
                                            {{ $hero_banner['title1'] }}</h4>
                                    @endif
                                </div>
                            </a>
                            <a href="{{ $hero_banner['url2'] }}" class="sright-image mb-0">
                                <img src="{{ url('assets/img/' . $hero_banner['img2']) }}" alt="" style="object-fit: cover; width: 100%; height: 100%;">
                                <div class="inner-content">
                                    @if (isset($hero_banner['subtitle2']))
                                        <p
                                            style="color:{{ isset($hero_banner['subtitle_color2']) && $hero_banner['subtitle_color2'] ? $hero_banner['subtitle_color2'] : (isset($setting->slider_color) ? $setting->slider_color : '#fff') }} !important">
                                            {{ $hero_banner['subtitle2'] }}</p>
                                    @endif
                                    @if (isset($hero_banner['title2']))
                                        <h4
                                            style="color:{{ isset($hero_banner['title_color2']) && $hero_banner['title_color2'] ? $hero_banner['title_color2'] : (isset($setting->slider_color) ? $setting->slider_color : '#fff') }} !important">
                                            {{ $hero_banner['title2'] }}</h4>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                    --}}

                </div>
            </div>
        </div>
    @endif


    @if ($setting->is_service == 1)
        <section class="service-section">
            <div class="container">
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-lg-3 col-sm-6 text-center mb-30">
                            <div class="single-service single-service2">
                                <img src="{{ url('assets/img/' . $service->photo) }}" alt="Shipping">
                                <div class="content">
                                    @if ($service->title === "24/7 Customer Support")
                                        <a href="{{route('front.contact')}}" class="mb-2 h6 contactLink">{{ $service->title }}</a>
                                    @else
                                        <h6 class="mb-2">{{ $service->title }}</h6>
                                    @endif

                                    <p class="text-sm text-muted mb-0">{{ $service->details }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    @if ($setting->campaign_status == 1)
        <div class="deal-of-day-section mt-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="h3">{{ $setting->campaign_title }}</h2>
                            <div class="right-area">
                                <div class="countdown countdown-alt" data-date-time="{{ $setting->campaign_end_date }}">
                                </div>
                                <a class="right_link" href="{{ route('front.campaign') }}">{{ __('View All') }} <i
                                        class="icon-chevron-right"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">

                    <div class="col-lg-12">
                        <div class="popular-category-slider owl-carousel">
                            @foreach ($campaign_items as $compaign_item)
                                <div class="slider-item">
                                    <div class="product-card">
                                        <div class="product-thumb">
                                            @if (!$compaign_item->item->is_stock())
                                                <div class="product-badge bg-secondary border-default text-body">
                                                    {{ __('out of stock') }}
                                                </div>
                                            @endif

                                            @php $discPct = PriceHelper::DiscountPercentage($compaign_item->item); @endphp
                                            @if($discPct)
                                                <div class="product-badge product-badge2 bg-info">-{{ $discPct }}</div>
                                            @endif
                                            <img class="lazy" src="{{ url('assets/img/' . $compaign_item->item->thumbnail) }}"
                                                alt="Product">
                                            <div class="product-button-group">
                                                <a class="product-button wishlist_store"
                                                    href="{{ route('user.wishlist.store', $compaign_item->item->id) }}"
                                                    title="{{ __('Wishlist') }}"><i class="icon-heart"></i></a>
                                                <a class="product-button"
                                                    href="{{ route('front.product', $compaign_item->item->slug) }}"
                                                    title="{{ __('Details') }}"><i class="icon-search"></i></a>
                                                @include('includes.item_footer', ['sitem' => $compaign_item->item])
                                            </div>
                                        </div>
                                        <div class="product-card-body">

                                            <div class="product-category"><a
                                                    href="{{ route('front.catalog') . '?category=' . $compaign_item->item->category->slug }}">{{ $compaign_item->item->category->name }}</a>
                                            </div>
                                            <h3 class="product-title"><a
                                                    href="{{ route('front.product', $compaign_item->item->slug) }}">
                                                    {{ Str::limit($compaign_item->item->name, 35) }}
                                                </a></h3>
                                            {{-- <div class="rating-stars">
                                                {!! Helper::renderStarRating($compaign_item->item->reviews->avg('rating')) !!}
                                            </div> --}}
                                            <h4 class="product-price">
                                                @if ($compaign_item->item->previous_price != 0)
                                                    <del>{{ PriceHelper::setPreviousPrice($compaign_item->item->previous_price) }}</del>
                                                @endif

                                                {{ PriceHelper::grandCurrencyPrice($compaign_item->item) }}
                                            </h4>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endif


    @if ($setting->is_three_c_b_first == 1)
        <div class="bannner-section mt-60">
            <div class="container ">
                <div class="row gx-3">
                    <div class="col-md-4">
                        <a href="{{ $banner_first['firsturl1'] }}" class="genius-banner">
                            <img src="{{ url('assets/img/' . $banner_first['img1']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_first['subtitle1']))
                                    <p style="color:{{ isset($banner_first['subtitle_color1']) && $banner_first['subtitle_color1'] ? $banner_first['subtitle_color1'] : '#fff' }} !important">{{ $banner_first['subtitle1'] }}</p>
                                @endif
                                @if (isset($banner_first['title1']))
                                    <h4 style="color:{{ isset($banner_first['title_color1']) && $banner_first['title_color1'] ? $banner_first['title_color1'] : '#fff' }} !important">{{ $banner_first['title1'] }}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ $banner_first['firsturl2'] }}" class="genius-banner">
                            <img src="{{ url('assets/img/' . $banner_first['img2']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_first['subtitle2']))
                                    <p style="color:{{ isset($banner_first['subtitle_color2']) && $banner_first['subtitle_color2'] ? $banner_first['subtitle_color2'] : '#fff' }} !important">{{ $banner_first['subtitle2'] }}</p>
                                @endif
                                @if (isset($banner_first['title2']))
                                    <h4 style="color:{{ isset($banner_first['title_color2']) && $banner_first['title_color2'] ? $banner_first['title_color2'] : '#fff' }} !important">{{ $banner_first['title2'] }}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ $banner_first['firsturl3'] }}" class="genius-banner">
                            <img src="{{ url('assets/img/' . $banner_first['img3']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_first['subtitle3']))
                                    <p style="color:{{ isset($banner_first['subtitle_color3']) && $banner_first['subtitle_color3'] ? $banner_first['subtitle_color3'] : '#fff' }} !important">{{ $banner_first['subtitle3'] }} </p>
                                @endif
                                @if (isset($banner_first['title3']))
                                    <h4 style="color:{{ isset($banner_first['title_color3']) && $banner_first['title_color3'] ? $banner_first['title_color3'] : '#fff' }} !important">{{ $banner_first['title3'] }}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if ($setting->is_popular_category == 1)
        <section class="newproduct-section popular-category-sec mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="h3">{{ $popular_category_title }}</h2>
                            <div class="links">
                                @foreach ($popular_categories as $key => $popular_categorie)
                                    <a class="category_get {{ $loop->first ? 'active' : '' }}" data-target="popular_category_view"
                                        data-href="{{ route('front.popular.category', [$popular_categorie->slug, 'popular_category', 'slider']) }}"
                                        href="javascript:;"
                                        class="{{ $loop->first ? 'active' : '' }}">{{ $popular_categorie->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popular_category_view d-none">
                    <img src="{{ url('assets/img/ajax_loader.gif') }}" alt="">
                </div>

                <div class="row" id="popular_category_view">
                    <div class="col-lg-12">
                        <div class="popular-category-slider  owl-carousel">
                            @foreach ($popular_category_items as $popular_category_item)
                                <div class="slider-item">
                                    <div class="product-card">
                                        <div class="product-thumb">

                                            @if (!$popular_category_item->is_stock())
                                                <div class="product-badge bg-secondary border-default text-body
                                                            ">
                                                    {{ __('out of stock') }}
                                                </div>
                                            @endif
                                            @php $discPct2 = PriceHelper::DiscountPercentage($popular_category_item); @endphp
                                            @if($discPct2)
                                                <div class="product-badge product-badge2 bg-info">-{{ $discPct2 }}</div>
                                            @endif
                                            <img class="lazy"
                                                src="{{ url('assets/img/' . $popular_category_item->thumbnail) }}"
                                                alt="Product">
                                            <div class="product-button-group">

                                                @include('includes.item_footer', [
                                                'sitem' => $popular_category_item,
                                                ])
                                            </div>
                                        </div>
                                        <div class="product-card-body">
                                            <div class="product-category"><a
                                                    href="{{ route('front.catalog') . '?category=' . $popular_category_item->category->slug }}">{{ $popular_category_item->category->name }}</a>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="product-title m-0"><a
                                                    href="{{ route('front.product', $popular_category_item->slug) }}">
                                                    {{ Str::limit($popular_category_item->name, 35) }}
                                                </a></h3>
    <a class="wishlist_store" href="{{ route('user.wishlist.store', $popular_category_item->id) }}" title="{{ __('Wishlist') }}" style="color: var(--primary-color); font-size: 18px; line-height: 1;"><i class="icon-heart"></i></a>
</div>
                                            {{-- <div class="rating-stars">
                                                {!! Helper::renderStarRating($popular_category_item->reviews->avg('rating')) !!}
                                            </div> --}}
                                            <h4 class="product-price">
                                                @if ($popular_category_item->previous_price != 0)
                                                    <del>{{ PriceHelper::setPreviousPrice($popular_category_item->previous_price) }}</del>
                                                @endif
                                                {{ PriceHelper::grandCurrencyPrice($popular_category_item) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    @if ($setting->is_three_c_b_second == 1)
        <div class="bannner-section mt-60">
            <div class="container ">
                <div class="row gx-3">
                    <div class="col-md-4">
                        <a href="{{ $banner_secend['url1'] }}" class="genius-banner">
                            <img class="lazy" src="{{ url('assets/img/' . $banner_secend['img1']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_secend['subtitle1']))
                                    <p style="color:{{ isset($banner_secend['subtitle_color1']) && $banner_secend['subtitle_color1'] ? $banner_secend['subtitle_color1'] : '#fff' }} !important">{{ $banner_secend['subtitle1'] }}</p>
                                @endif

                                @if (isset($banner_secend['title1']))
                                    <h4 style="color:{{ isset($banner_secend['title_color1']) && $banner_secend['title_color1'] ? $banner_secend['title_color1'] : '#fff' }} !important">{{ $banner_secend['title1'] }}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ $banner_secend['url2'] }}" class="genius-banner">
                            <img class="lazy" src="{{ url('assets/img/' . $banner_secend['img2']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_secend['subtitle2']))
                                    <p style="color:{{ isset($banner_secend['subtitle_color2']) && $banner_secend['subtitle_color2'] ? $banner_secend['subtitle_color2'] : '#fff' }} !important">{{ $banner_secend['subtitle2'] }}</p>
                                @endif

                                @if (isset($banner_secend['title2']))
                                    <h4 style="color:{{ isset($banner_secend['title_color2']) && $banner_secend['title_color2'] ? $banner_secend['title_color2'] : '#fff' }} !important"> {{ $banner_secend['title2'] }}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ $banner_secend['url3'] }}" class="genius-banner">
                            <img class="lazy" src="{{ url('assets/img/' . $banner_secend['img3']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_secend['subtitle3']))
                                    <p style="color:{{ isset($banner_secend['subtitle_color3']) && $banner_secend['subtitle_color3'] ? $banner_secend['subtitle_color3'] : '#fff' }} !important">{{ $banner_secend['subtitle3'] }} </p>
                                @endif

                                @if (isset($banner_secend['title3']))
                                    <h4 style="color:{{ isset($banner_secend['title_color3']) && $banner_secend['title_color3'] ? $banner_secend['title_color3'] : '#fff' }} !important">{{ $banner_secend['title3'] }}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ==================== MOST SELLING PRODUCTS SECTION ==================== --}}
    @if (($setting->is_recently_added ?? 1) == 1)
        <section class="newproduct-section most-selling-sec mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="h3">{{ __('Most Selling Products') }}</h2>
                            <a class="right_link" href="{{ route('front.catalog') }}">{{ __('View All') }} <i class="icon-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-12">
                        <div class="most-selling-slider owl-carousel">
                            @foreach ($recently_added_items as $recent_item)
                                <div class="slider-item">
                                    <div class="product-card">
                                        <div class="product-thumb">
                                            @if (!$recent_item->is_stock())
                                                <div class="product-badge bg-secondary border-default text-body">
                                                    {{ __('out of stock') }}
                                                </div>
                                            @endif
                                            @php $discPct3 = PriceHelper::DiscountPercentage($recent_item); @endphp
                                            @if($discPct3)
                                                <div class="product-badge product-badge2 bg-info">-{{ $discPct3 }}</div>
                                            @endif
                                            <img class="lazy" src="{{ url('assets/img/' . $recent_item->thumbnail) }}" alt="Product">
                                            <div class="product-button-group">
                                                <a class="product-button wishlist_store"
                                                    href="{{ route('user.wishlist.store', $recent_item->id) }}"
                                                    title="{{ __('Wishlist') }}"><i class="icon-heart"></i></a>
                                                <a class="product-button"
                                                    href="{{ route('front.product', $recent_item->slug) }}"
                                                    title="{{ __('Details') }}"><i class="icon-search"></i></a>
                                                @include('includes.item_footer', ['sitem' => $recent_item])
                                            </div>
                                        </div>
                                        <div class="product-card-body">
                                            <div class="product-category"><a
                                                    href="{{ route('front.catalog') . '?category=' . $recent_item->category->slug }}">{{ $recent_item->category->name }}</a>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="product-title m-0"><a href="{{ route('front.product', $recent_item->slug) }}">
                                                    {{ Str::limit($recent_item->name, 35) }}
                                                </a></h3>
    <a class="wishlist_store" href="{{ route('user.wishlist.store', $recent_item->id) }}" title="{{ __('Wishlist') }}" style="color: var(--primary-color); font-size: 18px; line-height: 1;"><i class="icon-heart"></i></a>
</div>
                                            <h4 class="product-price">
                                                @if ($recent_item->previous_price != 0)
                                                    <del>{{ PriceHelper::setPreviousPrice($recent_item->previous_price) }}</del>
                                                @endif
                                                {{ PriceHelper::grandCurrencyPrice($recent_item) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- ==================== END MOST SELLING PRODUCTS SECTION ==================== --}}





    @if ($setting->is_highlighted == 1 && count($featured_items) > 0)
        <section class="selected-product-section speacial-product-sec mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            {{-- <div class="links">
                                <a data-href="{{ route('front.get.product', 'feature') }}" data-target="type_product_view"
                                    href="javascript:;" class="product_get active">{{ __('Featured') }}</a>
                                <a data-href="{{ route('front.get.product', 'best') }}" data-target="type_product_view"
                                    class="product_get" href="javascript:;">{{ __('Best Seller') }}</a>
                                <a data-href="{{ route('front.get.product', 'top') }}" data-target="type_product_view"
                                    class="product_get" href="javascript:;">{{ __('Top Rated') }}</a>
                                <a data-href="{{ route('front.get.product', 'new') }}" data-target="type_product_view"
                                    class="product_get" href="javascript:;">{{ __('New Product') }}</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="type_product_view d-none">
                        <img src="{{ url('assets/img/ajax_loader.gif') }}" alt="">
                    </div>
                    <div class="col-lg-12" id="type_product_view">

                        <div class="features-slider  owl-carousel">
                            @foreach ($featured_items as $item)
                                    <div class="slider-item">
                                        <div class="product-card ">
                                            <div class="product-thumb">
                                                @if (!$item->is_stock())
                                                    <div class="product-badge bg-secondary border-default text-body
                                                                        ">
                                                        {{ __('out of stock') }}
                                                    </div>
                                                @endif
                                                @php $discPct4 = PriceHelper::DiscountPercentage($item); @endphp
                                                @if($discPct4)
                                                    <div class="product-badge product-badge2 bg-info">-{{ $discPct4 }}</div>
                                                @endif
                                                <img class="lazy" src="{{ url('assets/img/' . $item->thumbnail) }}" alt="Product">
                                                <div class="product-button-group">
                                                    <a class="product-button wishlist_store"
                                                        href="{{ route('user.wishlist.store', $item->id) }}"
                                                        title="{{ __('Wishlist') }}"><i class="icon-heart"></i></a>
                                                    <a class="product-button"
                                                        href="{{ route('front.product', $item->slug) }}"
                                                        title="{{ __('Details') }}"><i class="icon-search"></i></a>
                                                    @include('includes.item_footer', ['sitem' => $item])
                                                </div>
                                            </div>
                                            <div class="product-card-inner">
                                                <div class="product-card-body">
                                                    <div class="product-category"><a
                                                            href="{{ route('front.catalog') . '?category=' . $item->category->slug }}">{{ $item->category->name }}</a>
                                                    </div>
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="product-title m-0"><a href="{{ route('front.product', $item->slug) }}">
                                                            {{ Str::limit($item->name, 35) }}
                                                        </a></h3>
    <a class="wishlist_store" href="{{ route('user.wishlist.store', $item->id) }}" title="{{ __('Wishlist') }}" style="color: var(--primary-color); font-size: 18px; line-height: 1;"><i class="icon-heart"></i></a>
</div>
                                                    {{-- <div class="rating-stars">
                                                        {!! Helper::renderStarRating($item->reviews->avg('rating')) !!}
                                                    </div> --}}
                                                    <h4 class="product-price">
                                                        @if ($item->previous_price != 0)
                                                            <del>{{ PriceHelper::setPreviousPrice($item->previous_price) }}</del>
                                                        @endif
                                                        {{ PriceHelper::grandCurrencyPrice($item) }}
                                                    </h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    {{-- @if ($setting->is_two_column_category == 1)
    <div class="flash-sell-area mt-50">
        <div class="container">
            <div class="row gx-3 justify-content-center">
                @foreach ($two_column_categoriess as $two_column_key => $two_column_category)
                <div class="col-xl-4 col-lg-6">
                    <div class="section-title">
                        <h2 class="h3">{{ $two_column_category['name']->name }}</h2>
                    </div>
                    <div class="main-content">
                        <div class="newproduct-slider owl-carousel">
                            @foreach ($two_column_categoriess[$two_column_key]['items']->chunk(4) as
                            $two_column_category_itemt)
                            <div class="slider-item">
                                @foreach ($two_column_category_itemt as $two_column_category_item)
                                <div class="product-card p-col">
                                    <a class="product-thumb"
                                        href="{{ route('front.product', $two_column_category_item->slug) }}">
                                        @if (!$two_column_category_item->is_stock())
                                        <div class="product-badge bg-secondary border-default text-body
                                                        ">
                                            {{ __('out of stock') }}</div>
                                        @endif

                                        <img class="lazy"
                                            src="{{ url('assets/img/' . $two_column_category_item->thumbnail) }}"
                                            alt="Product">
                                    </a>
                                    <div class="product-card-body">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="product-title m-0"><a
                                                href="{{ route('front.product', $two_column_category_item->slug) }}">
                                                {{ Str::limit($two_column_category_item->name, 40) }}
                                            </a></h3>
    <a class="wishlist_store" href="{{ route('user.wishlist.store', $two_column_category_item->id) }}" title="{{ __('Wishlist') }}" style="color: var(--primary-color); font-size: 18px; line-height: 1;"><i class="icon-heart"></i></a>
</div>
                                        <div class="rating-stars">
                                            {!! Helper::renderStarRating($two_column_category_item->reviews->avg('rating'))
                                            !!}
                                        </div>
                                        <h4 class="product-price">
                                            @if ($two_column_category_item->previous_price != 0)
                                            <del>{{ PriceHelper::setPreviousPrice($two_column_category_item->previous_price)
                                                }}</del>
                                            @endif
                                            {{ PriceHelper::grandCurrencyPrice($two_column_category_item) }}
                                        </h4>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    @endif --}}


    @if ($setting->is_featured_category == 1)
        <section class="selected-product-section featured_cat_sec sps-two mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="h3">{{ $feature_category_title }}</h2>
                            <div class="links">
                                @foreach ($feature_categories as $key => $feature_category)
                                    <a class="category_get {{ $loop->first ? 'active' : '' }}" data-target="feature_category_view"
                                        data-href="{{ route('front.popular.category', [$feature_category->slug, 'feature_category', 'normal']) }}"
                                        href="javascript:;"
                                        class="{{ $loop->first ? 'active' : '' }}">{{ $feature_category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feature_category_view d-none">
                    <img src="{{ url('assets/img/ajax_loader.gif') }}" alt="">
                </div>
                <div class="row g-3" id="feature_category_view">
                    @if (count($feature_category_items) > 0)
                    @foreach ($feature_category_items as $feature_category_item)
                        <div class="col-gd">
                            <div class="product-card">
                                <div class="product-thumb">

                                    @if (!$feature_category_item->is_stock())
                                        <div class="product-badge bg-secondary border-default text-body
                                                    ">
                                            {{ __('out of stock') }}
                                        </div>
                                    @endif
                                    @php $discPct5 = PriceHelper::DiscountPercentage($feature_category_item); @endphp
                                    @if($discPct5)
                                        <div class="product-badge product-badge2 bg-info">-{{ $discPct5 }}</div>
                                    @endif
                                    <img class="lazy" src="{{ url('assets/img/' . $feature_category_item->thumbnail) }}"
                                        alt="Product">
                                    <div class="product-button-group">
                                        <a class="product-button wishlist_store"
                                            href="{{ route('user.wishlist.store', $feature_category_item->id) }}"
                                            title="{{ __('Wishlist') }}"><i class="icon-heart"></i></a>
                                        <a class="product-button"
                                            href="{{ route('front.product', $feature_category_item->slug) }}"
                                            title="{{ __('Details') }}"><i class="icon-search"></i></a>
                                        @include('includes.item_footer', [
                                        'sitem' => $feature_category_item,
                                        ])
                                    </div>
                                </div>
                                <div class="product-card-body">
                                    <div class="product-category"><a
                                            href="{{ route('front.catalog') . '?category=' . $feature_category_item->category->slug }}">{{ $feature_category_item->category->name }}</a>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="product-title m-0"><a href="{{ route('front.product', $feature_category_item->slug) }}">
                                            {{ Str::limit($feature_category_item->name, 35) }}
                                        </a></h3>
    <a class="wishlist_store" href="{{ route('user.wishlist.store', $feature_category_item->id) }}" title="{{ __('Wishlist') }}" style="color: var(--primary-color); font-size: 18px; line-height: 1;"><i class="icon-heart"></i></a>
</div>
                                    {{-- <div class="rating-stars">
                                        {!! Helper::renderStarRating($feature_category_item->reviews->avg('rating')) !!}
                                    </div> --}}
                                    <h4 class="product-price">
                                        @if ($feature_category_item->previous_price != 0)
                                            <del>{{ PriceHelper::setPreviousPrice($feature_category_item->previous_price) }}</del>
                                        @endif
                                        {{ PriceHelper::grandCurrencyPrice($feature_category_item) }}
                                    </h4>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">{{ __('No products found in this category.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ==================== CLIENT TESTIMONIALS SECTION ==================== --}}
    <section class="testimonials-section mt-50 mb-50 container" style="background: #faf7f2; padding: 75px 40px; border-radius: 24px; border: 1px solid #ebe5db;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5 border-0" style="margin-bottom: 45px !important; position: relative; z-index: 10;">
                        <span style="font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 700; color: var(--primary-color); letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">{{ __('Customer Stories') }}</span>
                        <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 36px; font-weight: 700; color: #2c2724; margin: 0; position: relative; display: inline-block;">{{ __('Testimonials') }}</h2>
                        <p style="font-family: 'Outfit', sans-serif; font-size: 15px; color: #796e65; margin-top: 8px; margin-bottom: 0;">{{ __('Hear from our satisfied customers here') }}</p>
                    </div>
                </div>
            </div>

            @if($testimonials->count() > 0)
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <!-- Hidden Progress Bar (required by JS controller) -->
                    <div id="carousel-progress" style="display: none; width: 0%;"></div>

                    <!-- Main Carousel -->
                    <div id="testimonial-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000" style="max-width: 1200px; margin: 0 auto; position: relative;">

                        <!-- Carousel Items -->
                        <div class="carousel-inner">
                            @foreach ($testimonials->chunk(3) as $chunkIndex => $chunk)
                            <div class="carousel-item @if($chunkIndex == 0) active @endif" data-bs-interval="6000">
                                <div class="row px-4">
                                    @foreach($chunk as $testimonial)
                                    <div class="col-md-4 mb-4">
                                        <div style="padding: 10px; height: 100%;">
                                            <div style="background: #ffffff; padding: 40px 30px; border-radius: 24px; border: 1px solid #ebe5db; box-shadow: 0 10px 40px rgba(140, 117, 88, 0.04); text-align: center; position: relative; overflow: hidden; height: 100%; display: flex; flex-direction: column;">
                                                <!-- Centered Quote Icon -->
                                                <div style="font-size: 32px; color: var(--primary-color); opacity: 0.8; margin-bottom: 15px; display: inline-block;">
                                                    <i class="fas fa-quote-left"></i>
                                                </div>

                                                <!-- Stars -->
                                                <div style="margin-bottom: 20px; position: relative; z-index: 2;">
                                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                                        <i class="fas fa-star" style="color: #e5a93b; margin: 0 4px; font-size: 16px;"></i>
                                                    @endfor
                                                </div>

                                                <!-- Testimonial Text -->
                                                <p style="font-family: 'Playfair Display', Georgia, serif; font-style: italic; font-weight: 500; font-size: 18px; line-height: 1.6; color: #3f3a36; margin-bottom: 30px; position: relative; z-index: 2; flex-grow: 1;">"{{ \Illuminate\Support\Str::limit($testimonial->testimonial_text, 150) }}"</p>

                                                <!-- Client Info -->
                                                <div style="border-top: 1px solid #ebe5db; padding-top: 25px; position: relative; z-index: 2; margin-top: auto;">
                                                    <div style="display: flex; align-items: center; justify-content: center; gap: 14px;">
                                                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #FAF7F2 0%, #EADDCF 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-color); border: 1px solid #EBE5DB; font-weight: 600; font-size: 16px; font-family: 'Outfit', sans-serif; flex-shrink: 0;">
                                                            {{ substr($testimonial->client_name, 0, 1) }}
                                                        </div>
                                                        <div style="text-align: left;">
                                                            <h5 style="margin: 0 0 3px 0; color: #2c2724; font-family: 'Outfit', sans-serif; font-weight: 600; font-size: 15px; letter-spacing: 0.3px;">{{ $testimonial->client_name }}</h5>
                                                            <p style="margin: 0; color: var(--primary-color); font-family: 'Outfit', sans-serif; font-weight: 500; font-size: 11px; letter-spacing: 1px; text-transform: uppercase;">{{ $testimonial->client_title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination Indicators (Dots) -->
                        @if($testimonials->count() > 3)
                        <div class="carousel-indicators-custom" style="display: flex; justify-content: center; gap: 8px; margin-top: 20px; margin-bottom: 10px;">
                            @foreach ($testimonials->chunk(3) as $chunkIndex => $chunk)
                            <button class="carousel-indicator-btn @if($chunkIndex == 0) active @endif" data-bs-slide-to="{{ $chunkIndex }}" aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                            @endforeach
                        </div>
                        @endif


                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="text-muted">{{ __('No testimonials available yet.') }}</p>
                </div>
            </div>
            @endif
        </div>
    </section>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes starPulse {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes progressAnimation {
            from {
                width: 0%;
            }
            to {
                width: 100%;
            }
        }

        /* Carousel Container */
        #testimonial-carousel {
            position: relative;
            padding: 0; /* Reset default padding as buttons overlap border */
        }

        /* Carousel Items */
        #testimonial-carousel .carousel-item {
            padding: 20px 0;
            min-height: 380px;
            align-items: center;
        }

        /* Navigation Buttons */
        #testimonial-carousel .carousel-control-prev,
        #testimonial-carousel .carousel-control-next {
            width: 48px !important;
            height: 48px !important;
            background-color: #ffffff !important;
            border: 1px solid #ebe5db !important;
            border-radius: 50% !important;
            padding: 0 !important;
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 10 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            opacity: 1 !important;
            box-shadow: 0 4px 15px rgba(140, 117, 88, 0.05) !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            cursor: pointer !important;
        }

        #testimonial-carousel .carousel-control-prev {
            left: -24px !important;
        }

        #testimonial-carousel .carousel-control-next {
            right: -24px !important;
        }

        #testimonial-carousel .carousel-control-prev i,
        #testimonial-carousel .carousel-control-next i {
            font-size: 16px !important;
            color: var(--primary-color) !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        #testimonial-carousel .carousel-control-prev:hover,
        #testimonial-carousel .carousel-control-next:hover {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12) !important;
        }

        #testimonial-carousel .carousel-control-prev:hover i,
        #testimonial-carousel .carousel-control-next:hover i {
            color: #ffffff !important;
        }

        #testimonial-carousel .carousel-control-prev:hover {
            transform: translateY(-50%) translateX(-4px) !important;
        }

        #testimonial-carousel .carousel-control-next:hover {
            transform: translateY(-50%) translateX(4px) !important;
        }

        /* Indicator Buttons (Dots) */
        .carousel-indicator-btn {
            width: 10px !important;
            height: 10px !important;
            border-radius: 50% !important;
            background: #eaddcf !important; /* Soft warm light beige */
            border: none !important;
            margin: 0 4px !important;
            padding: 0 !important;
            opacity: 1 !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
            cursor: pointer !important;
        }

        .carousel-indicator-btn:hover {
            background: #c8b7a6 !important;
        }

        .carousel-indicator-btn.active {
            background: var(--primary-color) !important; /* Gold active color */
            transform: scale(1.2) !important;
        }

        /* Responsive - Mobile */
        @media (max-width: 768px) {
            #testimonial-carousel {
                padding: 0 50px;
            }

            #testimonial-carousel .carousel-control-prev i,
            #testimonial-carousel .carousel-control-next i {
                font-size: 20px;
            }

            #testimonial-carousel .carousel-item {
                min-height: 350px;
            }
        }

        @media (max-width: 480px) {
            #testimonial-carousel {
                padding: 0 35px;
            }

            #testimonial-carousel .carousel-control-prev,
            #testimonial-carousel .carousel-control-next {
                width: 40px;
                height: 40px;
            }

            #testimonial-carousel .carousel-control-prev i,
            #testimonial-carousel .carousel-control-next i {
                font-size: 18px;
            }

            #testimonial-carousel .carousel-item {
                min-height: 300px;
                padding: 15px 0;
            }
        }

        .carousel-progress-bar {
            position: relative;
        }

        .carousel-progress {
            animation-play-state: running;
        }

        #testimonial-carousel:hover .carousel-progress {
            animation-play-state: paused;
        }

        @media (max-width: 768px) {
            .carousel-progress-bar {
                margin-bottom: 20px;
            }

            .testimonial-carousel-custom .carousel-item {
                min-height: auto;
            }

            .testimonial-carousel-custom .carousel-control-prev,
            .testimonial-carousel-custom .carousel-control-next {
                position: absolute;
                width: 40px;
                height: 40px;
                opacity: 0.8;
                top: auto;
                bottom: 10px;
                transform: translateY(0);
            }

            .testimonial-carousel-custom .carousel-control-prev {
                left: 15px;
            }

            .testimonial-carousel-custom .carousel-control-next {
                right: 15px;
            }
        }

        @media (max-width: 480px) {
            .testimonial-indicators li {
                width: 10px !important;
                height: 10px !important;
                margin: 0 5px !important;
            }
        }

        /* ===== Redesigned Animated Counters Section ===== */
        .animated-counters-section {
            background: #faf7f2 !important; /* Matches service cards & testimonials background */
            border: 1px solid #ebe5db !important;
            border-radius: 24px !important;
            padding: 70px 40px !important;
        }

            .counter-box {
                background: #ffffff !important;
                border: 1px solid #ebe5db !important;
                border-radius: 20px !important;
                padding: 40px 30px !important;
                box-shadow: 0 8px 30px rgba(140, 117, 88, 0.03) !important;
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
                position: relative !important;
                overflow: hidden !important;
            }

            .counter-box::after {
                content: '' !important;
                position: absolute !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 0 !important;
                height: 4px !important;
                background: linear-gradient(90deg, var(--primary-color) 0%, #b89d77 100%) !important;
                transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            }

            .counter-box:hover::after {
                width: 100% !important;
            }

            .counter-box:hover {
                transform: translateY(-6px) !important;
                border-color: #dcd2c3 !important;
                box-shadow: 0 15px 35px rgba(140, 117, 88, 0.08) !important;
            }

            /* Icon Badge */
            .counter-icon-wrap {
                width: 64px !important;
                height: 64px !important;
                border-radius: 50% !important;
                background: #fcfaf6 !important;
                border: 1px solid #f2ede4 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin: 0 auto 20px !important;
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            }

            .counter-box:hover .counter-icon-wrap {
                background: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
                transform: scale(1.1) rotate(5deg) !important;
            }

            .counter-icon-wrap i {
                font-size: 24px !important;
                color: var(--primary-color) !important;
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            }

            .counter-box:hover .counter-icon-wrap i {
                color: #ffffff !important;
            }

            /* Number text */
            .counter-number {
                font-family: 'Outfit', sans-serif !important;
                font-size: 40px !important;
                font-weight: 700 !important;
                color: #2c2724 !important;
                margin: 0 !important;
                line-height: 1.2 !important;
                transition: color 0.3s ease !important;
            }

            .counter-box:hover .counter-number {
                color: var(--primary-color) !important;
            }

            /* Label Text */
            .counter-label {
                font-family: 'Outfit', sans-serif !important;
                font-size: 12px !important;
                font-weight: 600 !important;
                color: var(--primary-color) !important;
                text-transform: uppercase !important;
                letter-spacing: 1.5px !important;
                margin-top: 10px !important;
                margin-bottom: 0 !important;
            }
        </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('testimonial-carousel');
            const counter = document.getElementById('testimonial-counter');
            const progressBar = document.getElementById('carousel-progress');

            if (!carousel) return;

            // Initialize Bootstrap Carousel
            const carouselElement = new bootstrap.Carousel(carousel, {
                interval: 6000,
                ride: 'carousel',
                wrap: true,
                touch: true,
                keyboard: true
            });

            // ===== PROGRESS BAR MANAGEMENT =====
            let progressInterval = null;
            let isAutoplayActive = true;

            function startProgressBar() {
                if (progressBar) {
                    progressBar.style.width = '0%';
                }

                if (progressInterval) {
                    clearInterval(progressInterval);
                }

                let progress = 0;
                const interval = 6000; // Match carousel interval
                const step = 100 / (interval / 50); // Update every 50ms

                progressInterval = setInterval(() => {
                    if (isAutoplayActive && progress < 100) {
                        progress += step;
                        if (progressBar) {
                            progressBar.style.width = Math.min(progress, 100) + '%';
                        }
                    }
                }, 50);
            }

            // Start progress bar on load
            startProgressBar();

            // Restart progress bar on slide change
            carousel.addEventListener('slide.bs.carousel', function(event) {
                // Update counter
                if (counter) {
                    counter.textContent = event.to + 1;
                }

                // Update indicators
                const indicators = document.querySelectorAll('.carousel-indicator-btn');
                indicators.forEach((btn, index) => {
                    btn.classList.toggle('active', index === event.to);
                });

                // Reset progress bar
                startProgressBar();
            });

            // ===== PAUSE/RESUME ON HOVER =====
            carousel.addEventListener('mouseenter', () => {
                isAutoplayActive = false;
                carouselElement.pause();
                if (progressInterval) {
                    clearInterval(progressInterval);
                }
                if (progressBar) {
                    progressBar.style.opacity = '0.5';
                }
            });

            carousel.addEventListener('mouseleave', () => {
                isAutoplayActive = true;
                carouselElement.cycle();
                startProgressBar();
                if (progressBar) {
                    progressBar.style.opacity = '1';
                }
            });

            // ===== INDICATOR CLICK HANDLING =====
            const indicators = document.querySelectorAll('.carousel-indicator-btn');
            indicators.forEach((btn) => {
                btn.addEventListener('click', function(e) {
                    const slideIndex = parseInt(this.getAttribute('data-bs-slide-to'));
                    carouselElement.to(slideIndex);
                });
            });

            // ===== KEYBOARD NAVIGATION =====
            document.addEventListener('keydown', function(event) {
                if (event.key === 'ArrowLeft') carouselElement.prev();
                if (event.key === 'ArrowRight') carouselElement.next();
            });

            // ===== TOUCH/SWIPE SUPPORT =====
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 50) {
                    carouselElement.next(); // Swiped left
                } else if (touchEndX - touchStartX > 50) {
                    carouselElement.prev(); // Swiped right
                }
            });
        });
    </script>

    {{-- ==================== END CLIENT TESTIMONIALS SECTION ==================== --}}

    {{-- @if ($setting->is_popular_brand == 1)
    <section class="brand-section mt-30 mb-60">
        <div class="container ">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="section-title">
                        <h2 class="h3">{{ __('Popular Brands') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-slider owl-carousel">
                        @foreach ($brands as $brand)
                        <div class="slider-item">
                            <a class="text-center" href="{{ route('front.catalog') . '?brand=' . $brand->slug }}">
                                <img class="d-block hi-50 lazy" src="{{ url('assets/img/' . $brand->photo) }}"
                                    alt="{{ $brand->name }}" title="{{ $brand->name }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif --}}






    {{-- Interactive Animated Counters Section --}}
    <section class="animated-counters-section mt-50 mb-50 container">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="counter-box">
                        <div class="counter-icon-wrap">
                            <i class="icon-check"></i>
                        </div>
                        <h2 class="animate-counter counter-number" data-target="1500">0</h2>
                        <p class="counter-label">Beds Sold</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="counter-box">
                        <div class="counter-icon-wrap">
                            <i class="icon-users"></i>
                        </div>
                        <h2 class="animate-counter counter-number" data-target="1200">0</h2>
                        <p class="counter-label">Happy Customers</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4 mx-auto">
                    <div class="counter-box">
                        <div class="counter-icon-wrap">
                            <i class="icon-star"></i>
                        </div>
                        <h2 class="animate-counter counter-number" data-target="99">0</h2>
                        <p class="counter-label">Positive Reviews (%)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.animate-counter');
            const speed = 150;

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target + "+";
                    }
                };

                let observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCount();
                            obs.disconnect();
                        }
                    });
                }, { threshold: 0.5 });

                observer.observe(counter);
            });

            const boxes = document.querySelectorAll('.counter-box');
            boxes.forEach(box => {
                box.addEventListener('mouseenter', () => box.style.transform = 'translateY(-10px)');
                box.addEventListener('mouseleave', () => box.style.transform = 'translateY(0)');
            });
        });
    </script>

@endsection