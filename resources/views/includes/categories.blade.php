<!--@php
$categories = App\Models\Category::with('subcategory.childcategory')
    ->whereStatus(1)
    ->whereHas('subcategory')
    ->orderBy('serial', 'asc')
    ->take(8)
    ->get();
@endphp

<div class="left-category-area custom-category-area">
    <div class="category-header custom-category-header">
        <h4><i class="icon-align-justify"></i> {{ __('Categories') }}</h4>
    </div>

    <div class="category-list custom-category-list">
        @foreach ($categories as $key => $pcategory)
            <div class="c-item custom-c-item">
                <a class="d-block navi-link custom-navi-link"
                   href="{{ route('front.catalog') . '?category=' . $pcategory->slug }}">

                    <img class="lazy" data-src="{{ url('assets/img/' . $pcategory->photo) }}">
                    <span class="text-gray-dark">{{ $pcategory->name }}</span>

                    @if ($pcategory->subcategory->count() > 0)
                        <i class="icon-chevron-right ms-auto"></i>
                    @endif
                </a>

                @if ($pcategory->subcategory->count() > 0)
                    <div class="sub-c-box custom-sub-c-box">
                        @foreach ($pcategory->subcategory as $scategory)
                            <div class="child-c-box custom-child-c-box">
                                <a class="title"
                                   href="{{ route('front.catalog') . '?subcategory=' . $scategory->slug }}">
                                    {{ $scategory->name }}

                                    @if ($scategory->childcategory->count() > 0)
                                        <i class="icon-chevron-right fs-xs ms-1"></i>
                                    @endif
                                </a>

                                @if ($scategory->childcategory->count() > 0)
                                    <div class="child-category custom-child-category">
                                        @foreach ($scategory->childcategory as $childcategory)
                                            <a href="{{ route('front.catalog') . '?childcategory=' . $childcategory->slug }}">
                                                {{ $childcategory->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        <a href="{{ route('front.catalog') }}" class="d-block navi-link custom-view-all">
            <span class="text-primary fw-bold">{{ __('All Categories') }} <i class="icon-chevron-right fs-sm ms-1"></i></span>
        </a>
    </div>
</div>

{{-- ================= CSS ================= --}}
<style>
/* Base Area */
.custom-category-area {
    position: relative;
    border-radius: 8px;
    z-index: 1000;
}

/* Header UI */
.custom-category-header {
    background-color: #0b1c3c !important; /* Premium dark blue matching the image */
    color: #ffffff;
    padding: 5px 17px; /* Further decreased padding to reduce height */
    border-radius: 6px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(11, 28, 60, 0.15);
    transition: background-color 0.3s ease;
}
.custom-category-header:hover {
    background-color: #08152e !important;
}
.custom-category-header h4 {
    margin: 0;
    color: #ffffff !important;
    font-size: 14px; /* Slightly smaller text */
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: 0.5px;
}
.custom-category-header h4 i {
    font-size: 20px;
}

/* Category Dropdown List */
.custom-category-list {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-top: none;
    border-radius: 0 0 6px 6px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    opacity: 0;
    visibility: hidden;
    transform: translateY(12px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 1000;
    display: block !important; /* Override potential theme hidden state */
}

/* Show Dropdown on Hover of Main Wrapper.
   If homepage automatically shows list, we still want hover state animation.
   Usually e-commerces show it on hover. */
.custom-category-area:hover .custom-category-list {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Items */
.custom-c-item {
    border-bottom: 1px solid #f1f5f9;
}
.custom-c-item:last-child {
    border-bottom: none;
}
.custom-navi-link {
    display: flex !important;
    align-items: center;
    padding: 7px 16px !important; /* Minimum padding for tight list */
    color: #334155 !important;
    font-size: 13.5px; /* Smaller text */
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
    cursor: pointer;
    background: #ffffff;
}
.custom-navi-link:hover {
    background-color: #f8fafc;
    color: #2563eb !important;
    padding-left: 20px !important; /* Slide-in effect */
}
.custom-navi-link img {
    width: 18px; /* Further reduced image size */
    height: 18px;
    object-fit: contain;
    margin-right: 12px;
}
.custom-navi-link .icon-chevron-right {
    font-size: 10px;
    color: #94a3b8;
    transition: transform 0.2s ease, color 0.2s ease;
}
.custom-navi-link:hover .icon-chevron-right {
    color: #2563eb;
    transform: translateX(3px);
}

/* Sub-category Box */
.custom-sub-c-box {
    position: absolute;
    top: -1px; /* Align with borders */
    left: 100%;
    width: 260px;
    min-height: calc(100% + 1px);
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-left: none;
    box-shadow: 15px 5px 30px rgba(0, 0, 0, 0.08);
    opacity: 0;
    visibility: hidden;
    transform: translateX(12px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border-radius: 0 6px 6px 6px;
    padding: 16px;
    box-sizing: border-box;
    z-index: 1001;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Show Sub-category on Hover */
.custom-c-item:hover .custom-sub-c-box {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}

/* Sub-category content */
.custom-child-c-box .title {
    display: inline-block;
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    text-decoration: none;
    transition: color 0.2s;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 4px;
    width: 100%;
}
.custom-child-c-box .title:hover {
    color: #2563eb;
    border-color: #2563eb;
}
.custom-child-category {
    display: flex;
    flex-direction: column;
    gap: 0;
}
.custom-child-category a {
    position: relative;
    padding: 4px 0 4px 12px;
    font-size: 12.5px;
    color: #64748b;
    text-decoration: none !important;
    transition: all 0.2s ease;
    font-weight: 500;
}
.custom-child-category a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 4px;
    background-color: #cbd5e1;
    border-radius: 50%;
    transition: background-color 0.2s ease;
}
.custom-child-category a:hover {
    color: #2563eb;
    padding-left: 17px;
}
.custom-child-category a:hover::before {
    background-color: #2563eb;
}

/* View all categories bottom link */
.custom-view-all {
    display: flex !important;
    justify-content: center;
    align-items: center;
    padding: 8px 16px !important;
    background-color: #f8fafc;
    border-radius: 0 0 6px 6px;
    text-align: center;
    transition: all 0.2s ease;
    text-decoration: none !important;
    border-top: 1px solid #f1f5f9;
}
.custom-view-all:hover {
    background-color: #f1f5f9;
}
</style>

{{-- ================= JAVASCRIPT ================= --}}
<script>
// Category menu interactions are now purely driven by modern CSS (hover actions & transitions).
// This provides a much smoother experience, reduces JS execution load, and avoids
// click-conflict bugs. Check CSS above for logic (`.custom-category-area:hover .custom-category-list`, etc.).
</script>-->
