@extends('master.front')
@section('meta')
<meta name="keywords" content="{{$setting->meta_keywords}}">
<meta name="description" content="{{$setting->meta_description}}">
@endsection
@section('title')
    {{__('Contact')}}
@endsection

@section('content')

<style>
    /* Hero Section */
    .contact-hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset("assets/img/contact us.png") }}') center/cover no-repeat;
        min-height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        position: relative;
    }
    .contact-hero::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to bottom, transparent, #f8f9fa);
        pointer-events: none;
    }

    /* Main Contact Section */
    .contact-main-section {
        padding: 100px 0;
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }

    /* Team Photo Card */
    .team-card {
        background: #fff;
        border-radius: 20px;
        padding: 50px 35px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
    }
    .team-card h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 35px;
        color: #1a1a1a;
        letter-spacing: -0.5px;
    }
    .team-photo-wrapper {
        width: 220px;
        height: 220px;
        margin: 0 auto 35px;
        border-radius: 50%;
        overflow: hidden;
        border: 8px solid #f8f9fa;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        transition: transform 0.3s ease;
    }
    .team-photo-wrapper:hover {
        transform: scale(1.05);
    }
    .team-photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .team-photo-wrapper:hover img {
        transform: scale(1.1);
    }
    .contact-info-list {
        text-align: left;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .contact-info-list li {
        margin-bottom: 24px;
        font-size: 0.92rem;
        line-height: 1.7;
        color: #555;
        padding-left: 0;
        transition: all 0.2s ease;
    }
    .contact-info-list li:hover {
        padding-left: 5px;
    }
    .contact-info-list li strong {
        display: block;
        color: #1a1a1a;
        font-weight: 700;
        margin-bottom: 6px;
        font-size: 0.95rem;
        letter-spacing: -0.3px;
    }
    .contact-info-list a {
        color: #555;
        text-decoration: none;
        transition: color 0.2s ease;
        position: relative;
    }
    .contact-info-list a:hover {
        color: #000;
    }
    .contact-info-list a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #000;
        transition: width 0.3s ease;
    }
    .contact-info-list a:hover::after {
        width: 100%;
    }

    /* FAQ Section */
    .section-header-small {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: #888;
        margin-bottom: 12px;
        text-transform: uppercase;
    }
    .section-title-main {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 35px;
        letter-spacing: -0.5px;
        line-height: 1.3;
    }

    .faq-wrapper {
        background: #fff;
        border-radius: 20px;
        padding: 50px 45px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-bottom: 40px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .faq-item {
        border-bottom: 1px solid #ebebeb;
        transition: all 0.2s ease;
    }
    .faq-item:last-child {
        border-bottom: none;
    }
    .faq-item:hover {
        background: rgba(0,0,0,0.01);
        margin: 0 -20px;
        padding: 0 20px;
        border-radius: 8px;
    }
    .faq-question {
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        padding: 22px 0;
        font-size: 0.98rem;
        font-weight: 600;
        color: #1a1a1a;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        letter-spacing: -0.2px;
    }
    .faq-question:hover {
        color: #000;
        padding-left: 10px;
    }
    .faq-question .icon {
        font-size: 1.8rem;
        font-weight: 300;
        line-height: 1;
        transition: transform 0.3s ease, color 0.3s ease;
        color: #666;
    }
    .faq-question:hover .icon {
        transform: scale(1.2);
        color: #000;
    }
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
        font-size: 0.92rem;
        color: #666;
        line-height: 1.8;
    }
    .faq-answer.active {
        max-height: 600px;
        padding-bottom: 24px;
        animation: fadeIn 0.4s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Contact Form Section */
    .form-wrapper {
        background: #fff;
        border-radius: 20px;
        padding: 50px 45px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .form-wrapper .form-label {
        font-size: 0.88rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        display: block;
        letter-spacing: -0.2px;
    }
    .form-wrapper .form-control,
    .form-wrapper .form-select {
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        padding: 14px 18px;
        font-size: 0.92rem;
        width: 100%;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    .form-wrapper .form-control:hover,
    .form-wrapper .form-select:hover {
        border-color: #d0d0d0;
        background: #fff;
    }
    .form-wrapper .form-control:focus,
    .form-wrapper .form-select:focus {
        border-color: #000;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        background: #fff;
        transform: translateY(-1px);
    }
    .form-wrapper textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .btn-submit {
        background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
        color: #fff;
        border: none;
        padding: 15px 50px;
        font-size: 0.95rem;
        font-weight: 700;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    /* Map Section */
    .map-section {
        width: 100%;
        height: 500px;
        background: #e9ecef;
        box-shadow: 0 -5px 30px rgba(0,0,0,0.08);
        position: relative;
    }
    .map-section iframe {
        width: 100%;
        height: 100%;
        border: 0;
        filter: grayscale(20%) contrast(1.1);
    }

    /* Features Section */
    .features-section {
        padding: 80px 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
        border-top: 1px solid #e5e5e5;
    }
    .feature-box {
        text-align: center;
        padding: 30px 20px;
        transition: transform 0.3s ease;
    }
    .feature-box:hover {
        transform: translateY(-5px);
    }
    .feature-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #1a1a1a;
        font-size: 28px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .feature-box:hover .feature-icon {
        transform: scale(1.1);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
        color: #fff;
    }
    .feature-box h5 {
        font-size: 0.8rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .feature-box p {
        font-size: 0.85rem;
        color: #888;
        margin: 0;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .contact-hero { min-height: 280px; }
        .contact-main-section { padding: 60px 0; }
        .faq-wrapper, .form-wrapper { padding: 30px 25px; }
        .team-card { padding: 35px 25px; }
        .map-section { height: 350px; }
        .features-section { padding: 50px 0; }
    }
</style>

{{-- Hero Section --}}
<div class="contact-hero">
</div>

{{-- Main Contact Section --}}
<div class="contact-main-section">
    <div class="container">
        <div class="row">
            {{-- Left Column: Team Photo & Contact Info --}}
            <div class="col-lg-4 col-md-5 mb-4 mb-md-0">
                <div class="team-card">
                    <h2>{{ __('Contact') }}</h2>

                    <div class="team-photo-wrapper">
                        <img src="{{ asset('assets/img/bX2LMicrosoftTeams-image-9-560x560.png') }}"
                             alt="Our Team"
                             onerror="this.src='{{ asset('assets/img/placeholder.png') }}'">
                    </div>

                    <ul class="contact-info-list">
                        <li>
                            <strong>{{ __('Office Hours') }}</strong>
                            {{ __('Monday - Friday') }}: {{ $setting->friday_start ?? '9:00am' }} - {{ $setting->friday_end ?? '5:00pm' }}
                        </li>
                        <li>
                            <strong>{{ __('Email') }}</strong>
                            <a href="mailto:{{ $setting->footer_email }}">{{ $setting->footer_email }}</a>
                        </li>
                        <li>
                            <strong>{{ __('Phone') }}</strong>
                            <a href="tel:{{ $setting->footer_phone }}">{{ $setting->footer_phone }}</a>
                        </li>
                        <li>
                            <strong>{{ __('Showroom Hours') }}</strong>
                            {{ __('Monday - Friday') }}: {{ $setting->friday_start ?? '9:00am' }} - {{ $setting->friday_end ?? '5:00pm' }}<br>
                            {{ __('Saturday') }}: {{ $setting->satureday_start ?? '9:00am' }} - {{ $setting->satureday_end ?? '4:00pm' }}
                        </li>
                        <li>
                            <strong>{{ $setting->title ?? 'The Luxury Bed Company HQ' }}</strong>
                            {{ $setting->footer_address ?? 'West Court, Riverside West, Darlington, DL3 9PS' }}
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Right Column: FAQ + Contact Form --}}
            <div class="col-lg-8 col-md-7">

                {{-- FAQ Section --}}
                <div class="faq-wrapper">
                    <div class="section-header-small">{{ __('INFORMATION QUESTIONS') }}</div>
                    <h3 class="section-title-main">{{ __('FREQUENTLY ASKED QUESTIONS') }}</h3>

                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('What are your office hours?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Monday - Friday') }}: {{ $setting->friday_start ?? '9:00am' }} - {{ $setting->friday_end ?? '5:00pm' }}<br>
                                {{ __('Saturday') }}: {{ $setting->satureday_start ?? '9:00am' }} - {{ $setting->satureday_end ?? '4:00pm' }}<br>
                                {{ __('Sunday') }}: {{ __('Closed') }}<br><br>
                                {{ __('Please note, these may vary on bank holidays.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('Where can I visit your showroom?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Our showroom is located at') }}: {{ $setting->footer_address ?? 'West Court, Riverside West, Darlington, DL3 9PS' }}. {{ __('Please visit us during our showroom hours.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('What are your delivery time scales and charges?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Standard delivery takes 5-7 working days. Express delivery is available. Delivery charges vary based on location. Free delivery on orders over £500.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('How long will my fabric samples take to arrive?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Fabric samples are dispatched within 24 hours and typically arrive within 3-5 working days.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('Am I able to alter my bed frame?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Yes! We offer customization options. Please contact us to discuss your requirements.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('How do I make changes to my current order?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Contact us immediately. Changes can only be made before your order enters production.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('I\'m not moving in for X amount of time can you hold my order?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Yes, we can hold your order. Please inform us of your preferred delivery date.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('Do you ship outside of the UK?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Currently, we only ship within the UK mainland. Please contact us for special arrangements.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('Do you offer finance/monthly installments or deposit schemes?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Yes, we offer flexible payment plans. Contact us to learn more about our finance options.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('How do I change my shipping address for my order?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Please contact us as soon as possible with your new shipping address.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('I would like to clean my item I have purchased from you how do I do this?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Care instructions are provided with your purchase. For specific queries, please contact our support team.') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFaq(this)">
                                <span>{{ __('In the event of a refund when will I receive the funds?') }}</span>
                                <span class="icon">+</span>
                            </button>
                            <div class="faq-answer">
                                {{ __('Refunds are processed within 5-10 working days once the item is received and inspected.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="form-wrapper">
                    <div class="section-header-small">{{ __('CONTACT US') }}</div>
                    <h3 class="section-title-main">{{ __('SELECT THE RELEVANT CONTACT FORM') }}</h3>

                    @include('alerts.alerts')

                    <form method="POST" action="{{ route('front.contact.submit') }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">{{ __('Select Contact Form') }}</label>
                            <select class="form-control form-select" name="contact_form">
                                <option value="">{{ __('Please select form') }}</option>
                                <option value="general">{{ __('General Enquiry') }}</option>
                                <option value="sales">{{ __('Sales Enquiry') }}</option>
                                <option value="support">{{ __('Customer Support') }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('Your Name (required)') }}</label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('Your Email (required)') }}</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('Telephone Number') }}</label>
                            <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('Instagram Profile') }}</label>
                            <input type="text" class="form-control" name="instagram" value="{{ old('instagram') }}" placeholder="@yourusername">
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('Message') }}</label>
                            <textarea class="form-control" name="message" required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <input type="text" name="honeypot" id="honeypot" value="" style="display:none;">

                        <div class="text-right">
                            <button type="submit" class="btn-submit">{{ __('Submit Enquiry') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Map Section --}}
<div class="map-section">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2301.234!2d-1.567!3d54.543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTTCsDMyJzM1LjUiTiAxwrAzNCcwNC4xIlc!5e0!3m2!1sen!2suk!4v1234567890"
            allowfullscreen=""
            loading="lazy"></iframe>
</div>

{{-- Features Section --}}
<div class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-truck"></i>
                    </div>
                    <h5>{{ __('FAST SHIPPING') }}</h5>
                    <p>{{ __('Return of Choice') }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-credit-card"></i>
                    </div>
                    <h5>{{ __('ONLINE PAYMENT') }}</h5>
                    <p>{{ __('Safe & Secure') }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-headphones"></i>
                    </div>
                    <h5>{{ __('DEDICATED CUSTOMER CARE') }}</h5>
                    <p>{{ __('Friendly Helpdesk') }}</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="icon-shield"></i>
                    </div>
                    <h5>{{ __('100% SAFE') }}</h5>
                    <p>{{ __('SSL Certified') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('.icon');
    const isActive = answer.classList.contains('active');

    // Close all other FAQs
    document.querySelectorAll('.faq-answer').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelectorAll('.faq-question .icon').forEach(item => {
        item.textContent = '+';
    });

    // Toggle current FAQ
    if (!isActive) {
        answer.classList.add('active');
        icon.textContent = '−';
    }
}
</script>

@endsection
