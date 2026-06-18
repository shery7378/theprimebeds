@extends('master.front')

@section('title')
    {{ __('Blog') }}
@endsection

@section('content')
    <style>
        /* =============================================
           PREMIUM SIDEBAR WIDGETS
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

        .sidebar-categories-list li {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
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
            background: transparent !important;
            padding: 0 !important;
            border: none !important;
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
        }

        .sidebar-tags-wrap a.tag-pill:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }
    </style>

    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumbs">
                        <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a> </li>
                        <li class="separator"></li>
                        <li>{{ __('Blog') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container blog-page">
        <div class="row ">
            <!-- Content-->
            <div class="col-xl-9 col-lg-8 order-lg-2">
                <div class="row">
                    @forelse ($posts as $post)
                        <div class="col-md-6">
                            <a href="{{ route('front.blog.details', $post->slug) }}" class="blog-post">
                                <div class="post-thumb">
                                    <img class="lazy"
                                        src="{{ url('assets/img/' . json_decode($post->photo, true)[array_key_first(json_decode($post->photo, true))]) }}"
                                        alt="Blog Post">
                                </div>
                                <div class="post-body">

                                    <h3 class="post-title"> {{ Str::limit($post->title, 55) }}
                                    </h3>
                                    <ul class="post-meta">

                                        <li><i class="icon-user"></i>{{ __('Admin') }}</li>
                                        <li><i class="icon-clock"></i>{{ date('jS F, Y', strtotime($post->created_at)) }}
                                        </li>
                                    </ul>
                                    <p>{{ Str::limit(strip_tags($post->details), 120) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    {{ __('No Data Found') }}
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
            <!-- Sidebar          -->
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
                            @foreach ($recent_posts as $recent)
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
