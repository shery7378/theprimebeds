@php
    $cart = Session::has('cart') ? Session::get('cart') : [];
    $total = 0;
    $option_price = 0;
    $cartTotal = 0;

@endphp
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="successToast" class="toast align-items-center border-0 text-white " style="background: #001E44  !important"
        role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Preferences updated successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>


<style>
/* Premium Cart Styles */
.shopping-cart .table {
    border: none;
    border-bottom: 1px solid #e8ecf1;
}
.shopping-cart .table th {
    background-color: #f8f9fa;
    border: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    color: #555;
    padding: 1rem;
}
.shopping-cart .table td {
    border: none;
    border-top: 1px solid #e8ecf1;
    vertical-align: middle;
    padding: 1.5rem 1rem;
}
.product-item {
    display: flex;
    align-items: center;
}
.product-item .product-thumb {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    margin-right: 20px;
    flex-shrink: 0;
}
.product-item .product-thumb img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
.product-item .product-info {
    padding-left: 0;
}
.product-item .product-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 5px;
}
.product-item .product-title a {
    color: #333;
    transition: color 0.3s;
}
.product-item .product-title a:hover {
    color: #377dff;
}
.qtySelector.product-quantity {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f5f9;
    border-radius: 30px;
    padding: 5px;
    max-width: 130px;
    margin: 0 auto;
}
.qtySelector.product-quantity span {
    cursor: pointer;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    font-size: 12px;
}
.qtySelector.product-quantity span:hover {
    background: #377dff;
    color: white;
}
.qtySelector.product-quantity input {
    width: 40px;
    text-align: center;
    border: none;
    background: transparent;
    font-weight: bold;
    color: #333;
}
.shopping-cart-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid #e8ecf1;
}
.shopping-cart-footer:last-child {
    border-bottom: none;
}
.remove-from-cart {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #ffeeee;
    color: #dc3545;
    transition: all 0.3s ease;
}
.remove-from-cart:hover {
    background: #dc3545;
    color: #fff;
}

/* Dark mode overrides */
html.dark-mode .shopping-cart .table th {
    background-color: #1e1e1e !important;
    border-bottom: 1px solid #333 !important;
    color: #bbb;
}
html.dark-mode .shopping-cart .table th,
html.dark-mode .shopping-cart .table td {
    border-color: #333 !important;
}
html.dark-mode .product-item .product-thumb {
    background: #2a2a2a;
    box-shadow: 0 4px 15px rgba(0,0,0,0.4);
}
html.dark-mode .product-item .product-title a {
    color: #e0e0e0;
}
html.dark-mode .qtySelector.product-quantity {
    background: #2a2a2a;
}
html.dark-mode .qtySelector.product-quantity span {
    background: #1e1e1e;
    color: #ddd;
}
html.dark-mode .qtySelector.product-quantity span:hover {
    background: #377dff;
    color: #fff;
}
html.dark-mode .qtySelector.product-quantity input {
    color: #fff;
}
html.dark-mode .remove-from-cart {
    background: #3a1c1c;
    color: #ff6b6b;
}
html.dark-mode .remove-from-cart:hover {
    background: #ff6b6b;
    color: #fff;
}
html.dark-mode .shopping-cart-footer {
    border-color: #333;
}
</style>

