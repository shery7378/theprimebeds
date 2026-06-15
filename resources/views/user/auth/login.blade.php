@extends('master.front')
@section('title')
    {{__('Login')}}
@endsection

@push('styles')
<style>
/* ===== LUXURY REDESIGNED LOGIN PAGE ===== */
.luxury-login-container {
    display: flex;
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05), 0 5px 15px rgba(0, 0, 0, 0.02);
    border: 1px solid #EBE5DB;
    min-height: 600px;
    margin: 40px 0;
    font-family: 'Inter', sans-serif;
    position: relative;
}

/* Left Visual panel */
.luxury-login-visual {
    width: 50%;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: flex-end;
    padding: 60px 48px;
    color: #ffffff;
}

.visual-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(51, 43, 35, 0.2) 0%, rgba(51, 43, 35, 0.85) 100%);
    z-index: 1;
}

.visual-content {
    position: relative;
    z-index: 2;
    max-width: 420px;
    animation: fadeInUp 0.8s ease-out;
}

.brand-badge {
    display: inline-block;
    padding: 6px 14px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #ffffff;
    margin-bottom: 24px;
}

.visual-content h3 {
    font-size: 32px;
    font-weight: 700;
    line-height: 1.25;
    margin-bottom: 16px;
    color: #ffffff;
    letter-spacing: -0.5px;
}

.visual-content p {
    font-size: 15px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.85);
    margin: 0;
}

/* Right Form panel */
.luxury-login-form-side {
    width: 50%;
    background: #F8F6F0; /* Beige theme bg */
    padding: 60px 48px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

/* Background Blobs */
.bg-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.5;
    pointer-events: none;
    z-index: 0;
}
.blob-1 {
    width: 250px;
    height: 250px;
    background: #EBE5DB;
    top: -50px;
    right: -50px;
    animation: floatBlob 12s ease-in-out infinite alternate;
}
.blob-2 {
    width: 300px;
    height: 300px;
    background: #F2EFE9;
    bottom: -100px;
    left: -50px;
    animation: floatBlob 15s ease-in-out infinite alternate-reverse;
}

@keyframes floatBlob {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(15px, -15px) scale(1.05); }
}

.form-wrapper {
    width: 100%;
    max-width: 380px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.7s ease-out;
}

.form-header {
    margin-bottom: 32px;
}

.form-header h2 {
    font-size: 26px;
    font-weight: 700;
    color: #332B23;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
}

.form-header p {
    font-size: 14px;
    color: #8C7558;
    margin: 0;
}

/* Input Styles */
.luxury-input-group {
    margin-bottom: 24px;
    position: relative;
}

.luxury-input-group label {
    font-size: 13px;
    font-weight: 600;
    color: #332B23;
    margin-bottom: 8px;
    display: block;
}

.input-wrapper {
    position: relative;
}

.luxury-input-group .form-control {
    background: #ffffff !important;
    border: 1.5px solid #EBE5DB !important;
    border-radius: 12px !important;
    padding: 14px 16px 14px 44px !important;
    font-size: 14px !important;
    color: #332B23 !important;
    transition: all 0.25s ease !important;
    box-shadow: none !important;
    height: auto !important;
}

.luxury-input-group .form-control::placeholder {
    color: #C0B7AD !important;
}

.luxury-input-group .form-control:focus {
    border-color: #8C7558 !important;
    box-shadow: 0 0 0 4px rgba(140, 117, 88, 0.1) !important;
    background: #ffffff !important;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #8C7558;
    display: flex;
    align-items: center;
    pointer-events: none;
    font-size: 18px;
}

.forgot-link {
    font-size: 13px;
    color: #8C7558;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.forgot-link:hover {
    color: #332B23;
    text-decoration: underline;
}

/* Password Toggle */
.password-toggle-btn {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #C0B7AD;
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    transition: color 0.2s;
    z-index: 10;
}

.password-toggle-btn:hover {
    color: #8C7558;
}

/* Submit Button */
.luxury-submit-btn {
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #8C7558 0%, #735D43 100%) !important;
    border: none !important;
    border-radius: 12px !important;
    color: #ffffff !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 15px rgba(140, 117, 88, 0.2) !important;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    margin-top: 10px;
}

.luxury-submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 200%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
    transition: left 0.6s ease;
}

.luxury-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(140, 117, 88, 0.35) !important;
}

.luxury-submit-btn:hover::before {
    left: 100%;
}

.luxury-submit-btn:active {
    transform: translateY(0);
    box-shadow: 0 4px 12px rgba(140, 117, 88, 0.2) !important;
}

/* Register prompt */
.register-prompt {
    font-size: 14px;
    color: #8C7558;
    margin-top: 24px;
    margin-bottom: 0;
}

.register-link {
    color: #332B23;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.register-link:hover {
    color: #8C7558;
    text-decoration: underline;
}

/* Social Login Divider */
.social-divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 24px 0;
    color: #C0B7AD;
    font-size: 12px;
}

.social-divider::before,
.social-divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #EBE5DB;
}

.social-divider:not(:empty)::before {
    margin-right: .75em;
}

.social-divider:not(:empty)::after {
    margin-left: .75em;
}

/* Social Buttons */
.social-login-buttons {
    gap: 16px;
}

.social-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #ffffff;
    border: 1.5px solid #EBE5DB;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.02);
}

.social-btn svg {
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
}

.social-btn.facebook-btn svg {
    fill: #1877F2;
}

.social-btn.google-btn svg {
    fill: #EA4335;
}

.social-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(140, 117, 88, 0.15);
    border-color: #8C7558;
}

.social-btn:hover svg {
    transform: scale(1.1);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE BREAKPOINTS ===== */
@media (max-width: 991px) {
    .luxury-login-container {
        flex-direction: column;
        min-height: auto;
    }
    
    .luxury-login-visual {
        width: 100%;
        height: 220px;
        padding: 40px;
    }
    
    .luxury-login-visual h3 {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    .brand-badge {
        margin-bottom: 16px;
    }
    
    .luxury-login-form-side {
        width: 100%;
        padding: 40px;
    }
    
    .form-wrapper {
        max-width: 100%;
    }
}

@media (max-width: 575px) {
    .luxury-login-visual {
        display: none; /* Hide visual on very small screens to maximize focus on form */
    }
    
    .luxury-login-container {
        border-radius: 16px;
        border: none;
        box-shadow: none;
        background: transparent;
        margin: 20px 0;
    }
    
    .luxury-login-form-side {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #EBE5DB;
        padding: 35px 24px;
    }
}
</style>
@endpush

@section('content')
  <div class="container padding-bottom-3x padding-top-2x mb-1">
    <div class="row justify-content-center">
      <div class="col-lg-11 col-xl-10">
        <div class="luxury-login-container">
          <!-- Left Visual Side -->
          <div class="luxury-login-visual" style="background-image: url('{{ asset('assets/img/Ct3bfrancesca-tosolini-HD7QBx2Yfa4-unsplash.jpg') }}');">
            <div class="visual-overlay"></div>
            <div class="visual-content">
              <div class="brand-badge">{{ $setting->title }}</div>
              <h3>Indulge in Premium Sleep</h3>
              <p>Sign in to explore our curated collections, track orders, and manage your account.</p>
            </div>
          </div>
          
          <!-- Right Form Side -->
          <div class="luxury-login-form-side">
            <!-- Background blobs for organic, premium feel -->
            <div class="bg-blob blob-1"></div>
            <div class="bg-blob blob-2"></div>
            
            <div class="form-wrapper">
              <div class="form-header">
                <h2>{{ __('Welcome Back') }}</h2>
                <p>{{ __('Please enter your credentials to log in') }}</p>
              </div>
              
              <form class="luxury-form" method="post" action="{{route('user.login.submit')}}">
                @csrf
                
                <!-- Email Input -->
                <div class="form-group luxury-input-group">
                  <label for="login_email">{{ __('Email Address') }}</label>
                  <div class="input-wrapper">
                    <input class="form-control" type="email" id="login_email" name="login_email" placeholder="{{ __('name@example.com') }}" value="{{old('login_email')}}" required>
                    <span class="input-icon"><i class="icon-mail"></i></span>
                  </div>
                  @error('login_email')
                    <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                  @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group luxury-input-group">
                  <div class="d-flex justify-content-between align-items-center">
                    <label for="login_password">{{ __('Password') }}</label>
                    <a class="forgot-link" href="{{route('user.forgot')}}">{{__('Forgot password?')}}</a>
                  </div>
                  <div class="input-wrapper">
                    <input class="form-control" type="password" id="login_password" name="login_password" placeholder="{{ __('••••••••') }}" required>
                    <span class="input-icon"><i class="icon-lock"></i></span>
                    <button type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                      <svg class="eye-icon eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                      <svg class="eye-icon eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                      </svg>
                    </button>
                  </div>
                  @error('login_password')
                    <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                  @enderror
                </div>

                <!-- Submit Button -->
                <button class="btn luxury-submit-btn" type="submit">
                  <span>{{ __('Sign In') }}</span>
                </button>
              </form>

              <!-- Not registered? -->
              <p class="register-prompt text-center">
                {{ __('New to The Prime Beds?') }} <a class="register-link" href="{{ route("user.register") }}">{{ __('Create an account') }}</a>
              </p>

              <!-- Social Login -->
              @if($setting->facebook_check == 1 || $setting->google_check == 1)
                <div class="social-divider">
                  <span>{{ __('or continue with') }}</span>
                </div>
                <div class="social-login-buttons d-flex justify-content-center">
                  @if($setting->facebook_check == 1)
                    <a class="social-btn facebook-btn" href="{{route('social.provider','facebook')}}" aria-label="{{ __('Login with Facebook') }}">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                      </svg>
                    </a>
                  @endif
                  @if($setting->google_check == 1)
                    <a class="social-btn google-btn" href="{{route('social.provider','google')}}" aria-label="{{ __('Login with Google') }}">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.136 4.114-3.43 0-6.216-2.787-6.216-6.215 0-3.429 2.786-6.216 6.216-6.216 1.572 0 2.997.585 4.093 1.547l3.197-3.197C19.167 1.83 15.938 1 12.24 1 5.972 1 12.24 12.24s4.972 11.24 11.24 11.24c6.51 0 11.24-4.577 11.24-11.24 0-.766-.078-1.503-.217-2.203H12.24z"/>
                      </svg>
                    </a>
                  @endif
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
      // Password visibility toggle
      document.addEventListener('DOMContentLoaded', function() {
          const toggleBtn = document.querySelector('.password-toggle-btn');
          if (toggleBtn) {
              toggleBtn.addEventListener('click', function() {
                  const input = document.getElementById('login_password');
                  const eyeOpen = this.querySelector('.eye-open');
                  const eyeClosed = this.querySelector('.eye-closed');
                  if (input.type === 'password') {
                      input.type = 'text';
                      eyeOpen.style.display = 'none';
                      eyeClosed.style.display = 'block';
                  } else {
                      input.type = 'password';
                      eyeOpen.style.display = 'block';
                      eyeClosed.style.display = 'none';
                  }
              });
          }
      });
  </script>
@endsection

