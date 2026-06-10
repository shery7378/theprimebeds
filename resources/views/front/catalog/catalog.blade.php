<style>
    /* =============================================
       PRODUCT GRID & CARDS
    ============================================= */

    #main_div {
        row-gap: 24px;
    }

    /* ── Grid Card ── */
    .pc {
        background: #ffffff;
        border: 1px solid #edf0f7;
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
        position: relative;
    }
    .pc:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(26, 35, 80, 0.12);
        border-color: #d6e0ff;
    }

    /* ── Thumbnail ── */
    .pc__thumb {
        position: relative;
        overflow: hidden;
        background: #f7f9fc;
        aspect-ratio: 4 / 3;
    }
    .pc__thumb-link{
        display:block;
        text-decoration:none;
        color:inherit;
    }
    .pc__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.55s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .pc:hover .pc__thumb img {
        transform: scale(1.07);
    }

    /* ── Badges ── */
    .pc__badges {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 3;
    }
    .pc__badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 11px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        color: #fff;
        line-height: 1;
        white-space: nowrap;
    }
    .pc__badge.badge-feature  { background: linear-gradient(135deg, #f6ad55, #ed8936); }
    .pc__badge.badge-new      { background: linear-gradient(135deg, #fc5c7d, #e53e3e); }
    .pc__badge.badge-top      { background: linear-gradient(135deg, #4facfe, #00b4db); }
    .pc__badge.badge-best     { background: linear-gradient(135deg, #434343, #1a1a1a); }
    .pc__badge.badge-flash    { background: linear-gradient(135deg, #43e97b, #38a169); }
    .pc__badge.badge-stock    { background: rgba(113,128,150,0.88); }
    .pc__badge.badge-discount { background: linear-gradient(135deg, #667eea, #764ba2); }

    /* ── Action Buttons (hover overlay) ── */
    .pc__actions {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        flex-direction: column;
        gap: 7px;
        z-index: 4;
        opacity: 0;
        visibility: hidden;
        transform: translateX(10px);
        transition: opacity 0.25s ease, visibility 0.25s ease, transform 0.25s ease;
    }
    .pc:hover .pc__actions {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }
    .pc__action-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #e8ecf5;
        box-shadow: 0 4px 12px rgba(0,0,0,0.10);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4a5568;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 15px;
    }
    .pc__action-btn:hover {
        background: #1a2332;
        color: #fff;
        border-color: #1a2332;
        transform: scale(1.08);
        box-shadow: 0 6px 18px rgba(26,35,50,0.25);
    }

    /* ── Body ── */
    .pc__body {
        padding: 16px 16px 18px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .pc__title {
        font-size: 15px;
        font-weight: 600;
        color: #1a202c;
        line-height: 1.45;
        margin: 0 0 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .pc__title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .pc__title a:hover { color: #3b56d9; }

    /* ── Price Row ── */
    .pc__price-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 8px;
        margin-top: auto;
    }
    .pc__prices {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .pc__price-old {
        font-size: 12px;
        font-weight: 400;
        color: #a0aec0;
        text-decoration: line-through;
        line-height: 1;
    }
    .pc__price-current {
        font-size: 20px;
        font-weight: 800;
        color: #1a202c;
        line-height: 1.1;
    }

    /* ── CTA Button ── */
    .pc__cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 16px;
        background: linear-gradient(135deg, #1a2332, #2d4270);
        color: #fff;
        border: none;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(26,35,80,0.20);
        flex-shrink: 0;
    }
    .pc__cta:hover {
        background: linear-gradient(135deg, #2d4270, #3d5fa8);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26,35,80,0.28);
        color: #fff;
    }
    .pc__cta:active {
        transform: translateY(0);
    }
    .pc__cta.out-of-stock {
        background: #e2e8f0;
        color: #718096;
        box-shadow: none;
        cursor: default;
        pointer-events: none;
    }

    /* ── Divider ── */
    .pc__divider {
        height: 1px;
        background: #f1f4f8;
        margin: 12px 0;
    }

    /* ── List View ── */
    .pc-list {
        background: #fff;
        border: 1px solid #edf0f7;
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
    }
    .pc-list:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(26,35,80,0.10);
    }
    .pc-list__thumb {
        width: 220px;
        min-width: 220px;
        position: relative;
        overflow: hidden;
        background: #f7f9fc;
    }
    .pc-list__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .pc-list:hover .pc-list__thumb img {
        transform: scale(1.05);
    }
    .pc-list__body {
        padding: 22px 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 10px;
    }
    .pc-list__category {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: #7c9af0;
        text-decoration: none;
    }
    .pc-list__category:hover { color: #3b56d9; }
    .pc-list__title {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.4;
        margin: 0;
    }
    .pc-list__title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .pc-list__title a:hover { color: #3b56d9; }
    .pc-list__desc {
        font-size: 13.5px;
        color: #718096;
        line-height: 1.65;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .pc-list__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pc-list__prices {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .pc-list__price-old {
        font-size: 12px;
        color: #a0aec0;
        text-decoration: line-through;
    }
    .pc-list__price-current {
        font-size: 22px;
        font-weight: 800;
        color: #1a202c;
    }
    .pc-list__actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pc-list__badges {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 3;
    }

    /* ── Empty State ── */
    .catalog-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 24px;
        text-align: center;
        background: #fff;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }
    .catalog-empty-state__icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef3ff, #dde6fa);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .catalog-empty-state__icon i {
        font-size: 36px;
        color: #7c9af0;
    }
    .catalog-empty-state h4 {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin: 0 0 8px;
    }
    .catalog-empty-state p {
        font-size: 14px;
        color: #a0aec0;
        margin: 0 0 24px;
    }
    .catalog-empty-state .btn-browse {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 26px;
        background: linear-gradient(135deg, #1a2332, #2d4270);
        color: #fff;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .catalog-empty-state .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26,35,80,0.25);
        color: #fff;
    }



    @media (max-width: 991px) {
        .pc-list { flex-direction: column; }
        .pc-list__thumb { width: 100%; min-width: 0; height: 220px; }
    }
    @media (max-width: 575px) {
        .pc__price-current { font-size: 17px; }
        .pc__cta { padding: 8px 12px; font-size: 12px; }
    }
</style>

{{-- ===================================================
     PRODUCT GRID
=================================================== --}}
<div class="row g-3" id="main_div">

    @if($items->count() > 0)

        {{-- ── GRID VIEW ── --}}
        @if ($checkType != 'list')
            @foreach ($items as $item)
            <div class="col-xxl-4 col-md-4 col-6">
                <div class="pc">

                    {{-- Thumbnail --}}
                    <a class="pc__thumb-link" href="{{ route('front.product', $item->slug) }}">
                        <div class="pc__thumb">
                            <img class="lazy" data-src="{{ url('assets/img/'.$item->thumbnail) }}" alt="{{ $item->name }}">

                            {{-- Left Badges --}}
                            <div class="pc__badges">
                                @if ($item->is_stock())
                                    @if($item->is_type != 'undefine')
                                    <span class="pc__badge
                                        @if($item->is_type == 'feature')  badge-feature
                                        @elseif($item->is_type == 'new')   badge-new
                                        @elseif($item->is_type == 'top')   badge-top
                                        @elseif($item->is_type == 'best')  badge-best
                                        @elseif($item->is_type == 'flash_deal') badge-flash
                                        @endif">
                                        @if($item->is_type == 'feature') ⭐
                                        @elseif($item->is_type == 'new') 🆕
                                        @elseif($item->is_type == 'top') 👍
                                        @elseif($item->is_type == 'best') 🏆
                                        @elseif($item->is_type == 'flash_deal') ⚡
                                        @endif
                                        {{ __(ucfirst(str_replace('_', ' ', $item->is_type))) }}
                                    </span>
                                    @endif
                                @else
                                    <span class="pc__badge badge-stock">{{ __('Out of Stock') }}</span>
                                @endif

                                @if($item->previous_price && $item->previous_price != 0 && $item->previous_price > $item->discount_price)
                                <span class="pc__badge badge-discount">
                                    -{{ PriceHelper::DiscountPercentage($item) }}
                                </span>
                                @endif
                            </div>

                            {{-- Right Action Buttons --}}
                            <div class="pc__actions">
                                <a class="pc__action-btn wishlist_store"
                                   href="{{ route('user.wishlist.store', $item->id) }}"
                                   title="{{ __('Add to Wishlist') }}"
                                   onclick="event.stopPropagation();">
                                    <i class="icon-heart"></i>
                                </a>
                                @if ($item->item_type != 'affiliate')
                                    @if ($item->is_stock())
                                    <a class="pc__action-btn add_to_single_cart"
                                       data-target="{{ $item->id }}"
                                       href="javascript:;"
                                       title="{{ __('Quick Add to Cart') }}"
                                       onclick="event.stopPropagation();">
                                        <i class="icon-shopping-cart"></i>
                                    </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="pc__body">
                        <h3 class="pc__title">
                            <a href="{{ route('front.product', $item->slug) }}">
                                {{ Str::limit($item->name, 52) }}
                            </a>
                        </h3>

                        <div class="pc__divider"></div>

                        <div class="pc__price-row">
                            <div class="pc__prices">
                                @if ($item->previous_price != 0)
                                <span class="pc__price-old">{{ PriceHelper::setPreviousPrice($item->previous_price) }}</span>
                                @endif
                                <span class="pc__price-current">{{ PriceHelper::grandCurrencyPrice($item) }}</span>
                            </div>

                            @if ($item->item_type != 'affiliate')
                                @if ($item->is_stock())
                                <a class="pc__cta add_to_single_cart" data-target="{{ $item->id }}" href="javascript:;" title="{{ __('Add to Cart') }}">
                                    <i class="icon-shopping-cart"></i>
                                    <span class="d-none d-xl-inline">{{ __('Add') }}</span>
                                </a>
                                @else
                                <a class="pc__cta out-of-stock" href="{{ route('front.product', $item->slug) }}">
                                    {{ __('View') }}
                                </a>
                                @endif
                            @else
                            <a class="pc__cta" href="{{ $item->affiliate_link }}" target="_blank">
                                {{ __('Buy Now') }}
                            </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

        {{-- ── LIST VIEW ── --}}
        @else
            @foreach ($items as $item)
            <div class="col-12">
                <div class="pc-list">

                    {{-- Thumbnail --}}
                    <a class="pc__thumb-link" href="{{ route('front.product', $item->slug) }}">
                        <div class="pc-list__thumb">
                            <img class="lazy" data-src="{{ url('assets/img/'.$item->thumbnail) }}" alt="{{ $item->name }}">
                            <div class="pc-list__badges">
                                @if ($item->is_stock())
                                    @if($item->is_type != 'undefine')
                                    <span class="pc__badge
                                        @if($item->is_type == 'feature')  badge-feature
                                        @elseif($item->is_type == 'new')   badge-new
                                        @elseif($item->is_type == 'top')   badge-top
                                        @elseif($item->is_type == 'best')  badge-best
                                        @elseif($item->is_type == 'flash_deal') badge-flash
                                        @endif">
                                        {{ __(ucfirst(str_replace('_', ' ', $item->is_type))) }}
                                    </span>
                                    @endif
                                @else
                                    <span class="pc__badge badge-stock">{{ __('Out of Stock') }}</span>
                                @endif
                                @if($item->previous_price && $item->previous_price != 0 && $item->previous_price > $item->discount_price)
                                <span class="pc__badge badge-discount">-{{ PriceHelper::DiscountPercentage($item) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="pc-list__body">
                        <a class="pc-list__category" href="{{ route('front.catalog').'?category='.$item->category->slug }}">
                            {{ $item->category->name }}
                        </a>
                        <h3 class="pc-list__title">
                            <a href="{{ route('front.product', $item->slug) }}">{{ Str::limit($item->name, 72) }}</a>
                        </h3>
                        @if($item->sort_details)
                        <p class="pc-list__desc">{{ Str::limit(strip_tags($item->sort_details), 160) }}</p>
                        @endif

                        <div class="pc-list__footer">
                            <div class="pc-list__prices">
                                @if ($item->previous_price != 0)
                                <span class="pc-list__price-old">{{ PriceHelper::setPreviousPrice($item->previous_price) }}</span>
                                @endif
                                <span class="pc-list__price-current">{{ PriceHelper::grandCurrencyPrice($item) }}</span>
                            </div>
                            <div class="pc-list__actions">
                                <a class="pc__action-btn wishlist_store"
                                   href="{{ route('user.wishlist.store', $item->id) }}"
                                   title="{{ __('Wishlist') }}"
                                   onclick="event.stopPropagation();">
                                    <i class="icon-heart"></i>
                                </a>
                                @if ($item->item_type != 'affiliate')
                                    @if ($item->is_stock())
                                    <a class="pc__cta add_to_single_cart" data-target="{{ $item->id }}" href="javascript:;" onclick="event.stopPropagation();">
                                        <i class="icon-shopping-cart"></i> {{ __('Add to Cart') }}
                                    </a>
                                    @else
                                    <a class="pc__cta out-of-stock" href="{{ route('front.product', $item->slug) }}">
                                        {{ __('View Details') }}
                                    </a>
                                    @endif
                                @else
                                <a class="pc__cta" href="{{ $item->affiliate_link }}" target="_blank">
                                    {{ __('Buy Now') }}
                                </a>
                                @endif
                                <a class="pc__action-btn" href="{{ route('front.product', $item->slug) }}" title="{{ __('View Details') }}">
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        @endif

    @else
        {{-- Empty State --}}
        <div class="col-12">
            <div class="catalog-empty-state">
                <div class="catalog-empty-state__icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4>{{ __('No Products Found') }}</h4>
                <p>{{ __('We couldn\'t find any products matching your criteria. Try adjusting your filters.') }}</p>
                <a href="{{ route('front.catalog') }}" class="btn-browse">
                    <i class="fas fa-th-large"></i> {{ __('Browse All Products') }}
                </a>
            </div>
        </div>
    @endif

</div>



<script type="text/javascript" src="{{ asset('assets/front/js/catalog.js') }}"></script>
