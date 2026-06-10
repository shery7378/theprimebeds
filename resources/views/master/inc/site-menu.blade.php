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
