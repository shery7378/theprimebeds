@extends('master.front')
@section('title')
    {{__('Order Track')}}
@endsection

@section('content')
<style>
.track-page-container {
    padding: 5rem 0 6rem;
    background: #FAF9F6; /* Premium warm luxury cream background */
}

.track-card {
    background: #ffffff;
    border: 1px solid #EBE5DB;
    border-radius: 24px;
    padding: 4.5rem 3.5rem;
    box-shadow: 0 12px 40px rgba(140, 117, 88, 0.04);
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
}

/* Decorative backdrop glow */
.track-card::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(140, 117, 88, 0.08) 0%, rgba(140, 117, 88, 0) 70%);
    pointer-events: none;
}

.track-header {
    text-align: center;
    margin-bottom: 3.5rem;
}

.track-badge-icon {
    width: 76px;
    height: 76px;
    background: #F8F6F0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    margin: 0 auto 1.5rem;
    border: 1.5px dashed var(--primary-color);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    animation: pulseIcon 3s infinite ease-in-out;
}

@keyframes pulseIcon {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.track-title {
    font-family: 'Playfair Display', Georgia, serif;
    color: #332B23;
    font-size: 2.25rem;
    font-weight: 700;
    margin-bottom: 0.85rem;
    letter-spacing: -0.3px;
}

.track-subtitle {
    font-family: 'Outfit', sans-serif;
    color: #7E7367;
    font-size: 1.05rem;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Custom Input Field Group */
.track-input-group {
    position: relative;
    display: flex;
    align-items: center;
    border: 2px solid #EBE5DB;
    border-radius: 50px;
    background: #FDFDFD;
    padding: 6px 6px 6px 24px;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.01);
}

.track-input-group:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.05), inset 0 2px 5px rgba(0, 0, 0, 0.01);
    background: #ffffff;
}

.track-input-icon {
    color: var(--primary-color);
    margin-right: 12px;
    display: flex;
    align-items: center;
}

.track-input {
    border: none !important;
    outline: none !important;
    background: transparent !important;
    flex: 1;
    font-family: 'Outfit', sans-serif;
    font-size: 1.05rem;
    color: #332B23;
    font-weight: 500;
    padding: 10px 0;
    height: auto !important;
    box-shadow: none !important;
}

.track-input::placeholder {
    color: #A39688;
    font-weight: 400;
}

.track-btn {
    background: var(--primary-color);
    color: #ffffff !important;
    border: none;
    border-radius: 50px;
    padding: 14px 36px;
    font-family: 'Outfit', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
}

.track-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.25), transparent);
    transition: all 0.7s ease;
}

.track-btn:hover {
    background: var(--primary-color);
    filter: brightness(85%);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
}

.track-btn:hover::before {
    left: 100%;
}

.track-btn:active {
    transform: translateY(0);
}

.track-btn .arrow-icon {
    transition: transform 0.3s ease;
}

.track-btn:hover .arrow-icon {
    transform: translateX(3px);
}

#track-order {
    transition: all 0.4s ease;
}
</style>

<!-- Page Title-->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a> </li>
                    <li class="separator"></li>
                    <li>{{ __('Track Order') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="track-page-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="track-card">
                    <div class="track-header">
                        <div class="track-badge-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="10" r="3"/>
                                <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 7 8 11.7z"/>
                            </svg>
                        </div>
                        <h2 class="track-title">{{ __('Track Your Order') }}</h2>
                        <p class="track-subtitle">{{ __('Enter your order number below to check the real-time shipment status of your luxury sleep items.') }}</p>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <div class="track-input-group">
                                <div class="track-input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <input class="track-input" type="text" id="order_number" name="order_number" placeholder="{{ __('Order Number (e.g. TXN-XXXXXX)') }}">
                                <button class="track-btn" id="submit_number" data-href="{{route('front.order.track.submit')}}" type="submit">
                                    <span>{{ __('Track Now') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="arrow-icon">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-lg-12">
                            <div id="track-order">
                                <!-- Ajax content loads here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
