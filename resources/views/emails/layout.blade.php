<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $setting->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333333;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .email-header {
            background-color: {{ $setting->primary_color ?? '#007bff' }};
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-width: 150px;
            height: auto;
        }
        .email-body {
            padding: 30px;
            font-size: 16px;
            line-height: 1.6;
        }
        .email-footer {
            background-color: #eeeeee;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        .email-footer a {
            color: {{ $setting->primary_color ?? '#007bff' }};
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                @if(!empty($setting->logo) && isset($logo_cid) && !empty($logo_cid))
                    <img src="{{ $logo_cid }}" alt="{{ $setting->title }}">
                @elseif(!empty($setting->logo))
                    <img src="{{ asset('assets/img/'.$setting->logo) }}" alt="{{ $setting->title }}">
                @else
                    <h2 style="color: #ffffff; margin: 0;">{{ $setting->title }}</h2>
                @endif
            </div>

            <!-- Body Content -->
            <div class="email-body">
                {!! $body !!}
            </div>

            <!-- Footer -->
            <div class="email-footer">
                &copy; {{ date('Y') }} {{ $setting->title }}. All rights reserved.<br>
                <a href="{{ url('/') }}">Visit Our Website</a>
            </div>
        </div>
    </div>
</body>
</html>
