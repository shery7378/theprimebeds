@extends('master.back')

@section('content')
    <style>
        .selectable-img {
            cursor: pointer;
            transition: 0.3s ease;
            border: 2px solid transparent;
        }

        .selectable-img.selected {
            border: 3px solid #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        }
    </style>
    <div class="container-fluid">
        <!-- Option Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>{{ __('Create  Options') }}</b></h3>
                    <a class="btn btn-primary   btn-sm" href="{{route('back.option.index', $item->id)}}"><i
                            class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body ">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <form class="admin-form" action="{{ route('back.option.store', $item->id) }}" method="POST"
                                    enctype="multipart/form-data">

                                    @csrf

                                    @include('alerts.alerts')

                                    <div class="form-group">
                                        <label for="attribute_id">{{ __('Attribute') }} *</label>
                                        <select name="attribute_id" class="form-control" id="attribute_id">
                                            <option value="">{{ __('Select Attribute') }}</option>
                                            @foreach($attributes as $attribute)
                                                <option value="{{ $attribute->id }}" {{ $attribute->id == old('attribute_id') ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="attr_name">{{ __('Name') }} *</label>
                                        <input type="text" name="name" class="form-control" id="attr_name"
                                            placeholder="{{ __('Enter Name') }}" value="{{ old('name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="stock">{{ __('Stock') }} *</label>
                                        <input type="text" name="stock" class="form-control" id="stock"
                                            placeholder="{{ __('Enter Stock') }}" value="{{ old('stock') }}">
                                        <label for="unlimited">
                                            <input type="checkbox" class="my-2" id="unlimited">
                                            {{__('Unlimited Stock')}}
                                        </label>
                                    </div>


                                    <div class="form-group">
                                        <label for="price">{{ __('+ Price') }} *</label>
                                        <small>({{ __('Set 0 to make it free') }})</small>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ $curr->sign }}
                                                </span>
                                            </div>
                                            <input type="text" id="price" name="price" class="form-control"
                                                placeholder="{{ __('Enter Price') }}" value="{{ old('price') }}">
                                        </div>
                                    </div>

                                    <input type="hidden" id="attr_keyword" name="keyword" value="{{ old('keyword') }}">
                                    <!-- Gallery -->
                                    <input type="hidden" name="variation_images" id="variation_images">

                                    <div class="row pb-4" id="image-gallery" style="margin-left:0">

                                        {{-- Main Product Image --}}
                                        {{-- @if($item->photo)
                                            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                                <img src="{{ url('assets/img/' . $item->photo) }}"
                                                    data-image="{{$item->photo }}"
                                                    class="w-100 shadow-1-strong rounded mb-4 selectable-img" alt="product" />
                                            </div>
                                        @endif --}}

                                        {{-- Gallery Images --}}
                                        @forelse($item->galleries as $gallery)
                                            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                                <img src="{{ $gallery->photo ? url('assets/img/' . $gallery->photo) : url('assets/img/placeholder.png') }}"
                                                    data-image="{{ $gallery->photo}}"
                                                    class="w-100 shadow-1-strong rounded mb-4 selectable-img" alt="gallery" />
                                            </div>
                                        @empty

                                        @endforelse

                                        <div class="form-group">
                                            <label for="sample_images" class="form-label fw-semibold mb-2 d-block" style="">
                                                Upload Reference or Sample Images
                                            </label>

                                            <div class="d-flex ">
                                                <input type="file" name="sample_images[]" id="sample_images" class="w-auto "
                                                    style="max-width: 100%; overflow: hidden; text-overflow: ellipsis;"
                                                    multiple>
                                            </div>
                                            <div id="preview-area" class="mt-3"></div>
                                            <!-- Shared progress bar -->
                                            <div id="shared-progress-wrapper" class="progress mt-3"
                                                style="height: 17px; display: none;">
                                                <div id="shared-progress-bar" class="progress-bar" style="width: 0%;"
                                                    role="progressbar" aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                            <small class=" text-muted d-block mt-2">
                                                You can upload multiple images (JPEG, PNG, etc.)
                                            </small>
                                        </div>
                                        
                                    </div>
                                    <!-- Gallery -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary w-100">{{ __('Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const images = document.querySelectorAll('.selectable-img');
            const hiddenInput = document.getElementById('variation_images');

            images.forEach(img => {
                img.addEventListener('click', function () {
                    this.classList.toggle('selected');
                    updateSelectedImages();
                });
            });

            function updateSelectedImages() {
                const selected = document.querySelectorAll('.selectable-img.selected');
                let selectedPaths = [];
                selected.forEach(img => {
                    selectedPaths.push(img.getAttribute('data-image'));
                });
                hiddenInput.value = JSON.stringify(selectedPaths);
            }
        });
    </script>
    <script>
        document.getElementById('sample_images').addEventListener('change', function (e) {
            const input = e.target;
            const previewArea = document.getElementById('preview-area');
            const progressWrapper = document.getElementById('shared-progress-wrapper');
            const progressBar = document.getElementById('shared-progress-bar');
            const dt = new DataTransfer(); // For managing selected files

            previewArea.innerHTML = '';
            progressBar.style.width = '0%';
            progressBar.innerText = '0%';
            progressBar.classList.remove('bg-success');
            progressWrapper.style.display = 'block';

            Array.from(input.files).forEach((file, index) => {
                dt.items.add(file); // Add file to DataTransfer

                const fileType = file.type;
                const fileExt = file.name.split('.').pop().toLowerCase();

                const container = document.createElement('div');
                container.className = 'd-inline-block text-center align-top position-relative';
                container.style.width = '120px';
                container.style.height = '120px';
                container.style.margin = '5px';
                container.style.border = '1px solid #ddd';
                container.style.borderRadius = '5px';
                container.style.overflow = 'hidden';
                container.style.display = 'flex';
                container.style.flexDirection = 'column';
                container.style.alignItems = 'center';
                container.style.justifyContent = 'center';
                container.style.padding = '5px';

                // ❌ Create Remove Button
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '2px';
                removeBtn.style.border = 'none';
                removeBtn.style.background = '#f44336';
                removeBtn.style.color = '#fff';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.width = '20px';
                removeBtn.style.height = '20px';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.fontSize = '14px';
                removeBtn.style.lineHeight = '16px';
                removeBtn.title = 'Remove';

                removeBtn.addEventListener('click', function () {
                    dt.items.remove(index); // remove from DataTransfer
                    input.files = dt.files; // update input
                    container.remove();     // remove preview
                });

                container.appendChild(removeBtn);

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    const img = document.createElement('img');
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = '100%';
                    img.style.border = 'none';

                    reader.onload = function (event) {
                        img.src = event.target.result;
                    };

                    reader.readAsDataURL(file);
                    container.appendChild(img);
                } else {
                    const contentWrapper = document.createElement('div');
                    contentWrapper.style.display = 'flex';
                    contentWrapper.style.flexDirection = 'column';
                    contentWrapper.style.alignItems = 'center';
                    contentWrapper.style.justifyContent = 'flex-end';
                    contentWrapper.style.width = '100%';
                    contentWrapper.style.height = '100%';
                    contentWrapper.style.padding = '5px';

                    const icon = document.createElement('i');
                    const label = document.createElement('small');

                    // File type icon
                    if (fileExt === 'pdf') {
                        icon.className = 'fas fa-file-pdf fa-2x text-danger';
                    } else if (['doc', 'docx'].includes(fileExt)) {
                        icon.className = 'fas fa-file-word fa-2x text-primary';
                    } else {
                        icon.className = 'fas fa-file-alt fa-2x text-secondary';
                    }

                    icon.style.marginBottom = '5px';

                    // File name label
                    label.innerText = file.name;
                    label.style.marginBottom = '4px';
                    label.style.wordBreak = 'break-word';
                    label.style.fontSize = '11px';
                    label.style.textAlign = 'center';
                    label.style.maxWidth = '100%';
                    label.style.maxHeight = '30px';
                    label.style.overflow = 'hidden';
                    label.style.textOverflow = 'ellipsis';

                    contentWrapper.appendChild(icon);
                    contentWrapper.appendChild(label);

                    // Apply same style as image container
                    container.style.display = 'flex';
                    container.style.flexDirection = 'column';
                    container.style.alignItems = 'center';
                    container.style.justifyContent = 'flex-end';
                    container.style.width = '120px';
                    container.style.height = '120px';
                    container.style.margin = '5px';
                    container.style.border = '1px solid #ddd';
                    container.style.borderRadius = '5px';
                    container.style.overflow = 'hidden';
                    container.style.padding = '5px';
                    container.style.backgroundColor = '#f8f9fa'; // Optional light background

                    container.appendChild(contentWrapper);
                }


                previewArea.appendChild(container);
            });

            // Set the updated files to the input
            input.files = dt.files;

            // Animate progress bar
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

    </script>
@endsection