<div class="card border-0 shadow-sm rounded-lg mb-4">
    <div class="card-body p-0">
        <div class="table-responsive shopping-cart">
            <table class="table mb-0">

                <thead>
                    <tr>
                        <th>{{ __('Product Name') }}</th>
                        <th>{{ __('Product Price') }}</th>
                        <th class="text-center">{{ __('Quantity') }}</th>
                        <th class="text-center">{{ __('Subtotal') }}</th>
                        <th class="text-center"><a class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                href="{{ route('front.cart.clear') }}"><i class="icon-trash"></i> <span>{{ __('Clear Cart') }}</span></a></th>
                    </tr>
                </thead>
                {{-- {{dd(session())}} --}}
                <tbody id="cart_view_load" data-target="{{ route('cart.get.load') }}">

                    @foreach ($cart as $key => $item)
                        @php
                            $main_item = \App\Models\Item::findOrFail(\App\Helpers\PriceHelper::GetItemId($key));
                            if (!empty($item['is_customized'])) {
                                $item_subtotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                            } else {
                                $item_subtotal = \App\Helpers\PriceHelper::cartItemTotalWithBundleDiscount($main_item, $item['attribute_price'], $item['qty']);
                            }
                            $cartTotal += $item_subtotal;
                        @endphp
                        @php
                            $optionDetails = \App\Models\AttributeOption::whereIn('id', $item['options_id'] ?? [])->get();
                            $lastOption = $optionDetails->last();

                            $lastImage = null;

                            if ($lastOption && !empty($lastOption->variation_images)) {
                                $images = json_decode($lastOption->variation_images, true);
                                $lastImage = is_array($images) && count($images) ? $images[0] : null;
                            }
                        @endphp

                        <tr data-key="{{ $key }}">
                            <td>
                                <div class="product-item">
                                    <a class="product-thumb" href="{{ route('front.product', $item['slug']) }}" >
                                        @if(!empty($item['is_customized']))
                                            <img src="{{ url('assets/img/' . $item['photo']) }}" alt="Product">
                                        @elseif($lastImage)
                                            <img src="{{ url('assets/img/' . $lastImage) }}" alt="Product">
                                        @else
                                            <img src="{{ url('assets/img/' . $item['photo']) }}" alt="Product">
                                        @endif
                                    </a>
                                    <div class="product-info">
                                        <h4 class="product-title"><a href="{{ route('front.product', $item['slug']) }}">
                                                {{ Str::limit($item['name'], 45) }}
                                            </a>
                                            @if(!empty($item['is_customized']))
                                                <span style="display:inline-block;background:#e8f4fd;color:#0c63e4;font-size:11px;padding:2px 8px;border-radius:10px;margin-left:4px;font-weight:600;">
                                                    <i class="fas fa-cog" style="font-size:10px;"></i> {{ __('Customized') }}
                                                </span>
                                            @endif
                                        </h4>

                                        @if(!empty($item['is_customized']))
                                            {{-- Show bed customization selections --}}
                                            @foreach ($item['customizations'] ?? [] as $custId => $customization)
                                                <span style="display:block;font-size:12px;color:#555;margin-bottom:2px;">
                                                    <em>{{ $customization['customizer_name'] ?? '' }}:</em>
                                                    <strong>{{ $customization['option_name'] ?? '' }}</strong>
                                                    @if(isset($customization['option_price']) && $customization['option_price'] != 0)
                                                        ({{ $customization['option_price'] > 0 ? '+' : '' }}{{ PriceHelper::setCurrencyPrice($customization['option_price']) }})
                                                    @endif
                                                </span>
                                            @endforeach
                                        @else
                                            @foreach ($item['attribute']['option_name'] as $optionkey => $option_name)
                                                <span><em>{{ $item['attribute']['names'][$optionkey] }}:</em>
                                                    {{ $option_name }}
                                                    ({{ PriceHelper::setCurrencyPrice($item['attribute']['option_price'][$optionkey]) }})
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </td>
                            @php
                                if (!empty($item['is_customized'])) {
                                    $unit_price = $item['price'] ?? 0;
                                    $discounted_unit_price = $unit_price;
                                    $applied_discount = 0;
                                } else {
                                    $unit_price = $item['main_price'] + $item['attribute_price'];
                                    $discounted_unit_price = $unit_price;
                                    $bundle = $main_item->bundle_discount ?? null;
                                    $applied_discount = 0;
                                    if ($bundle && isset($bundle['discount_items'], $bundle['discountItems_price'])) {
                                        foreach ($bundle['discount_items'] as $dkey => $required_qty) {
                                            if ($item['qty'] >= (int)$required_qty) {
                                                $applied_discount = max($applied_discount, (float)$bundle['discountItems_price'][$dkey]);
                                            }
                                        }
                                        if ($applied_discount > 0) {
                                            $discounted_unit_price = $unit_price - ($unit_price * ($applied_discount / 100));
                                        }
                                    }
                                }
                            @endphp
                            <td class="text-center text-lg">
                                @if($applied_discount > 0)
                                    <del>{{ PriceHelper::setCurrencyPrice($unit_price) }}</del><br>
                                    <span class="text-success">{{ PriceHelper::setCurrencyPrice($discounted_unit_price) }}</span>
                                @else
                                    {{ PriceHelper::setCurrencyPrice($unit_price) }}
                                @endif
                            </td>

                            <td class="text-center">
                                @if(!empty($item['is_customized']))
                                    {{-- Customized beds: show quantity but no increment/decrement (add fresh via customize page) --}}
                                    <div class="qtySelector product-quantity">
                                        <span style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#f0f0f0;color:#aaa;cursor:not-allowed;">
                                            <i class="fas fa-minus"></i>
                                        </span>
                                        <input type="text" disabled class="qtyValue cartcart-amount"
                                            value="{{ $item['quantity'] ?? 1 }}">
                                        <span style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#f0f0f0;color:#aaa;cursor:not-allowed;">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    </div>
                                @else
                                    <div class="qtySelector product-quantity">
                                        <span class="decreaseQtycart cartsubclick" data-id="{{ $key }}"
                                            data-target="{{ PriceHelper::GetItemId($key) }}"><i
                                                class="fas fa-minus"></i></span>
                                        <input type="text" disabled class="qtyValue cartcart-amount"
                                            value="{{ $item['qty'] }}">
                                        <span class="increaseQtycart cartaddclick" data-id="{{ $key }}"
                                            data-target="{{ PriceHelper::GetItemId($key) }}"
                                            data-item="{{ implode(',', $item['options_id']) }}"><i
                                                class="fas fa-plus"></i></span>
                                        <input type="hidden" value="3333" id="current_stock">
                                    </div>
                                @endif

                            </td>
                            <td class="text-center text-lg">
                                {{ PriceHelper::setCurrencyPrice($item_subtotal) }}
                            </td>

                            <td class="text-center"><a class="remove-from-cart"
                                    href="{{ route('front.cart.destroy', $key) }}" data-toggle="tooltip"
                                    title="Remove item"><i class="icon-x"></i></a></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="card">
                                    <div class="form-row ml-2">
                                        @if (empty($item['is_customized']) && is_array($main_item->variations) && isset($main_item->variations['customization_level']) && in_array($main_item->variations['customization_level'], ['customizable', 'partial_customizable']))
                                            <div class="card shadow-sm border-0 mb-4 rounded-lg" style="background:#fcfcfc;">
                                                <div class="card-body">
                                                    <h6 class="mb-3">Update Customisation Preferences</h6>

                                                    {{-- Preferences Textarea --}}
                                                    <div class="form-group mb-3">
                                                        <label for="preferences">Describe your preferences</label>
                                                        <textarea name="preferences" id="preferences_{{ $key }}" rows="4" column="6" class="form-control"
                                                            style="height:72px !important; resize:none;"
                                                            placeholder="Add notes about text placement, design ideas, or layout...">{{ $item['preference_description'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                            </td>
                            <td colspan="2">
                                @if (empty($item['is_customized']) && is_array($main_item->variations) && isset($main_item->variations['customization_level']) && in_array($main_item->variations['customization_level'], ['customizable', 'partial_customizable']))
                                    <div class="card">
                                        <div class="card p-3 mb-3 shadow-sm"
                                            style="box-shadow: 0 0.25rem 0.75rem rgba(128, 128, 128, 0.2) !important;">
                                            <div class="form-group ">
                                                <label for="sample_images_{{ $key }}"
                                                    class="form-label fw-semibold mb-2 d-block"
                                                    style="margin-right:60px;">
                                                    Upload Reference or Sample Images
                                                </label>

                                                <div class="d-flex">
                                                    <input type="file" class="sample-images" name="sample_images[]"
                                                        id="sample_images_{{ $key }}" class="w-auto"
                                                        data-key="{{ $key }}" multiple>
                                                </div>

                                                <div id="preview-area_{{ $key }}" class="mt-3"></div>
                                                <!-- Shared progress bar -->
                                                <div id="shared-progress-wrapper_{{ $key }}"
                                                    class="progress mt-3" style="height: 17px; display: none;">
                                                    <div id="shared-progress-bar_{{ $key }}"
                                                        class="progress-bar" style="width: 0%;" role="progressbar"
                                                        aria-valuemin="0" aria-valuemax="100">0%</div>
                                                </div>
                                                <small class=" text-muted d-block mt-2">
                                                    You can upload multiple images (JPEG, PNG, etc.)
                                                </small>
                                                @php
                                                    $sessionImages = !empty($item['sample_image'])
                                                        ? json_decode($item['sample_image'], true)
                                                        : [];
                                                @endphp
                                                <div class="mt-3" id="existing_preview">
                                                    <h3>Existing Uploads</h3>
                                                    <div class="existing-uploads-grid mb-3">
                                                        @foreach ($sessionImages as $img)
                                                            @php
                                                                $ext = pathinfo($img, PATHINFO_EXTENSION);
                                                                $isImage = in_array(strtolower($ext), [
                                                                    'jpg',
                                                                    'jpeg',
                                                                    'png',
                                                                    'gif',
                                                                    'webp',
                                                                ]);
                                                            @endphp

                                                            <div class="position-relative"
                                                                style="width: 120px; height: 120px; margin: 5px;">
                                                                @if ($isImage)
                                                                    <img src="{{ asset('assets/preferences/' . $img) }}"
                                                                        alt="Sample Image" class="img-thumbnail"
                                                                        style="max-width: 100%; max-height: 100%; object-fit: contain; display: block; margin: auto;">
                                                                @else
                                                                    <div class="d-flex flex-column justify-content-center align-items-center border rounded bg-light"
                                                                        style="width: 100%; height: 100%;">
                                                                        @if (strtolower($ext) === 'pdf')
                                                                            <i
                                                                                class="fas fa-file-pdf fa-2x text-danger"></i>
                                                                        @elseif (in_array(strtolower($ext), ['doc', 'docx']))
                                                                            <i
                                                                                class="fas fa-file-word fa-2x text-primary"></i>
                                                                        @else
                                                                            <i
                                                                                class="fas fa-file-alt fa-2x text-secondary"></i>
                                                                        @endif
                                                                        <small class="text-center px-1"
                                                                            style="font-size: 10px; word-break: break-word;">
                                                                            {{ \Illuminate\Support\Str::limit($img, 15) }}
                                                                        </small>
                                                                    </div>
                                                                @endif

                                                                <!-- Remove Button -->
                                                                <button class="remove-session-image position-absolute"
                                                                    style="
                                                                            top: 4px;
                                                                            right: 6px;
                                                                            width: 22px;
                                                                            height: 22px;
                                                                            background-color: rgba(220, 53, 69, 0.95); /* Bootstrap red with slight transparency */
                                                                            color: white;
                                                                            border: none;
                                                                            border-radius: 50%;
                                                                            font-size: 14px;
                                                                            font-weight: bold;
                                                                            line-height: 1;
                                                                            text-align: center;
                                                                            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
                                                                            transition: background-color 0.2s ease;
                                                                            z-index: 10;
                                                                        "
                                                                    title="Remove"
                                                                    data-filename="{{ $img }}"
                                                                    data-order-id="{{ $key }}"
                                                                    onmouseover="this.style.backgroundColor='rgba(200, 35, 51, 1)'"
                                                                    onmouseout="this.style.backgroundColor='rgba(220, 53, 69, 0.95)'">&times;
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary update-changes" data-key="{{ $key }}">
                                            <span>Update Changes</span>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card border-0 shadow-sm rounded-lg mt-4">
    <div class="card-body p-4">
        <div class="shopping-cart-footer d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="column mb-3 mb-md-0">
                <form class="coupon-form" method="post" id="coupon_form"
                    action="{{ route('front.promo.submit') }}">
                    @csrf
                    <div class="d-flex align-items-stretch" style="max-width: 400px; width: 100%;">
                        <input class="form-control" name="code" type="text"
                            placeholder="{{ __('Coupon code') }}" required style="border-radius: 30px 0 0 30px; padding-left:20px; border-right: 0; min-height: 44px; margin-bottom: 0;">
                        <button class="btn btn-primary m-0 px-4" type="submit" style="border-radius: 0 30px 30px 0; white-space: nowrap; min-height: 44px; display: flex; align-items: center; justify-content: center;"><span>{{ __('Apply Coupon') }}</span></button>
                    </div>
                </form>
            </div>

            <div class="text-right column p-3 bg-light rounded-lg ml-md-auto d-flex flex-column align-items-end" style="min-width:250px;">
                <div class="d-flex justify-content-between w-100 mb-2 {{ Session::has('coupon') ? '' : 'd-none' }}">
                    <span class="text-muted">{{ __('Discount') }} ({{ Session::has('coupon') ? Session::get('coupon')['code']['title'] : '' }}):</span>
                    <div>
                        <span class="text-danger font-weight-bold">-{{ PriceHelper::setCurrencyPrice(Session::has('coupon') ? Session::get('coupon')['discount'] : 0) }}</span>
                        <a class="remove-from-cart text-danger ml-2" href="{{ route('front.promo.destroy') }}"
                            data-toggle="tooltip" title="Remove item" style="width:24px; height:24px; font-size:12px;"><i class="icon-x"></i></a>
                    </div>
                </div>

                <div class="d-flex justify-content-between w-100 text-lg font-weight-bold">
                    <span class="text-muted">{{ __('Subtotal') }}:</span>
                    <span class="text-dark grand-total-value">{{ PriceHelper::setCurrencyPrice($cartTotal - (Session::has('coupon') ? Session::get('coupon')['discount'] : 0)) }}</span>
                </div>
            </div>
        </div>

        <div class="shopping-cart-footer d-flex justify-content-between align-items-center pt-3 border-top-0">
            <div class="column">
                <a class="btn btn-outline-primary rounded-pill px-4" href="{{ route('front.catalog') }}">
                    <i class="icon-arrow-left mr-2"></i> {{ __('Back to Shopping') }}
                </a>
            </div>
            <div class="column">
                <a class="btn btn-primary rounded-pill px-5 shadow" href="{{ route('front.checkout.billing') }}">
                    {{ __('Checkout') }} <i class="icon-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.remove-session-image').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default behavior if it's inside a form

                const filename = this.dataset.filename;
                const orderId = this.dataset.orderId;
                const imageBox = this.closest('.position-relative');
                fetch("{{ route('session.remove.image') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ filename: filename, order_id: orderId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        imageBox.remove(); // Remove element from DOM
                    } else {
                        alert(data.message || 'Failed to remove image from session.');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred while removing the image.');
                });
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.update-changes').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const key = this.dataset.key;
                const btn = this;
                const originalHTML = btn.innerHTML;

                // Show loader and disable button
                btn.disabled = true;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Updating...`;

                const sampleImagesInput = document.getElementById('sample_images_' + key);
                const files = sampleImagesInput.files;
                const formData = new FormData();

                for (let i = 0; i < files.length; i++) {
                    formData.append('new_sample_images[]', files[i]);
                }

                const prefEl = document.getElementById('preferences_' + key);
                const preferences = prefEl ? prefEl.value : null;
                const orderId = key;

                formData.append('order_id', orderId);
                formData.append('preference_description', preferences);

                fetch("{{ route('update.preferences') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const existingPreview = document.getElementById('existing_preview');
                            if (existingPreview) {
                                existingPreview.innerHTML = '';
                                const heading = document.createElement('h3');
                                heading.textContent = 'Existing Uploads';
                                existingPreview.appendChild(heading);
                                const imagesContainer = document.createElement('div');
                                imagesContainer.className = 'existing-uploads-grid mb-3';
                                if (data.images && Array.isArray(data.images)) {
                                    data.images.forEach(imgUrl => {
                                        const imgParts = imgUrl.split('/');
                                        const filename = imgParts[imgParts.length - 1];
                                        const ext = filename.split('.').pop().toLowerCase();
                                        const isImage = ['jpg','jpeg','png','gif','webp'].includes(ext);
                                        const wrapper = document.createElement('div');
                                        wrapper.className = 'position-relative';
                                        wrapper.style.width = '120px';
                                        wrapper.style.height = '120px';
                                        wrapper.style.margin = '0';
                                        if (isImage) {
                                            const imageTag = document.createElement('img');
                                            imageTag.src = imgUrl;
                                            imageTag.alt = 'Sample Image';
                                            imageTag.className = 'img-thumbnail';
                                            imageTag.style.maxWidth = '100%';
                                            imageTag.style.maxHeight = '100%';
                                            imageTag.style.objectFit = 'contain';
                                            imageTag.style.display = 'block';
                                            imageTag.style.margin = '0';
                                            wrapper.appendChild(imageTag);
                                        } else {
                                            const docDiv = document.createElement('div');
                                            docDiv.className = 'd-flex flex-column justify-content-center align-items-center border rounded bg-light';
                                            docDiv.style.width = '100%';
                                            docDiv.style.height = '100%';
                                            const icon = document.createElement('i');
                                            if (ext === 'pdf') {
                                                icon.className = 'fas fa-file-pdf fa-2x text-danger';
                                            } else if (['doc','docx'].includes(ext)) {
                                                icon.className = 'fas fa-file-word fa-2x text-primary';
                                            } else {
                                                icon.className = 'fas fa-file-alt fa-2x text-secondary';
                                            }
                                            docDiv.appendChild(icon);
                                            const small = document.createElement('small');
                                            small.className = 'text-center px-1';
                                            small.style.fontSize = '10px';
                                            small.style.wordBreak = 'break-word';
                                            small.textContent = filename.length > 15 ? filename.substring(0, 12) + '...' : filename;
                                            docDiv.appendChild(small);
                                            wrapper.appendChild(docDiv);
                                        }
                                        const removeBtn = document.createElement('button');
                                        removeBtn.className = 'remove-session-image position-absolute';
                                        removeBtn.style.top = '4px';
                                        removeBtn.style.right = '6px';
                                        removeBtn.style.width = '22px';
                                        removeBtn.style.height = '22px';
                                        removeBtn.style.backgroundColor = 'rgba(220, 53, 69, 0.95)';
                                        removeBtn.style.color = 'white';
                                        removeBtn.style.border = 'none';
                                        removeBtn.style.borderRadius = '50%';
                                        removeBtn.style.fontSize = '14px';
                                        removeBtn.style.fontWeight = 'bold';
                                        removeBtn.style.lineHeight = '1';
                                        removeBtn.style.textAlign = 'center';
                                        removeBtn.style.boxShadow = '0 1px 3px rgba(0,0,0,0.3)';
                                        removeBtn.style.transition = 'background-color 0.2s ease';
                                        removeBtn.style.zIndex = '10';
                                        removeBtn.title = 'Remove';
                                        removeBtn.dataset.filename = filename;
                                        removeBtn.dataset.orderId = key;
                                        removeBtn.innerHTML = '&times;';
                                        removeBtn.onmouseover = function() { this.style.backgroundColor = 'rgba(200, 35, 51, 1)'; };
                                        removeBtn.onmouseout = function() { this.style.backgroundColor = 'rgba(220, 53, 69, 0.95)'; };
                                        removeBtn.addEventListener('click', function (e) {
                                            e.preventDefault();
                                            const imageBox = this.closest('.position-relative');
                                            const orderId = this.dataset.orderId;
                                            fetch("{{ route('session.remove.image') }}", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    "X-CSRF-TOKEN": document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                                },
                                                body: JSON.stringify({ filename: filename, order_id: orderId })
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    imageBox.remove();
                                                } else {
                                                    alert(data.message || 'Failed to remove image from session.');
                                                }
                                            })
                                            .catch(err => {
                                                console.error('Error:', err);
                                                alert('An error occurred while removing the image.');
                                            });
                                        });
                                        wrapper.appendChild(removeBtn);
                                        imagesContainer.appendChild(wrapper);
                                    });
                                }
                                existingPreview.appendChild(imagesContainer);
                            }

                            const sampleImagesInput = document.getElementById('sample_images_' + key);
                            if (sampleImagesInput) {
                                sampleImagesInput.value = '';
                            }
                            const previewArea = document.getElementById('preview-area_' + key);
                            if (previewArea) {
                                previewArea.innerHTML = '';
                            }

                            const toastElement = document.getElementById('successToast');
                            const toast = new bootstrap.Toast(toastElement);
                            toast.show();
                        }
                    })
                    .finally(() => {
                        // Restore button state
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                    });
            });
        });
    });
</script>


{{-- preview uploaded images --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sample-images').forEach(input => {
            input.addEventListener('change', function(e) {
                const key = this.dataset.key;

                const files = e.target.files;
                const previewArea = document.getElementById('preview-area_' + key);
                const progressWrapper = document.getElementById('shared-progress-wrapper_' +
                    key);
                const progressBar = document.getElementById('shared-progress-bar_' + key);

                previewArea.innerHTML = '';
                progressBar.style.width = '0%';
                progressBar.innerText = '0%';
                progressBar.classList.remove('bg-success');
                progressWrapper.style.display = 'block';

                // Show previews
                // Create a grid container for previews
                let previewGrid = document.createElement('div');
                previewGrid.className = 'existing-uploads-grid mb-3';
                previewGrid.id = 'preview-uploads-grid';
                previewArea.appendChild(previewGrid);
                Array.from(files).forEach(file => {
                    const ext = file.name.split('.').pop().toLowerCase();
                    const isImage = ['jpg','jpeg','png','gif','webp'].includes(ext);
                    let wrapper = document.createElement('div');
                    wrapper.className = 'position-relative';
                    wrapper.style.width = '120px';
                    wrapper.style.height = '120px';
                    wrapper.style.margin = '0';
                    wrapper.style.display = 'flex';
                    wrapper.style.alignItems = 'center';
                    wrapper.style.justifyContent = 'center';
                    wrapper.style.background = '#fff';
                    wrapper.style.borderRadius = '6px';
                    wrapper.style.overflow = 'hidden';
                    wrapper.style.boxShadow = '0 1px 3px rgba(0,0,0,0.04)';
                    if (isImage) {
                        const reader = new FileReader();
                        const img = document.createElement('img');
                        img.className = 'img-thumbnail';
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'contain';
                        img.style.display = 'block';
                        img.style.margin = '0';
                        img.style.border = 'none';
                        img.style.background = '#f8f8f8';
                        reader.onload = function(event) {
                            img.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                        wrapper.appendChild(img);
                    } else {
                        // PDF or other document preview
                        const docDiv = document.createElement('div');
                        docDiv.className = 'd-flex flex-column justify-content-center align-items-center border rounded bg-light';
                        docDiv.style.width = '100%';
                        docDiv.style.height = '100%';
                        let icon = document.createElement('i');
                        if (ext === 'pdf') {
                            icon.className = 'fas fa-file-pdf fa-2x text-danger';
                        } else if ([ 'doc', 'docx' ].includes(ext)) {
                            icon.className = 'fas fa-file-word fa-2x text-primary';
                        } else {
                            icon.className = 'fas fa-file-alt fa-2x text-secondary';
                        }
                        docDiv.appendChild(icon);
                        let small = document.createElement('small');
                        small.className = 'text-center px-1';
                        small.style.fontSize = '10px';
                        small.style.wordBreak = 'break-word';
                        small.textContent = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
                        docDiv.appendChild(small);
                        wrapper.appendChild(docDiv);
                    }
                    previewGrid.appendChild(wrapper);
                });

                // Animate single progress bar
                let percent = 0;
                const interval = setInterval(() => {
                    percent += 5;
                    progressBar.style.width = percent + '%';
                    progressBar.innerText = percent + '%';

                    if (percent >= 100) {
                        clearInterval(interval);
                        progressBar.classList.add('bg-success');
                        progressBar.innerText = 'Done';

                        setTimeout(() => {
                            progressWrapper.style.display = 'none';
                        }, 500);
                    }
                }, 30);
            });
        });
    });
</script>
</div>
<style>

#existing_preview .existing-uploads-grid {
    display: grid;
    grid-template-columns: repeat(3, 120px); /* Default: 3 columns */
    gap: 16px;
    justify-content: start;
    max-width: 100%;
}

@media (max-width: 900px) {
    #existing_preview .existing-uploads-grid {
        grid-template-columns: repeat(2, 120px); /* Tablet: 2 columns */
    }
}

@media (max-width: 600px) {
    #existing_preview .existing-uploads-grid {
        grid-template-columns: 1fr; /* Mobile: 1 column, full width */
        justify-content: center;
    }
    #existing_preview .position-relative {
        width: 90vw;
        max-width: 320px;
        margin: 0 auto;
    }
}
#existing_preview .position-relative {
    width: 120px;
    height: 120px;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
#existing_preview .img-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    margin: 0;
    border: none;
    background: #f8f8f8;
}
</style>

<style>
#preview-uploads-grid {
    display: grid;
    grid-template-columns: repeat(3, 120px);
    gap: 16px;
    justify-content: start;
    max-width: 100%;
}
@media (max-width: 900px) {
    #preview-uploads-grid {
        grid-template-columns: repeat(2, 120px);
    }
}
@media (max-width: 600px) {
    #preview-uploads-grid {
        grid-template-columns: 1fr;
        justify-content: center;
    }
    #preview-uploads-grid .position-relative {
        width: 90vw;
        max-width: 320px;
        margin: 0 auto;
    }
}
#preview-uploads-grid .position-relative {
    width: 120px;
    height: 120px;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
#preview-uploads-grid .img-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    margin: 0;
    border: none;
    background: #f8f8f8;
}
</style>
