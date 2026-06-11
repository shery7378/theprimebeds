<style>
    /* =============================================
       PRODUCT GRID & CARDS (Beige Luxury Theme)
    ============================================= */

    #main_div {
        row-gap: 24px;
    }

    /* ── Grid Card ── */
    .pc {
        background: #F8F6F0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
        position: relative;
    }
    .pc:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
    }

    /* ── Thumbnail ── */
    .pc__thumb {
        position: relative;
        overflow: hidden;
        background: #EBE5DB;
        aspect-ratio: 4 / 3;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
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
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 3;
        align-items: flex-end;
    }
    .pc__badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0px;
        color: #8C7558;
        background: #ffffff;
        line-height: 1;
        white-space: nowrap;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* ── Action Buttons (hover overlay) ── */
    .pc__actions {
        position: absolute;
        top: 15px;
        left: 15px;
        display: flex;
        flex-direction: column;
        gap: 7px;
        z-index: 4;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-10px);
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
        border-radius: 50%;
        background: #ffffff;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.10);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #332B23;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 15px;
    }
    .pc__action-btn:hover {
        background: #332B23;
        color: #fff;
        transform: scale(1.08);
    }

    /* ── Body ── */
    .pc__body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
        background: #F8F6F0;
    }

    /* ── Title and Price Row ── */
    .pc__info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        gap: 15px;
    }

    .pc__title {
        font-size: 16px;
        font-weight: 600;
        color: #332B23;
        line-height: 1.4;
        margin: 0;
        flex: 1;
    }
    .pc__title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .pc__title a:hover { color: #8C7558; }

    .pc__prices {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        text-align: right;
    }
    .pc__price-old {
        font-size: 13px;
        font-weight: 500;
        color: #A3917C;
        text-decoration: line-through;
        line-height: 1.2;
        margin-bottom: 2px;
    }
    .pc__price-current {
        font-size: 20px;
        font-weight: 700;
        color: #332B23;
        line-height: 1.2;
    }

    /* ── CTA Button ── */
    .pc__cta-wrapper {
        margin-top: auto;
    }
    .pc__cta {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px;
        background: #31251A;
        color: #fff;
        border: none;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .pc__cta:hover {
        background: #1F1710;
        color: #fff;
    }
    .pc__cta.out-of-stock {
        background: #A3917C;
    }

    /* ── List View ── */
    .pc-list {
        background: #F8F6F0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
        position: relative;
    }
    .pc-list:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
    }
    .pc-list__thumb {
        position: relative;
        width: 280px;
        flex-shrink: 0;
        background: #EBE5DB;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pc-list__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .pc-list__body {
        padding: 30px;
        display: flex;
        flex-direction: column;
        flex: 1;
        justify-content: center;
    }
    @media (max-width: 991px) {
        .pc-list { flex-direction: column; }
        .pc-list__thumb { width: 100%; min-width: 0; height: 220px; }
    }
    @media (max-width: 575px) {
        .pc__price-current { font-size: 18px; }
        .pc__cta { padding: 12px; font-size: 14px; }
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

                            {{-- Left Action Buttons --}}
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

                            {{-- Right Badges --}}
                            <div class="pc__badges">
                                @if ($item->is_stock())
                                    @if($item->is_type != 'undefine')
                                    <span class="pc__badge">
                                        {{ __(ucfirst(str_replace('_', ' ', $item->is_type))) }}
                                    </span>
                                    @endif
                                @else
                                    <span class="pc__badge badge-stock">{{ __('Out of Stock') }}</span>
                                @endif

                                @if($item->previous_price && $item->previous_price != 0 && $item->previous_price > $item->discount_price)
                                <span class="pc__badge">
                                    -{{ PriceHelper::DiscountPercentage($item) }}% off
                                </span>
                                @endif
                            </div>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="pc__body">
                        <div class="pc__info-row">
                            <h3 class="pc__title">
                                <a href="{{ route('front.product', $item->slug) }}">
                                    {{ Str::limit($item->name, 52) }}
                                </a>
                            </h3>

                            <div class="pc__prices">
                                @if ($item->previous_price != 0)
                                <span class="pc__price-old">{{ PriceHelper::setPreviousPrice($item->previous_price) }}</span>
                                @endif
                                <span class="pc__price-current">{{ PriceHelper::grandCurrencyPrice($item) }}</span>
                            </div>
                        </div>

                        <div class="pc__cta-wrapper">
                            @if ($item->item_type != 'affiliate')
                                @if ($item->is_stock())
                                <a class="pc__cta add_to_single_cart" data-target="{{ $item->id }}" href="javascript:;" title="{{ __('Add to bag') }}">
                                    {{ __('Add to bag') }}
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

                            {{-- Left Action Buttons --}}
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

                            {{-- Right Badges --}}
                            <div class="pc__badges">
                                @if ($item->is_stock())
                                    @if($item->is_type != 'undefine')
                                    <span class="pc__badge">
                                        {{ __(ucfirst(str_replace('_', ' ', $item->is_type))) }}
                                    </span>
                                    @endif
                                @else
                                    <span class="pc__badge badge-stock">{{ __('Out of Stock') }}</span>
                                @endif

                                @if($item->previous_price && $item->previous_price != 0 && $item->previous_price > $item->discount_price)
                                <span class="pc__badge">
                                    -{{ PriceHelper::DiscountPercentage($item) }}% off
                                </span>
                                @endif
                            </div>
                        </div>
                    </a>

                    {{-- Body --}}
                    <div class="pc-list__body">
                        <div class="pc__info-row">
                            <h3 class="pc__title">
                                <a href="{{ route('front.product', $item->slug) }}">
                                    {{ Str::limit($item->name, 52) }}
                                </a>
                            </h3>

                            <div class="pc__prices">
                                @if ($item->previous_price != 0)
                                <span class="pc__price-old">{{ PriceHelper::setPreviousPrice($item->previous_price) }}</span>
                                @endif
                                <span class="pc__price-current">{{ PriceHelper::grandCurrencyPrice($item) }}</span>
                            </div>
                        </div>

                        <div class="pc__cta-wrapper" style="width: 200px;">
                            @if ($item->item_type != 'affiliate')
                                @if ($item->is_stock())
                                <a class="pc__cta add_to_single_cart" data-target="{{ $item->id }}" href="javascript:;" title="{{ __('Add to bag') }}">
                                    {{ __('Add to bag') }}
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
