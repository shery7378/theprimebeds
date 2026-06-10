@extends('master.back')

@section('content')
    <style>
        .image-wrapper {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .image-wrapper:hover .preview-overlay {
            opacity: 1;
        }

        .image-wrapper {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .preview-overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-overlay .preview-text {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 6px 12px;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
        }

        .image-wrapper:hover .preview-overlay {
            opacity: 1;
        }
    </style>
    <!-- Start of Main Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class=" mb-0">{{ __('Order Invoice') }} </h3>
                    <div>
                        <a class="btn btn-primary btn-sm" href="{{route('back.order.index')}}"><i
                                class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @php
            if ($order->state) {
                $state = json_decode($order->state, true);
            } else {
                $state = [];
            }
        @endphp

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">

                                <!-- Logo -->
                                <img class="img-fluid mb-5 mh-70" width="180" alt="Logo"
                                    src="{{url('assets/img/' . $setting->logo)}}">

                            </div>
                        </div> <!-- / .row -->
                        <div class="row">
                            <div class="container my-4">
                                @foreach ($cart as $item)
                                    @php
                                        $images = !empty($item['sample_image']) ? json_decode($item['sample_image'], true) : [];
                                        $hasImages = is_array($images) && count($images) > 0;
                                    @endphp

                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <h2 class="card-title fw-bold text-center">{{$item['name']}}</h2>

                                            @if (!empty($item['preference_description']))
                                                <div class="mt-3">
                                                    <p class="card-text text-muted h3">
                                                        {{ $item['preference_description'] }}
                                                    </p>
                                                </div>

                                            @endif

                                            @if ($hasImages)
                                                <div class="row g-3 mt-3">
                                                    @foreach ($images as $image)
                                                        @if (!empty($image))
                                                            @php
                                                                $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                                                                $imageUrl = asset('assets/preferences/' . $image);
                                                            @endphp
                                                            <div class="col-6 col-md-4 col-lg-3 text-center">
                                                                <div class="image-wrapper" style="width: 240px; height: 120px; display: flex; align-items: center; justify-content: center; margin: 0 auto; background: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                                                                    @if ($ext === 'pdf')
                                                                        <a href="{{ $imageUrl }}" target="_blank" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                                                <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                                                <span class="text-truncate" style="max-width: 100px;">{{ basename($image) }}</span>
                                                                            </div>
                                                                            <div class="preview-overlay">
                                                                                <div class="preview-text">
                                                                                    <i class="bi bi-image me-1" data-bs-toggle="tooltip" title="Preview"></i>
                                                                                </div>
                                                                                <div class="preview-text">
                                                                                    <a href="{{ $imageUrl }}" download style="color: inherit; text-decoration: none;">
                                                                                        <i class="bi bi-download me-1" data-bs-toggle="tooltip" title="Download"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ $imageUrl }}" target="_blank" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                                            <img src="{{ $imageUrl }}" class="img-fluid rounded shadow-sm mb-2" alt="Sample Image" style="width: 100%; height: 100%; object-fit: contain; display: block; margin: 0; border: none; background: #f8f8f8;">
                                                                            <div class="preview-overlay">
                                                                                <div class="preview-text">
                                                                                    <i class="bi bi-image me-1" data-bs-toggle="tooltip" title="Preview"></i>
                                                                                </div>
                                                                                <div class="preview-text">
                                                                                    <a href="{{ $imageUrl }}" download style="color: inherit; text-decoration: none;">
                                                                                        <i class="bi bi-download me-1" data-bs-toggle="tooltip" title="Download"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                                <a href="{{ $imageUrl }}" download class="btn btn-sm btn-outline-primary mt-1">
                                                                    <i class="bi bi-download"></i> Download
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection