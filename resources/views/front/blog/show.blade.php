@extends('master.front')
@section('title')
    {{ __('Blog Details') }}
@endsection
@php
    if ($post->meta_keywords) {
        $keyword = str_replace(['value', '{', '}', '[', ']', ':', "\""], '', $post->meta_keywords);
    } else {
        $keyword = $post->title;
    }
@endphp
@section('meta')
    <meta name="title" content="{{ $post->title }}">
    <meta name="keywords" content="{{ $keyword }}">
    <meta name="description" content="{{ $post->meta_descriptions }}">

    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:image" content="{{ url('assets/img/' . json_decode($post->photo, true)[0]) }}">
    <meta name="twitter:description" content="{{ $post->meta_descriptions }}">

    <meta name="og:title" content="{{ $post->title }}">
    <meta name="og:image" content="{{ url('assets/img/' . json_decode($post->photo, true)[0]) }}">
    <meta name="og:description" content="{{ $post->meta_descriptions }}">

@endsection


@section('content')
    <style>
        /* =============================================
           PREMIUM BLOG DETAILS PAGE REDESIGN
           ============================================= */

        /* Main details box */
        .blog-details-box {
            background: #ffffff !important;
            border: 1px solid #ebe5db !important;
            border-radius: 24px !important;
            box-shadow: 0 10px 40px rgba(140, 117, 88, 0.03) !important;
            overflow: hidden !important;
            padding: 0 !important;
            margin-bottom: 30px !important;
        }

        /* Image/Slider wrapper */
        .blog-details-slider {
            border-bottom: 1px solid #ebe5db !important;
            overflow: hidden !important;
        }

        .blog-details-slider img {
            width: 100% !important;
            height: auto !important;
            display: block !important;
        }

        /* Main content container */
        .blog-details-main-content {
            padding: 40px 35px !important;
        }

        @media (max-width: 576px) {
            .blog-details-main-content {
                padding: 24px 20px !important;
            }
        }

        /* Post Title */
        .b-d-title {
            font-family: 'Playfair Display', Georgia, serif !important;
            font-size: 32px !important;
            font-weight: 700 !important;
            color: #2c2724 !important;
            line-height: 1.35 !important;
            margin-top: 0 !important;
            margin-bottom: 16px !important;
            letter-spacing: -0.5px !important;
        }

        @media (max-width: 768px) {
            .b-d-title {
                font-size: 24px !important;
            }
        }

        /* Meta details */
        .post-meta-custom {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 20px !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 0 30px 0 !important;
            border-bottom: 1px solid #f2ede4 !important;
            padding-bottom: 20px !important;
        }

        .post-meta-custom li {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 14px !important;
            color: #8a7a6b !important;
            font-weight: 500 !important;
        }

        .post-meta-custom li a {
            color: inherit !important;
            text-decoration: none !important;
            transition: color 0.25s ease !important;
        }

        .post-meta-custom li a:hover {
            color: var(--primary-color) !important;
        }

        .post-meta-custom li i {
            color: var(--primary-color) !important;
            font-size: 15px !important;
        }

        /* Blog description text */
        .blog-details-text-content {
            font-family: 'Outfit', sans-serif !important;
            font-size: 16px !important;
            color: #3f3a36 !important;
            line-height: 1.85 !important;
        }

        .blog-details-text-content p {
            margin-bottom: 24px !important;
        }

        /* Tags list */
        .blog-details-tags-wrap {
            font-family: 'Outfit', sans-serif !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #2c2724 !important;
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        .blog-details-tags-wrap a.tag-pill {
            display: inline-block !important;
            padding: 5px 14px !important;
            background: #faf8f5 !important;
            border: 1px solid #eaddcf !important;
            color: #796e65 !important;
            border-radius: 50px !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
        }

        .blog-details-tags-wrap a.tag-pill:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        /* Social Share styling */
        .share-label {
            font-family: 'Outfit', sans-serif !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #2c2724 !important;
            margin-right: 12px !important;
        }

        .share-buttons-wrap {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .share-buttons-wrap a {
            width: 36px !important;
            height: 36px !important;
            border-radius: 50% !important;
            background: #faf8f5 !important;
            border: 1px solid #eaddcf !important;
            color: #796e65 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.25s ease !important;
            font-size: 14px !important;
            text-decoration: none !important;
        }

        .share-buttons-wrap a:hover {
            color: #ffffff !important;
            transform: translateY(-2px) !important;
        }

        .share-buttons-wrap a.facebook:hover { background: #3b5998 !important; border-color: #3b5998 !important; }
        .share-buttons-wrap a.twitter:hover { background: #1da1f2 !important; border-color: #1da1f2 !important; }
        .share-buttons-wrap a.linkedin:hover { background: #0077b5 !important; border-color: #0077b5 !important; }
        .share-buttons-wrap a.pinterest:hover { background: #bd081c !important; border-color: #bd081c !important; }

        /* =============================================
           SIDEBAR WIDGETS
           ============================================= */
        
        .sidebar-widget-card {
            background: #ffffff !important;
            border: 1px solid #ebe5db !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 30px rgba(140, 117, 88, 0.02) !important;
            padding: 24px !important;
            margin-bottom: 28px !important;
            overflow: hidden !important;
        }

        .sidebar-widget-title {
            font-family: 'Playfair Display', Georgia, serif !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #2c2724 !important;
            margin-top: 0 !important;
            margin-bottom: 20px !important;
            padding-bottom: 12px !important;
            border-bottom: 2px solid var(--primary-color) !important;
            position: relative !important;
        }

        /* Search input redesign */
        .sidebar-search-form {
            position: relative !important;
            border: 2px solid #ebdcd0 !important;
            border-radius: 50px !important;
            background: #faf8f5 !important;
            transition: border-color 0.3s ease, background 0.3s ease;
            overflow: hidden !important;
        }

        .sidebar-search-form:focus-within {
            border-color: var(--primary-color) !important;
            background: #ffffff !important;
        }

        .sidebar-search-input {
            width: 100% !important;
            height: 44px !important;
            border: none !important;
            background: transparent !important;
            padding: 0 50px 0 20px !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 14px !important;
            color: #3c4858 !important;
            outline: none !important;
        }

        .sidebar-search-btn {
            position: absolute !important;
            right: 0 !important;
            top: 0 !important;
            height: 100% !important;
            width: 46px !important;
            border: none !important;
            background: transparent !important;
            color: var(--primary-color) !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 16px !important;
            transition: color 0.2s ease !important;
        }

        .sidebar-search-btn:hover {
            color: #2c2c2c !important;
        }

        /* Categories List */
        .sidebar-categories-list {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        .sidebar-categories-list li a {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            font-family: 'Outfit', sans-serif !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #5a5045 !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
            padding: 2px 0 !important;
        }

        .sidebar-categories-list li a:hover {
            color: var(--primary-color) !important;
            padding-left: 6px !important;
        }

        .sidebar-categories-list li a span.count {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 28px !important;
            height: 24px !important;
            background: #faf8f5 !important;
            border: 1px solid #ebdcd0 !important;
            border-radius: 50px !important;
            font-size: 12px !important;
            color: #a3917c !important;
            transition: all 0.25s ease !important;
            font-weight: 600 !important;
        }

        .sidebar-categories-list li a:hover span.count {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        /* Recent Posts */
        .sidebar-recent-posts {
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
        }

        .sidebar-recent-post-item {
            display: flex !important;
            gap: 14px !important;
            align-items: center !important;
        }

        .sidebar-recent-post-thumb {
            width: 65px !important;
            height: 55px !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #faf8f5 !important;
            border: 1px solid #ebdcd0 !important;
            flex-shrink: 0 !important;
        }

        .sidebar-recent-post-thumb img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        .sidebar-recent-post-content {
            display: flex !important;
            flex-direction: column !important;
            flex-grow: 1 !important;
        }

        .sidebar-recent-post-title {
            font-family: 'Outfit', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #2c2724 !important;
            line-height: 1.35 !important;
            margin: 0 0 4px 0 !important;
            text-decoration: none !important;
            transition: color 0.25s ease !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .sidebar-recent-post-title:hover {
            color: var(--primary-color) !important;
        }

        .sidebar-recent-post-meta {
            font-family: 'Outfit', sans-serif !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #a3917c !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* Tags Widget */
        .sidebar-tags-wrap {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        .sidebar-tags-wrap a.tag-pill {
            display: inline-block !important;
            padding: 6px 14px !important;
            background: #faf8f5 !important;
            border: 1px solid #ebdcd0 !important;
            color: #796e65 !important;
            border-radius: 50px !important;
            font-family: 'Outfit', sans-serif !important;
            font-weight: 500 !important;
            font-size: 12px !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
        }

        .sidebar-tags-wrap a.tag-pill:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }

        /* Disqus custom card spacing */
        .disqus-card {
            background: #ffffff !important;
            border: 1px solid #ebe5db !important;
            border-radius: 24px !important;
            box-shadow: 0 10px 40px rgba(140, 117, 88, 0.03) !important;
            padding: 30px !important;
            margin-top: 30px !important;
        }
        .disqus-card:empty {
            display: none !important;
        }
    </style>

    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumbs">
                        <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                        <li class="separator"></li>
                        <li><a href="{{ route('front.blog') }}">{{ __('Blog') }}</a></li>
                        <li class="separator"></li>
                        <li>{{ $post->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Page Content-->
    <div class="container padding-bottom-3x">
        <div class="row">
            <!-- Content-->
            <div class="col-xl-9 col-lg-8 order-lg-2">
                <div class="blog-details-box">
                    <!-- Gallery-->
                    <div class="blog-details-slider owl-carousel">
                        @foreach (json_decode($post->photo, true) as $photo)
                            <img src="{{ url('assets/img/' . $photo) }}" alt="{{ $post->title }}">
                        @endforeach
                    </div>
                    <div class="blog-details-main-content">
                        <h1 class="b-d-title">{{ $post->title }}</h1>
                        <ul class="post-meta-custom">
                            <li><i class="icon-user"></i> <a href="javascript:;">{{ __('Admin') }}</a></li>
                            <li><i class="icon-tag"></i> <a href="{{ route('front.blog') . '?category=' . $post->category->slug }}">{{ $post->category->name }}</a></li>
                            <li><i class="icon-clock"></i> <a href="javascript:;">{{ date('jS F, Y', strtotime($post->created_at)) }}</a></li>
                        </ul>
                        <div class="blog-details-text-content">
                            {!! $post->details !!}
                        </div>

                        <!-- Post Tags + Share-->
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-4 mt-4 border-top" style="border-color: #f2ede4 !important;">
                            @if ($post->tags)
                                <div class="blog-details-tags-wrap pb-2">
                                    <span>{{ __('Tags :') }}</span>
                                    @foreach (explode(',', $post->tags) as $tag)
                                        <a class="tag-pill" href="{{ route('front.blog') . '?tag=' . $tag }}">{{ $tag }}</a>
                                    @endforeach
                                </div>
                            @endif
                            <div class="d-flex align-items-center pb-2">
                                <span class="share-label">{{ __('Share') }}: </span>
                                <div class="share-buttons-wrap a2a_kit">
                                    <a class="facebook a2a_button_facebook" href="javascript:;">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="twitter a2a_button_twitter" href="javascript:;">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="linkedin a2a_button_linkedin" href="javascript:;">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a class="pinterest a2a_button_pinterest" href="javascript:;">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($setting->is_disqus == 1)
                    <div id="disqus_thread" class="disqus-card"></div>
                    <script>
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document,
                                s = d.createElement('script');
                            s.src = '{{ $setting->disqus }}';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4 order-lg-1">
                <div class="sidebar-toggle position-left"><i class="icon-filter"></i></div>
                <aside class="sidebar sidebar-offcanvas position-left">
                    <span class="sidebar-close"><i class="icon-x"></i></span>
                    
                    <!-- Widget Search-->
                    <div class="sidebar-widget-card" style="padding: 10px !important; background: transparent !important; border: none !important; box-shadow: none !important;">
                        <form action="{{ route('front.blog') }}" class="sidebar-search-form" method="get">
                            <input class="sidebar-search-input" name="search" type="text" placeholder="{{ __('Search blog...') }}">
                            <button class="sidebar-search-btn" type="submit"><i class="icon-search"></i></button>
                        </form>
                    </div>
                    
                    <!-- Widget Categories-->
                    <div class="sidebar-widget-card">
                        <h3 class="sidebar-widget-title">{{ __('Blog Categories') }}</h3>
                        <ul class="sidebar-categories-list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('front.blog') . '?category=' . $category->slug }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="count">{{ $category->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Widget Featured Posts-->
                    <div class="sidebar-widget-card">
                        <h3 class="sidebar-widget-title">{{ __('Recent Posts') }}</h3>
                        <div class="sidebar-recent-posts">
                            @foreach ($posts as $recent)
                                <div class="sidebar-recent-post-item">
                                    <div class="sidebar-recent-post-thumb">
                                        <a href="{{ route('front.blog.details', $recent->slug) }}">
                                            <img src="{{ url('assets/img/' . json_decode($recent->photo, true)[array_key_first(json_decode($recent->photo, true))]) }}" alt="{{ $recent->title }}">
                                        </a>
                                    </div>
                                    <div class="sidebar-recent-post-content">
                                        <a class="sidebar-recent-post-title" href="{{ route('front.blog.details', $recent->slug) }}">
                                            {{ Str::limit($recent->title, 45) }}
                                        </a>
                                        <span class="sidebar-recent-post-meta">{{ date('M d, Y', strtotime($recent->created_at)) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Widget Tags-->
                    <div class="sidebar-widget-card">
                        <h3 class="sidebar-widget-title">{{ __('Popular Tags') }}</h3>
                        <div class="sidebar-tags-wrap">
                            @foreach ($tags as $tag)
                                <a class="tag-pill" href="{{ route('front.blog') . '?tag=' . $tag }}">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection
