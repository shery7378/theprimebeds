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
        color: var(--primary-color);
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
    .pc__title a:hover { color: var(--primary-color); }

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
        background: var(--primary-color) !important;
        color: #fff !important;
        border: none;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .pc__cta:hover {
        background: #2c2c2c !important;
        color: #fff !important;
        box-shadow: 0 6px 15px rgba(44, 44, 44, 0.25);
    }
    .pc__cta.out-of-stock {
        background: #A3917C !important;
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

    /* ── Catalog Empty State Redesign ── */
    .catalog-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 80px 40px;
        background: #ffffff;
        border: 1px solid #e2dcd0;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(44, 41, 36, 0.02);
        max-width: 600px;
        margin: 40px auto;
    }
    .catalog-empty-state__icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #faf8f5;
        border: 1px solid #ebdcd0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 32px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }
    .catalog-empty-state h4 {
        font-size: 22px;
        font-weight: 700;
        color: #2c2924;
        margin-bottom: 12px;
        letter-spacing: -0.2px;
    }
    .catalog-empty-state p {
        font-size: 15px;
        color: #718096;
        max-width: 440px;
        line-height: 1.6;
        margin-bottom: 28px;
    }
    .btn-browse {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--primary-color);
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 12px 28px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(140, 117, 88, 0.35);
    }
    .btn-browse:hover {
        background: #1f314d;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(31, 49, 77, 0.25);
    }
    .btn-browse:active {
        transform: translateY(0);
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
                <div class="product-card">
                    <div class="product-thumb">
                        @if (!$item->is_stock())
                            <div class="product-badge bg-secondary border-default text-body">
                                {{ __('out of stock') }}
                            </div>
                        @endif
                        @php $discPct = PriceHelper::DiscountPercentage($item); @endphp
                        @if($discPct)
                            <div class="product-badge product-badge2 bg-info">-{{ $discPct }}</div>
                        @endif
                        <img class="lazy" src="{{ filter_var($item->thumbnail, FILTER_VALIDATE_URL) ? $item->thumbnail : url('assets/img/' . $item->thumbnail) }}" alt="{{ $item->name }}">
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
                    <div class="product-card-body">
                        <div class="product-category">
                            <a href="{{ route('front.catalog') . '?category=' . $item->category->slug }}">{{ $item->category->name }}</a>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="product-title m-0">
                                <a href="{{ route('front.product', $item->slug) }}">
                                    {{ Str::limit($item->name, 52) }}
                                </a>
                            </h3>
                            <a class="wishlist_store" href="{{ route('user.wishlist.store', $item->id) }}" title="{{ __('Wishlist') }}" style="color: var(--primary-color); font-size: 18px; line-height: 1;"><i class="icon-heart"></i></a>
                        </div>
                        <h4 class="product-price">
                            @if ($item->previous_price != 0)
                                <del>{{ PriceHelper::setPreviousPrice($item->previous_price) }}</del>
                            @endif
                            {{ PriceHelper::grandCurrencyPrice($item) }}
                        </h4>
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
                            <img class="lazy" src="{{ filter_var($item->thumbnail, FILTER_VALIDATE_URL) ? $item->thumbnail : url('assets/img/'.$item->thumbnail) }}" alt="{{ $item->name }}">

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
                                    -{{ PriceHelper::DiscountPercentage($item) }} off
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
                                <a class="pc__cta add_to_single_cart" data-target="{{ $item->id }}" href="javascript:;" title="{{ __('Add to Cart') }}">
                                    {{ __('Add to Cart') }}
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

<div class="row mt-5" id="pagination_container" style="display: none;">
    <div class="col-12 d-flex justify-content-center">
        {{ $items->appends(request()->input())->links() }}
    </div>
</div>

<div class="row mt-4" id="infinite_scroll_loading" style="display: none;">
    <div class="col-12 text-center" style="padding: 40px 0;">
        <i class="fas fa-spinner fa-spin fa-2x" style="color: var(--primary-color);"></i>
        <p class="mt-2" style="color: #718096; font-size: 14px;">{{ __('Loading more products...') }}</p>
    </div>
</div>

<script>
(function() {
    if (window.catalogInfiniteObserver) {
        window.catalogInfiniteObserver.disconnect();
    }
    if (window.onCatalogScroll) {
        window.removeEventListener('scroll', window.onCatalogScroll);
    }

    let loading = false;
    let mainDiv = document.getElementById('main_div');
    let loadingIndicator = document.getElementById('infinite_scroll_loading');
    
    function getNextUrl() {
        let nextLink = document.querySelector('#pagination_container .pagination a[rel="next"]');
        return nextLink ? nextLink.href : null;
    }

    let nextUrl = getNextUrl();

    function loadMore() {
        if (loading || !nextUrl) return;
        loading = true;
        loadingIndicator.style.display = 'block';

        $.ajax({
            url: nextUrl,
            type: 'GET',
            timeout: 10000, // 10 second timeout
            success: function(data) {
                try {
                    let temp = document.createElement('div');
                    temp.innerHTML = data;
                    
                    let newItems = temp.querySelectorAll('#main_div > div');
                    newItems.forEach(item => {
                        mainDiv.appendChild(item);
                    });
                    
                    if (typeof lazy === 'function') {
                        lazy();
                    }
                    
                    let newPagination = temp.querySelector('#pagination_container');
                    if (newPagination) {
                        document.getElementById('pagination_container').innerHTML = newPagination.innerHTML;
                        nextUrl = getNextUrl();
                    } else {
                        nextUrl = null;
                    }
                    
                    if (!nextUrl) {
                        loadingIndicator.style.display = 'none';
                        if (window.catalogInfiniteObserver) window.catalogInfiniteObserver.disconnect();
                        window.removeEventListener('scroll', window.onCatalogScroll);
                    }
                    
                    let showingBadge = document.querySelector('.catalog-count-badge');
                    if (showingBadge) {
                        let count = 0;
                        for (let i = 0; i < mainDiv.children.length; i++) {
                            if (!mainDiv.children[i].classList.contains('catalog-empty-state')) {
                                count++;
                            }
                        }
                        showingBadge.innerHTML = 'Showing ' + count + ' products';
                    }
                } catch(e) {
                    console.error("Infinite scroll processing error: ", e);
                    if (typeof dangerNotification === 'function') {
                        dangerNotification("Error loading products: " + e.message);
                    }
                }

                loading = false;
                checkScroll();
            },
            error: function(xhr, status, error) {
                console.error("Infinite scroll AJAX error: ", status, error);
                loading = false;
                loadingIndicator.style.display = 'none';
                document.getElementById('pagination_container').style.display = 'flex';
                if (typeof dangerNotification === 'function') {
                    dangerNotification("Connection error. Please use the pagination links.");
                }
            }
        });
    }

    function checkScroll() {
        if (!nextUrl || loading || !loadingIndicator) return;
        let rect = loadingIndicator.getBoundingClientRect();
        if (rect.top <= (window.innerHeight || document.documentElement.clientHeight) + 600) {
            loadMore();
        }
    }

    if (nextUrl && loadingIndicator) {
        loadingIndicator.style.display = 'block';
        
        window.catalogInfiniteObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadMore();
                }
            });
        }, {
            rootMargin: '600px'
        });
        
        window.catalogInfiniteObserver.observe(loadingIndicator);
        
        window.onCatalogScroll = function() {
            checkScroll();
        };
        window.addEventListener('scroll', window.onCatalogScroll);
        
        setTimeout(checkScroll, 500);
    }
})();
</script>

<script type="text/javascript" src="{{ asset('assets/front/js/catalog.js') }}"></script>
