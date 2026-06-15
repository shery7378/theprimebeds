@php
    $data = App\Models\HomeCutomize::select('menu_category')->first()?->menu_category;
    $categoryIds = json_decode($data, true) ?? [];

    $categoriesQuery = App\Models\Category::with('subcategory')
        ->whereStatus(1)
        ->orderBy('serial', 'asc');

    $categories = count($categoryIds) > 0
        ? (clone $categoriesQuery)->whereIn('id', $categoryIds)->get()
        : collect();

    if ($categories->count() === 0) {
        $categories = (clone $categoriesQuery)->get();
    }
@endphp

<style>
    .site-menu ul li a.main-link {
        white-space: nowrap !important;
    }

    /* ===== Redesigned Categories Dropdown ===== */
    .site-menu .t-h-dropdown {
        position: relative;
    }
    
    .site-menu .t-h-dropdown-menu {
        background: #ffffff !important;
        border: 1px solid #EBE5DB !important;
        border-top: 3px solid #8C7558 !important; /* Elegant Gold Top Accent */
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(51, 43, 35, 0.08) !important;
        padding: 14px 8px !important;
        margin-top: 10px !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        transform: translateY(10px) !important;
        display: block !important;
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* Transparent hover bridge to prevent dropdown from closing when cursor crosses the gap */
    .site-menu .t-h-dropdown-menu::before {
        content: '' !important;
        position: absolute !important;
        top: -12px !important;
        left: 0 !important;
        right: 0 !important;
        height: 12px !important;
        background: transparent !important;
        display: block !important;
        z-index: 10 !important;
    }

    /* Hover State with Smooth Transition */
    .site-menu .t-h-dropdown:hover .t-h-dropdown-menu {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    /* Menu Link Items */
    .site-menu .t-h-dropdown-menu a {
        display: flex !important;
        align-items: center !important;
        padding: 10px 16px !important;
        color: #332B23 !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        transition: all 0.25s ease !important;
        border-radius: 8px !important;
        line-height: 1.4 !important;
        margin-bottom: 2px !important;
    }

    /* Hide the default angle bracket from HTML */
    .site-menu .t-h-dropdown-menu a i {
        display: none !important;
    }

    /* Custom visual dot decorator that appears and slides on hover */
    .site-menu .t-h-dropdown-menu a::before {
        content: '';
        width: 6px;
        height: 6px;
        background-color: #8C7558;
        border-radius: 50%;
        margin-right: 0;
        opacity: 0;
        transform: scale(0);
        transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Active & Hover States */
    .site-menu .t-h-dropdown-menu a:hover {
        background-color: #F8F6F0 !important; /* Soft beige hover bg */
        color: #8C7558 !important; /* Gold text */
        padding-left: 20px !important; /* Move text slightly right */
    }

    .site-menu .t-h-dropdown-menu a:hover::before {
        margin-right: 10px;
        opacity: 1;
        transform: scale(1);
    }
</style>
<nav class="site-menu">
    <ul>
        <li>
            <a class="main-link" href="{{ route('front.index') }}">{{ __('Home') }}</a>
        </li>
        @foreach ($categories as $category)
            @php
                $categoryHref = route('front.catalog') . '?category=' . $category->slug;
                $hasSubcategories = $category->subcategory && $category->subcategory->count() > 0;
            @endphp

            @if ($hasSubcategories)
                <li class="t-h-dropdown">
                    <a class="main-link" href="{{ $categoryHref }}">
                        {{ $category->name }} <i class="icon-chevron-down"></i>
                    </a>
                    <div class="t-h-dropdown-menu">
                        @foreach ($category->subcategory as $subcategory)
                            @php
                                $subcategoryHref = route('front.catalog') . '?subcategory=' . $subcategory->slug;
                            @endphp
                            <a href="{{ $subcategoryHref }}" class="text-truncate">
                                <i class="icon-chevron-right pr-2"></i> {{ $subcategory->name }}
                            </a>
                        @endforeach
                    </div>
                </li>
            @else
                <li>
                    <a class="main-link" href="{{ $categoryHref }}">{{ $category->name }}</a>
                </li>
            @endif
        @endforeach

        <li>
            <a class="main-link" href="{{ route('front.catalog') }}">{{ __('Shop') }}</a>
        </li>
        <li>
            <a class="main-link" href="{{ route('front.contact') }}">{{ __('Contact Us') }}</a>
        </li>
        <li>
            <a class="main-link" href="{{ route('front.page', 'about-us') }}">{{ __('About Us') }}</a>
        </li>
        <li>
            <a class="main-link" href="{{ route('front.order.track') }}">{{ __('Track Order') }}</a>
        </li>
    </ul>
</nav>
