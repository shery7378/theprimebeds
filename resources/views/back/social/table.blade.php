@php
    $brandColors = [
        'facebook'  => '#1877F2',
        'instagram' => '#E1306C',
        'linkedin'  => '#0A66C2',
        'tiktok'    => '#010101',
        'twitter'   => '#1DA1F2',
        'youtube'   => '#FF0000',
        'whatsapp'  => '#25D366',
        'pinterest' => '#E60023',
        'snapchat'  => '#FFFC00',
        'telegram'  => '#26A5E4',
    ];

    $platformLabels = [
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
        'tiktok'    => 'TikTok',
        'twitter'   => 'Twitter / X',
        'youtube'   => 'YouTube',
        'whatsapp'  => 'WhatsApp',
        'pinterest' => 'Pinterest',
        'snapchat'  => 'Snapchat',
        'telegram'  => 'Telegram',
    ];
@endphp

@foreach($datas as $data)
@php
    $ic       = $data->icon ?? '';
    $isTikTok = str_contains(strtolower($ic), 'tiktok');
    $bc       = '#6c757d';

    foreach ($brandColors as $platform => $color) {
        if (str_contains(strtolower($ic), $platform)) {
            $bc = $color;
            break;
        }
    }

    // Derive a human-readable platform name
    $detectedPlatform = 'Custom';
    foreach ($platformLabels as $key => $label) {
        if (str_contains(strtolower($ic), $key)) {
            $detectedPlatform = $label;
            break;
        }
    }
@endphp
<tr>
    {{-- Icon bubble --}}
    <td>
        <div style="display:inline-flex;align-items:center;gap:10px;">
            <span style="display:inline-flex;align-items:center;justify-content:center;
                         width:38px;height:38px;border-radius:50%;
                         background:{{ $bc }};color:#fff;flex-shrink:0;">
                @php $isImgUrl = (bool) preg_match('/^https?:\/\//i', $ic); @endphp
                    @if ($isImgUrl)
                        <img src="{{ $ic }}" alt="icon"
                             style="width:20px;height:20px;object-fit:contain;display:block;border-radius:2px;">
                    @elseif ($isTikTok)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                             fill="currentColor" style="width:18px;height:18px;display:block;">
                            <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55
                                     162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23
                                     71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17h0A122.18
                                     122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14Z"/>
                        </svg>
                    @else
                        <i class="{{ $ic }}" style="font-size:16px;line-height:1;"></i>
                    @endif
            </span>
            <span class="font-weight-bold" style="font-size:.85rem;">
                {{ $isImgUrl ? __('Custom') : $detectedPlatform }}
            </span>
        </div>
    </td>

    {{-- Link --}}
    <td>
        <a href="{{ $data->link }}" target="_blank" rel="noopener noreferrer"
           style="word-break:break-all;font-size:.85rem;">
            {{ $data->link }}
        </a>
    </td>

    {{-- Actions --}}
    <td>
        <div class="action-list">
            <a class="btn btn-secondary btn-sm"
               href="{{ route('back.social.edit', $data->id) }}">
                <i class="fas fa-edit"></i> {{ __('Edit') }}
            </a>
            <a class="btn btn-danger btn-sm"
               data-toggle="modal"
               data-target="#confirm-delete"
               href="javascript:;"
               data-href="{{ route('back.social.destroy', $data->id) }}">
                <i class="fas fa-trash-alt"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach
