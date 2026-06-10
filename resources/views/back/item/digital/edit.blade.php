@extends('master.back')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>{{ __('Update Digital Product') }}</b> </h3>
                    <a class="btn btn-primary   btn-sm" href="{{route('back.item.index')}}"><i
                            class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                @include('alerts.alerts')
            </div>
        </div>
        <!-- Nested Row within Card Body -->

        <form class="admin-form" action="{{ route('back.item.update', $item->id) }}" method="POST"
            enctype="multipart/form-data">

            @csrf

            @method('PUT')
            <div class="row">

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }} *</label>
                                <input type="text" name="name" class="form-control item-name" id="name"
                                    placeholder="{{ __('Enter Name') }}" value="{{ $item->name }}">
                            </div>

                            <div class="form-group">
                                <label for="slug">{{ __('Slug') }} *</label>
                                <input type="text" name="slug" class="form-control" id="slug"
                                    placeholder="{{ __('Enter Slug') }}" value="{{ $item->slug }}">
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group pb-0  mb-0">
                                <label class="d-block">{{ __('Featured Image') }} *</label>
                            </div>
                            <div class="form-group pb-0 pt-0 mt-0 mb-0">
                                <img class="admin-img lg"
                                    src="{{ $item->photo ? url('assets/img/' . $item->photo) : url('assets/img/placeholder.png') }}">
                            </div>
                            <div class="form-group position-relative ">
                                <label class="file">
                                    <input type="file" accept="image/*" class="upload-photo" name="photo" id="file"
                                        aria-label="File browser example">
                                    <span class="file-custom text-left">{{ __('Upload Image...') }}</span>
                                </label>
                                <br>
                                <span
                                    class="mt-1 text-info">{{ __('Image Size Should Be 800 x 800. or square size') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group pb-0  mb-0">
                                <label>{{ __('Gallery Images') }} </label>
                            </div>
                            <div class="form-group pb-0 pt-0 mt-0 mb-0">
                                <div id="gallery-images">
                                    <div class="d-block gallery_image_view">

                                        @forelse($item->galleries as $gallery)
                                            <div class="single-g-item d-inline-block m-2">
                                                <span data-toggle="modal" data-target="#confirm-delete" href="javascript:;"
                                                    data-href="{{ route('back.item.gallery.delete', $gallery->id) }}"
                                                    class="remove-gallery-img">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <a class="popup-link"
                                                    href="{{ $gallery->photo ? url('assets/img/' . $gallery->photo) : url('assets/img/placeholder.png') }}">
                                                    <img class="admin-gallery-img"
                                                        src="{{ $gallery->photo ? url('assets/img/' . $gallery->photo) : url('assets/img/placeholder.png') }}"
                                                        alt="No Image Found">
                                                </a>
                                            </div>
                                        @empty
                                            <h6><b>{{ __('No Images Added') }}</b></h6>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="form-group position-relative ">
                                <label class="file">
                                    <input type="file" accept="image/*" name="galleries[]" id="gallery_file"
                                        aria-label="File browser example" accept="image/*" multiple>
                                    <span class="file-custom text-left">{{ __('Upload Image...') }}</span>
                                </label>
                                <br>
                                <span
                                    class="mt-1 text-info">{{ __('Image Size Should Be 800 x 800. or square size') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="file_type">{{ __('Select Type') }}</label>
                                <select class="form-control" id="file_type" name="file_type">
                                    <option value="file" {{$item->file_type == 'file' ? 'selected' : ''}}>{{__('File')}}
                                    </option>
                                    <option value="link" {{$item->file_type == 'link' ? 'selected' : ''}}>{{__('Link')}}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group view_file {{$item->file_type == 'file' ? '' : 'd-none'}} ">
                                <label for="file">{{ __('File') }}</label>
                                <div class="input-group mb-1">
                                    <input type="file" class="form-control" id="file" name="file">
                                </div>
                                @if (file_exists('assets/files/' . $item->file))
                                    <a download href="{{asset('assets/files/' . $item->file)}}">{{__('Download File')}}</a>
                                @endif
                                <p class="text-warning">{{__('File type must be zip')}}</p>
                            </div>

                            <div class="form-group view_link {{$item->file_type == 'link' ? '' : 'd-none'}}">
                                <label for="link">{{ __('Link') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="link" name="link" class="form-control" value="{{$item->link}}"
                                        placeholder="{{__('Enter Link')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="sort_details">{{ __('Short Description') }} *</label>
                                <textarea name="sort_details" id="sort_details" class="form-control"
                                    placeholder="{{ __('Short Description') }}">{{$item->sort_details}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="details">{{ __('Description') }} *</label>
                                <textarea name="details" id="details" class="form-control text-editor" rows="6"
                                    placeholder="{{ __('Enter Description') }}">{{$item->details}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tags">{{ __('Product Tags') }}
                                </label>
                                <input type="text" name="tags" class="tags" id="tags" placeholder="{{ __('Tags') }}"
                                    value="{{$item->tags}}">
                            </div>
                            <div class="form-group">
                                <label class="switch-primary">
                                    <input type="checkbox" class="switch switch-bootstrap status radio-check"
                                        name="is_specification" value="1" {{$item->is_specification == 1 ? 'checked' : ''}}>
                                    <span class="switch-body"></span>
                                    <span class="switch-text">{{ __('Specifications') }}</span>
                                </label>
                            </div>

                            <div id="specifications-section" class="{{ $item->is_specification == 0 ? 'd-none' : '' }}">
                                @if(!empty($specification_name))
                                    @foreach(array_combine($specification_name, $specification_description) as $name => $description)
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="specification_name[]"
                                                        placeholder="{{ __('Specification Name') }}" value="{{$name}}">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="specification_description[]"
                                                        placeholder="{{ __('Specification description') }}"
                                                        value="{{$description}}">
                                                </div>
                                            </div>
                                            <div class="flex-btn">
                                                @if($loop->first)
                                                    <button type="button" class="btn btn-success add-specification"
                                                        data-text="{{ __('Specification Name') }}"
                                                        data-text1="{{ __('Specification Description') }}"> <i class="fa fa-plus"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger remove-spcification"
                                                        data-text="{{ __('Specification Name') }}"
                                                        data-text1="{{ __('Specification Description') }}"> <i class="fa fa-minus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                    @endforeach
                                @else
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="specification_name[]"
                                                    placeholder="{{ __('Specification Name') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="specification_description[]"
                                                    placeholder="{{ __('Specification description') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-btn">
                                            <button type="button" class="btn btn-success add-specification"
                                                data-text="{{ __('Specification Name') }}"
                                                data-text1="{{ __('Specification Description') }}"> <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="meta_keywords">{{ __('Meta Keywords') }}
                                </label>
                                <input type="text" name="meta_keywords" class="tags" id="meta_keywords"
                                    placeholder="{{ __('Enter Meta Keywords') }}" value="{{ $item->meta_keywords }}">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">{{ __('Meta Description') }}
                                </label>
                                <textarea name="meta_description" id="meta_description" class="form-control" rows="5"
                                    placeholder="{{ __('Enter Meta Description') }}">{{ $item->meta_description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label for="tags">{{ __('Discount Packages') }}
                                </label>
                            </div>
                            <div id="discount-section">
                                @if (!empty($item->bundle_discount))
                                    <div id="discount-section">
                                        @php
                                            $items = $item->bundle_discount['discount_items'] ?? [''];
                                            $prices = $item->bundle_discount['discountItems_price'] ?? [''];
                                            $count = max(count($items), count($prices));
                                        @endphp

                                        @for ($i = 0; $i < $count; $i++)
                                            <div class="d-flex mb-2">
                                                <div class="flex-grow-1">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="discount_items[]"
                                                            placeholder="{{ __('No.of Items') }}" value="{{ $items[$i] ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="discountItems_price[]"
                                                                placeholder="{{ __('Discount Percentage') }}"
                                                                value="{{ $prices[$i] ?? '' }}"
                                                                min="0" max="99"
                                                                oninput="if(this.value > 99) this.value = 99; if(this.value < 0) this.value = 0;">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-btn">
                                                    <button type="button" class="btn btn-success add-discount"
                                                        data-text="{{ __('No.of Items') }}"
                                                        data-text1="{{ __('Discount Percentage') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>

                                @else
                                    <div class="d-flex">

                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="discount_items[]"
                                                    placeholder="{{ __('No.of Items') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="discountItems_price[]"
                                                    placeholder="{{ __('Discounted Price') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-btn">
                                            <button type="button" class="btn btn-success add-discount"
                                                data-text="{{ __('No.of Items') }}" data-text1="{{ __('Discounted Price') }}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (isset($item->variations))
                        <div class="card">

                            <div class="form-row ml-2">
                                <!-- Custom Text Input -->
                                <div class="form-group col-md-12">
                                    <label for="custom_text">Important Note (optional)</label>
                                    <input type="text" name="custom_text" id="custom_text" class="form-control"
                                        placeholder="Enter your name, message, or slogan"
                                        value="{{$item->variations['custom_text'] ?? ''}}">
                                </div>

                            </div>

                            <div class="form-row ml-2">
                                <!-- Customisation Level -->
                                <div class="form-group col-md-8">
                                    <label for="customization_level">Customisation Level</label>
                                    <select name="customization_level" id="customization_level" class="form-control">
                                        <option value="">-- Select Customisation Type --</option>
                                        <option value="customizable" {{ $item->variations['customization_level'] === 'customizable' ? 'selected' : '' }}>
                                            Customizable</option>
                                        <option value="not_customizable" {{ $item->variations['customization_level'] === 'not_customizable' ? 'selected' : '' }}>
                                            Not Customizable</option>
                                        <option value="partial_customizable" {{ $item->variations['customization_level'] === 'partial_customizable' ? 'selected' : '' }}>Partially Customizable</option>
                                    </select>
                                </div>

                            </div>


                        </div>
                    @endif
                </div>

                    {{-- ═══════════════════════════════════════════
                         BED CUSTOMIZER SECTION
                    ═══════════════════════════════════════════ --}}
                    @if(false) {{-- Bed Customizers section disabled --}}
                    <div class="card mt-3">
                        <div class="card-body pb-0">
                            <h5 class="mb-1" style="font-weight:700;color:#333;">
                                <i class="fas fa-sliders-h mr-2 text-primary"></i>
                                {{ __('Bed Customizers') }}
                            </h5>
                            <p class="text-muted mb-3" style="font-size:13px;">
                                {{ __('Select which customizer sections appear on this product\'s page.') }}
                            </p>
                        </div>

                        <style>
                            .bc-accordion-row {
                                border-top: 1px solid #e8ecf1;
                                transition: background 0.15s;
                            }
                            .bc-accordion-row:last-child { border-bottom: 1px solid #e8ecf1; }
                            .bc-accordion-header {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                padding: 13px 20px;
                                cursor: pointer;
                                user-select: none;
                            }
                            .bc-accordion-header:hover { background: #f8f9fa; }
                            .bc-accordion-left {
                                display: flex;
                                align-items: center;
                                gap: 12px;
                            }
                            .bc-toggle-icon {
                                width: 26px;
                                height: 26px;
                                border-radius: 50%;
                                border: 2px solid #0d6efd;
                                color: #0d6efd;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 15px;
                                font-weight: 700;
                                flex-shrink: 0;
                                transition: all 0.2s;
                            }
                            .bc-accordion-row.bc-open .bc-toggle-icon {
                                background: #0d6efd;
                                color: #fff;
                            }
                            .bc-customizer-label {
                                font-weight: 600;
                                font-size: 14px;
                                color: #333;
                                margin: 0;
                            }
                            .bc-required-star {
                                color: #dc3545;
                                font-size: 16px;
                                font-weight: 700;
                                margin-left: 4px;
                            }
                            .bc-badge {
                                font-size: 11px;
                                background: #e9ecef;
                                color: #555;
                                padding: 2px 8px;
                                border-radius: 20px;
                            }
                            .bc-accordion-body {
                                display: none;
                                background: #fafbfc;
                                border-top: 1px dashed #dee2e6;
                                padding: 14px 20px 16px 20px;
                            }
                            .bc-accordion-row.bc-open .bc-accordion-body { display: block; }
                            .bc-checkbox-wrap {
                                display: flex;
                                align-items: center;
                                gap: 10px;
                                margin-bottom: 12px;
                            }
                            .bc-checkbox-wrap input[type="checkbox"] {
                                width: 18px;
                                height: 18px;
                                accent-color: #0d6efd;
                                cursor: pointer;
                            }
                            .bc-checkbox-wrap label {
                                font-size: 14px;
                                font-weight: 600;
                                color: #333;
                                margin: 0;
                                cursor: pointer;
                            }
                            .bc-options-preview {
                                margin-top: 10px;
                                display: flex;
                                flex-wrap: wrap;
                                gap: 8px;
                            }
                            .bc-option-chip {
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                background: #fff;
                                border: 1px solid #dee2e6;
                                border-radius: 6px;
                                padding: 5px 10px;
                                font-size: 12px;
                                color: #555;
                            }
                            .bc-option-chip .chip-price {
                                color: #28a745;
                                font-weight: 600;
                            }
                            .bc-option-chip .chip-price.neg { color: #dc3545; }
                            .bc-option-img {
                                width: 24px;
                                height: 24px;
                                object-fit: cover;
                                border-radius: 4px;
                            }
                            .bc-empty-options {
                                font-size: 12px;
                                color: #aaa;
                                font-style: italic;
                            }
                            .bc-assigned-indicator {
                                display: inline-flex;
                                align-items: center;
                                gap: 5px;
                                background: #d1e7dd;
                                color: #0a3622;
                                font-size: 11px;
                                font-weight: 600;
                                padding: 2px 8px;
                                border-radius: 20px;
                            }
                        </style>

                        @if(isset($customizers) && $customizers->count() > 0)
                            @foreach($customizers as $customizer)
                            @php $isAssigned = in_array($customizer->id, $assignedCustomizerIds ?? []); @endphp
                            <div class="bc-accordion-row {{ $isAssigned ? 'bc-open' : '' }}"
                                 id="bc-row-{{ $customizer->id }}">

                                {{-- Header (click to expand) --}}
                                <div class="bc-accordion-header"
                                     onclick="bcToggle({{ $customizer->id }})">
                                    <div class="bc-accordion-left">
                                        <div class="bc-toggle-icon" id="bc-icon-{{ $customizer->id }}">
                                            {{ $isAssigned ? '−' : '+' }}
                                        </div>
                                        <span class="bc-customizer-label">
                                            {{ $customizer->name }}
                                            @if($customizer->is_required)
                                                <span class="bc-required-star">*</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" style="gap:8px;">
                                        <span class="bc-badge">{{ $customizer->activeOptions->count() }} {{ __('options') }}</span>
                                        @if($isAssigned)
                                            <span class="bc-assigned-indicator" id="bc-status-label-{{ $customizer->id }}">
                                                <i class="fas fa-check-circle" style="font-size:10px;"></i> {{ __('Assigned') }}
                                            </span>
                                        @else
                                            <span style="font-size:11px;color:#aaa;font-weight:normal;" id="bc-status-label-{{ $customizer->id }}">
                                                {{ __('Not assigned') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Body --}}
                                <div class="bc-accordion-body" id="bc-body-{{ $customizer->id }}">

                                    {{-- Assign toggle --}}
                                    <div class="bc-checkbox-wrap">
                                        <input type="checkbox"
                                               name="bed_customizer_ids[]"
                                               value="{{ $customizer->id }}"
                                               id="bc_check_{{ $customizer->id }}"
                                               {{ $isAssigned ? 'checked' : '' }}
                                               onchange="bcCheckChanged({{ $customizer->id }}, this)">
                                        <label for="bc_check_{{ $customizer->id }}">
                                            {{ __('Enable on this product') }}
                                        </label>
                                    </div>

                                    {{-- Options preview --}}
                                    @if($customizer->activeOptions->count() > 0)
                                        <p style="font-size:12px;font-weight:600;color:#777;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                            {{ __('Available Options') }}
                                        </p>
                                        <div class="bc-options-preview">
                                            @foreach($customizer->activeOptions as $option)
                                            <div class="bc-option-chip">
                                                @if($option->image)
                                                    <img src="{{ asset('assets/images/customizer/' . $option->image) }}"
                                                         alt="{{ $option->name }}"
                                                         class="bc-option-img">
                                                @endif
                                                <span>{{ $option->name }}</span>
                                                @if($option->price != 0)
                                                    <span class="chip-price {{ $option->price < 0 ? 'neg' : '' }}">
                                                        {{ $option->price > 0 ? '+' : '-' }}£{{ number_format(abs($option->price), 0) }}
                                                    </span>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="bc-empty-options">{{ __('No options added yet. Add them from Bed Customizer → Options.') }}</p>
                                    @endif

                                    @if($customizer->description)
                                        <p style="font-size:12px;color:#888;margin-top:10px;margin-bottom:0;">
                                            <i class="fas fa-info-circle mr-1"></i>{{ $customizer->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="px-4 py-3 text-muted" style="font-size:13px;">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ __('No bed customizers found.') }}
                                <a href="{{ route('back.bedcustomizer.create') }}" class="ml-2">{{ __('Create one') }}</a>
                            </div>
                        @endif

                        <div class="card-footer bg-transparent border-top-0 pt-0">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb mr-1 text-warning"></i>
                                {{ __('Checked customizers will appear as collapsible sections on the product page.') }}
                            </small>
                        </div>
                    </div>
                    {{-- END BED CUSTOMIZER SECTION --}}
                    @endif

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" class="check_button" name="is_button" value="0">
                            <button type="submit" class="btn btn-secondary mr-2">{{ __('Save') }}</button>
                            <button type="submit" class="btn btn-info save__edit">{{ __('Save & Edit') }}</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="discount_price">{{ __('Current Price') }}
                                    *</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $curr->sign }}</span>
                                    </div>
                                    <input type="text" id="discount_price" name="discount_price" class="form-control"
                                        placeholder="{{ __('Enter Current Price') }}" min="1" step="0.1"
                                        value="{{ round($item->discount_price * $curr->value, 2) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="previous_price">{{ __('Previous Price') }}
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $curr->sign }}</span>
                                    </div>
                                    <input type="text" id="previous_price" name="previous_price" class="form-control"
                                        placeholder="{{ __('Enter Previous Price') }}" min="1" step="0.1"
                                        value="{{ round($item->previous_price * $curr->value, 2)}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="purchase_price">{{ __('Purchase Price') }}
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $curr->sign }}</span>
                                    </div>
                                    <input type="text" id="purchase_price" name="purchase_price" class="form-control"
                                        placeholder="{{ __('Enter Purchase Price') }}" min="1" step="0.1"
                                        value="{{ round($item->purchase_price * $curr->value, 2)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id">{{ __('Select Category') }} *</label>
                                <select name="category_id" id="category_id" data-href="{{route('back.get.subcategory')}}"
                                    class="form-control">
                                    @foreach(DB::table('categories')->whereStatus(1)->get() as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $item->category_id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcategory_id">{{ __('Select Sub Category') }} </label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control"
                                    data-href="{{route('back.get.childcategory')}}">
                                    <option value="">{{__('Select one')}}</option>
                                    @foreach(DB::table('subcategories')->where('category_id', $item->category_id)->whereStatus(1)->get() as $subcat)
                                        <option value="{{ $subcat->id }}" {{ $subcat->id == $item->subcategory_id ? 'selected' : '' }}>{{ $subcat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="childcategory_id">{{ __('Select Child Category') }} </label>
                                <select name="childcategory_id" id="childcategory_id" class="form-control">
                                    <option value="">{{__('Select one')}}</option>
                                    @foreach(DB::table('chield_categories')->where('category_id', $item->category_id)->whereStatus(1)->get() as $chieldcategory)
                                        <option value="{{ $chieldcategory->id }}" {{ $chieldcategory->id == $item->childcategory_id ? 'selected' : '' }}>
                                            {{ $chieldcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label for="brand_id">{{ __('Select Brand') }} </label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="" selected>{{__('Select Brand')}}</option>
                                    @foreach(DB::table('brands')->whereStatus(1)->get() as $brand)
                                    <option value="{{ $brand->id }}" {{$brand->id == $item->brand_id ? 'selected' : ''}} >{{
                                        $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="tax_id">{{ __('Select Tax') }}</label>
                                <select name="tax_id" id="tax_id" class="form-control">
                                    <option value="">{{__('Select One')}}</option>
                                    @foreach(DB::table('taxes')->whereStatus(1)->get() as $tax)
                                        <option value="{{ $tax->id }}" {{$item->tax_id == $tax->id ? 'selected' : ''}}>
                                            {{ $tax->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sku">{{ __('SKU') }} *</label>
                                <input type="text" name="sku" class="form-control" id="sku"
                                    placeholder="{{ __('Enter SKU') }}" value="{{$item->sku}}">
                            </div>
                            <div class="form-group">
                                <label for="video">{{ __('Video Link') }} </label>
                                <input type="text" name="video" class="form-control" id="video"
                                    placeholder="{{ __('Enter Video Link') }}" value="{{$item->video}}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>


    </div>

@endsection
@section('scripts')
    <script>
        $(document).on('change', '#file_type', function () {
            let type = $(this).val();
            if (type == 'file') {
                $('.view_link').addClass('d-none');
                $('.view_file').removeClass('d-none');
                $('.view_file input').prop('required',false);
                $('.view_link input').prop('required',false);
            }else{
                $('.view_link').removeClass('d-none');
                $('.view_file').addClass('d-none');
                $('.view_file input').prop('required',false);
                $('.view_link input').prop('required',false);
            }
        })
    </script>

    <script>
        function bcToggle(id) {
            const row  = document.getElementById('bc-row-' + id);
            const icon = document.getElementById('bc-icon-' + id);
            const isOpen = row.classList.contains('bc-open');
            row.classList.toggle('bc-open', !isOpen);
            icon.textContent = isOpen ? '+' : '−';
        }

        function bcCheckChanged(id, checkbox) {
            const label = document.getElementById('bc-status-label-' + id);
            if (checkbox.checked) {
                label.innerHTML = '<i class="fas fa-check-circle" style="font-size:10px;"></i> Assigned';
                label.className = 'bc-assigned-indicator';
            } else {
                label.textContent = 'Not assigned';
                label.className   = '';
                label.style.cssText = 'font-size:11px;color:#aaa;font-weight:normal;';
            }
        }
    </script>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              {{ __('You are going to delete this image from gallery.') }} {{ __('Do you want to delete it?') }}
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
              <form action="" class="d-inline btn-ok" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
              </form>
            </div>

          </div>
        </div>
      </div>

      <script>
        $('#confirm-delete').on('show.bs.modal', function (e) {
          var action = $(e.relatedTarget).data("href");
          $('.btn-ok form').attr('action', action);
        });
      </script>
    {{-- DELETE MODAL ENDS --}}
@endsection
