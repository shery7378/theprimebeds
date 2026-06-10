@extends('master.back')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card mb-4">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h3 class="mb-0 bc-title">
                <b>{{ __('Update Social Link') }}</b>
                <a class="btn btn-primary btn-sm ml-2" href="{{ route('back.social.index') }}">
                    <i class="fas fa-chevron-left"></i> {{ __('Back') }}
                </a>
            </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('back.dashboard') }}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('back.social.index') }}">{{ __('Social Links') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Edit') }}</li>
            </ol>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card shadow border-0">
                <div class="card-body p-4 p-md-5">

                    @include('alerts.alerts')

                    <form class="admin-form" action="{{ route('back.social.update', $social->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Hidden icon value submitted with the form --}}
                        <input type="hidden" name="icon" id="icon-field" value="{{ $social->icon }}">

                        {{-- ===== Platform Cards ===== --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-bold d-block mb-3" style="font-size:1rem;">
                                {{ __('Select Platform') }} <span class="text-danger">*</span>
                            </label>

                            @php
                                $platforms = [
                                    ['key'=>'facebook',  'label'=>'Facebook',    'fa'=>'fab fa-facebook',   'color'=>'#1877F2'],
                                    ['key'=>'instagram', 'label'=>'Instagram',   'fa'=>'fab fa-instagram',  'color'=>'#E1306C'],
                                    ['key'=>'tiktok',    'label'=>'TikTok',      'fa'=>'fab fa-tiktok',     'color'=>'#010101', 'tiktok'=>true],
                                    ['key'=>'linkedin',  'label'=>'LinkedIn',    'fa'=>'fab fa-linkedin',   'color'=>'#0A66C2'],
                                    ['key'=>'twitter',   'label'=>'Twitter / X', 'fa'=>'fab fa-twitter',    'color'=>'#1DA1F2'],
                                    ['key'=>'youtube',   'label'=>'YouTube',     'fa'=>'fab fa-youtube',    'color'=>'#FF0000'],
                                    ['key'=>'whatsapp',  'label'=>'WhatsApp',    'fa'=>'fab fa-whatsapp',   'color'=>'#25D366'],
                                    ['key'=>'snapchat',  'label'=>'Snapchat',    'fa'=>'fab fa-snapchat',   'color'=>'#FFFC00'],
                                    ['key'=>'telegram',  'label'=>'Telegram',    'fa'=>'fab fa-telegram',   'color'=>'#26A5E4'],
                                    ['key'=>'custom',    'label'=>'Custom Link', 'fa'=>'fas fa-link',       'color'=>'#6c757d'],
                                ];
                            @endphp

                            <div class="row" id="platform-cards">
                                @foreach ($platforms as $pl)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                                    <div class="platform-card text-center p-3 rounded border h-100"
                                         data-icon="{{ $pl['fa'] }}"
                                         data-key="{{ $pl['key'] }}"
                                         style="cursor:pointer;transition:all .2s ease;min-height:88px;
                                                display:flex;flex-direction:column;align-items:center;
                                                justify-content:center;user-select:none;">

                                        @if (!empty($pl['tiktok']))
                                            {{-- TikTok inline SVG (not in FA 5 free) --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                 style="width:34px;height:34px;fill:{{ $pl['color'] }};display:block;margin:0 auto 8px;">
                                                <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55
                                                         162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23
                                                         71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18
                                                         122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z"/>
                                            </svg>
                                        @else
                                            <i class="{{ $pl['fa'] }}"
                                               style="font-size:2rem;color:{{ $pl['color'] }};display:block;margin-bottom:8px;"></i>
                                        @endif

                                        <div class="small font-weight-bold" style="font-size:.75rem;line-height:1.2;">
                                            {{ $pl['label'] }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Selection feedback --}}
                            <div id="selection-feedback" class="mt-1" style="display:none;">
                                <span class="badge badge-success px-3 py-2" id="selected-label" style="font-size:.85rem;"></span>
                            </div>
                        </div>

                        {{-- ===== Custom Icon (shown only for Custom Link) ===== --}}
                        <div class="form-group" id="custom-icon-group" style="display:none;">
                            <label class="font-weight-bold d-block mb-2">
                                {{ __('Custom Icon') }} <span class="text-danger">*</span>
                            </label>

                            {{-- Type toggle --}}
                            <div class="btn-group mb-3" role="group">
                                <button type="button" id="type-fa-btn"
                                        class="btn btn-sm btn-secondary"
                                        onclick="switchIconType('fa')">
                                    <i class="fas fa-font mr-1"></i> {{ __('Font Awesome') }}
                                </button>
                                <button type="button" id="type-url-btn"
                                        class="btn btn-sm btn-outline-secondary"
                                        onclick="switchIconType('url')">
                                    <i class="fas fa-image mr-1"></i> {{ __('Image URL') }}
                                </button>
                            </div>

                            {{-- FA class input --}}
                            <div id="fa-input-group">
                                <input type="text"
                                       class="form-control"
                                       id="custom-icon-class"
                                       placeholder="{{ __('e.g. fab fa-telegram-plane') }}"
                                       value="{{ $social->icon }}">
                                <small class="form-text text-muted">
                                    {{ __('Browse icons at') }}
                                    <a href="https://fontawesome.com/icons?d=gallery&s=brands&m=free" target="_blank">
                                        fontawesome.com
                                    </a>
                                </small>
                                {{-- Live preview --}}
                                <div class="mt-2" id="fa-preview" style="display:none;">
                                    <span class="font-weight-bold small text-muted mr-2">{{ __('Preview:') }}</span>
                                    <span id="fa-preview-icon"
                                          style="display:inline-flex;align-items:center;justify-content:center;
                                                 width:32px;height:32px;border-radius:50%;
                                                 background:#6c757d;color:#fff;font-size:14px;"></span>
                                </div>
                            </div>

                            {{-- Image URL input --}}
                            <div id="url-input-group" style="display:none;">
                                <input type="text"
                                       class="form-control"
                                       id="custom-icon-url"
                                       placeholder="https://example.com/icon.png">
                                <small class="form-text text-muted">
                                    {{ __('Paste a direct link to a PNG, SVG, WebP or GIF image.') }}
                                </small>
                                {{-- Live preview --}}
                                <div class="mt-2" id="url-preview" style="display:none;">
                                    <span class="font-weight-bold small text-muted mr-2">{{ __('Preview:') }}</span>
                                    <span style="display:inline-flex;align-items:center;justify-content:center;
                                                 width:32px;height:32px;border-radius:50%;background:#6c757d;">
                                        <img id="url-preview-img" src="" alt="preview"
                                             style="width:18px;height:18px;object-fit:contain;display:block;">
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- ===== URL ===== --}}
                        <div class="form-group">
                            <label for="link" class="font-weight-bold">
                                {{ __('Profile / Page URL') }} <span class="text-danger">*</span>
                            </label>
                            <input type="url"
                                   name="link"
                                   id="link"
                                   class="form-control"
                                   placeholder="https://www.facebook.com/yourpage"
                                   value="{{ $social->link }}"
                                   required>
                            <small class="form-text text-muted">{{ __('Enter the full URL including https://') }}</small>
                        </div>

                        {{-- ===== Submit ===== --}}
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-secondary px-4">
                                <i class="fas fa-save mr-1"></i> {{ __('Update Social Link') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
(function () {
    var cards        = document.querySelectorAll('.platform-card');
    var iconField    = document.getElementById('icon-field');
    var custGroup    = document.getElementById('custom-icon-group');
    var custInput    = document.getElementById('custom-icon-class');
    var urlInput     = document.getElementById('custom-icon-url');
    var feedback     = document.getElementById('selection-feedback');
    var selLabel     = document.getElementById('selected-label');
    var currentType  = 'fa';

    /* ---- Icon-type toggle ---- */
    window.switchIconType = function (type) {
        currentType = type;
        var faGroup  = document.getElementById('fa-input-group');
        var urlGroup = document.getElementById('url-input-group');
        var faBtn    = document.getElementById('type-fa-btn');
        var urlBtn   = document.getElementById('type-url-btn');

        if (type === 'fa') {
            faGroup.style.display  = '';
            urlGroup.style.display = 'none';
            faBtn.className  = 'btn btn-sm btn-secondary';
            urlBtn.className = 'btn btn-sm btn-outline-secondary';
            iconField.value  = custInput.value;
        } else {
            faGroup.style.display  = 'none';
            urlGroup.style.display = '';
            faBtn.className  = 'btn btn-sm btn-outline-secondary';
            urlBtn.className = 'btn btn-sm btn-secondary';
            iconField.value  = urlInput.value;
        }
    };

    /* ---- FA class input: sync + live preview ---- */
    custInput.addEventListener('input', function () {
        if (currentType !== 'fa') return;
        iconField.value = this.value.trim();
        var prev     = document.getElementById('fa-preview');
        var prevIcon = document.getElementById('fa-preview-icon');
        if (this.value.trim()) {
            prevIcon.innerHTML = '<i class="' + this.value.trim() + '"></i>';
            prev.style.display = '';
        } else {
            prev.style.display = 'none';
        }
    });

    /* ---- Image URL input: sync + live preview ---- */
    urlInput.addEventListener('input', function () {
        if (currentType !== 'url') return;
        iconField.value = this.value.trim();
        var prev    = document.getElementById('url-preview');
        var prevImg = document.getElementById('url-preview-img');
        if (this.value.trim()) {
            prevImg.src = this.value.trim();
            prev.style.display = '';
        } else {
            prev.style.display = 'none';
        }
    });

    /* ---- Card click ---- */
    function selectCard(card) {
        cards.forEach(function (c) {
            c.style.borderColor     = '';
            c.style.backgroundColor = '';
            c.style.boxShadow       = '';
            c.style.transform       = '';
        });
        card.style.borderColor     = '#4e73df';
        card.style.backgroundColor = '#eef1fb';
        card.style.boxShadow       = '0 0 0 3px rgba(78,115,223,.2)';
        card.style.transform       = 'translateY(-2px)';

        var key  = card.dataset.key;
        var icon = card.dataset.icon;

        if (key === 'custom') {
            custGroup.style.display = '';
            iconField.value = (currentType === 'url') ? urlInput.value : custInput.value;
        } else {
            custGroup.style.display = 'none';
            iconField.value = icon;
        }

        var labelEl = card.querySelector('div.small');
        selLabel.textContent = '✓ ' + (labelEl ? labelEl.textContent.trim() : key) + ' selected';
        feedback.style.display = '';
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function () { selectCard(this); });
    });

    /* ---- Auto-select the card that matches the saved icon ---- */
    var existing = iconField.value;
    if (existing) {
        var isUrl = /^https?:\/\//i.test(existing);
        var found = false;

        if (!isUrl) {
            cards.forEach(function (card) {
                if (card.dataset.icon === existing && card.dataset.key !== 'custom') {
                    selectCard(card);
                    found = true;
                }
            });
        }

        if (!found) {
            var customCard = document.querySelector('.platform-card[data-key="custom"]');
            if (customCard) {
                selectCard(customCard);
                if (isUrl) {
                    switchIconType('url');
                    urlInput.value  = existing;
                    document.getElementById('url-preview-img').src = existing;
                    document.getElementById('url-preview').style.display = '';
                } else {
                    switchIconType('fa');
                    custInput.value = existing;
                    if (existing) {
                        document.getElementById('fa-preview-icon').innerHTML = '<i class="' + existing + '"></i>';
                        document.getElementById('fa-preview').style.display = '';
                    }
                }
                iconField.value = existing;
            }
        }
    }
})();
</script>
@endsection
