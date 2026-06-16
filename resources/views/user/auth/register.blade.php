@extends('master.front')
@section('title')
    {{__('Register')}}
@endsection

@push('styles')
<style>
/* ===== LUXURY REDESIGNED REGISTER PAGE ===== */
.luxury-register-container {
    display: flex;
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05), 0 5px 15px rgba(0, 0, 0, 0.02);
    border: 1px solid #EBE5DB;
    min-height: 650px;
    margin: 40px 0;
    font-family: 'Inter', sans-serif;
    position: relative;
}

/* Left Visual panel */
.luxury-register-visual {
    width: 40%;
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
    max-width: 320px;
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
.luxury-register-form-side {
    width: 60%;
    background: #F8F6F0; /* Beige theme bg */
    padding: 50px 48px;
    display: flex;
    align-items: center;
    position: relative;
    overflow-y: auto;
    max-height: 800px;
}

/* Custom scrollbar for form panel */
.luxury-register-form-side::-webkit-scrollbar {
    width: 6px;
}
.luxury-register-form-side::-webkit-scrollbar-track {
    background: transparent;
}
.luxury-register-form-side::-webkit-scrollbar-thumb {
    background: #EBE5DB;
    border-radius: 4px;
}
.luxury-register-form-side::-webkit-scrollbar-thumb:hover {
    background: var(--primary-color);
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
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.7s ease-out;
}

.form-header {
    margin-bottom: 28px;
}

.form-header h2 {
    font-size: 26px;
    font-weight: 700;
    color: #332B23;
    margin-bottom: 6px;
    letter-spacing: -0.3px;
}

.form-header p {
    font-size: 14px;
    color: var(--primary-color);
    margin: 0;
}

/* Form inputs & grid layout */
.luxury-form {
    width: 100%;
}

.luxury-input-group {
    margin-bottom: 18px;
}

.luxury-input-group label {
    font-size: 13px;
    font-weight: 600;
    color: #332B23;
    margin-bottom: 6px;
    display: block;
}

.input-wrapper {
    position: relative;
}

.luxury-input-group .form-control {
    background: #ffffff !important;
    border: 1.5px solid #EBE5DB !important;
    border-radius: 12px !important;
    padding: 12px 16px 12px 40px !important;
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
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 4px rgba(140, 117, 88, 0.1) !important;
    background: #ffffff !important;
}

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    pointer-events: none;
    font-size: 16px;
}

/* Custom checkbox/toggle for merchant registration */
.custom-checkbox-wrapper {
    margin: 20px 0 10px;
}

.custom-merchant-toggle {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.custom-merchant-toggle input {
    display: none;
}

.toggle-switch {
    width: 44px;
    height: 24px;
    background: #EBE5DB;
    border-radius: 50px;
    position: relative;
    transition: background 0.3s ease;
    margin-right: 12px;
    flex-shrink: 0;
}

.toggle-switch::before {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #ffffff;
    top: 3px;
    left: 3px;
    transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.custom-merchant-toggle input:checked + .toggle-switch {
    background: var(--primary-color);
}

.custom-merchant-toggle input:checked + .toggle-switch::before {
    transform: translateX(20px);
}

.toggle-label {
    font-size: 14px;
    font-weight: 600;
    color: #332B23;
}

/* Store Name Sliding panel */
#store_name_container {
    transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    margin-bottom: 0;
}

#store_name_container.active {
    opacity: 1;
    max-height: 120px;
    margin-bottom: 18px;
}

.url-preview {
    font-size: 12px;
    color: var(--primary-color);
    margin-top: 6px;
    display: block;
}

#reg_store_preview {
    font-weight: 600;
    color: #332B23;
}

/* Submit Button */
.luxury-submit-btn {
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, var(--primary-color) 0%, rgba(0,0,0,0.15) 100%) !important;
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
    margin-top: 15px;
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

/* Login prompt */
.login-prompt {
    font-size: 14px;
    color: var(--primary-color);
    margin-top: 24px;
    margin-bottom: 0;
}

.login-link {
    color: #332B23;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.login-link:hover {
    color: var(--primary-color);
    text-decoration: underline;
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
    .luxury-register-container {
        flex-direction: column;
        min-height: auto;
    }
    
    .luxury-register-visual {
        width: 100%;
        height: 220px;
        padding: 40px;
    }
    
    .luxury-register-visual h3 {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    .brand-badge {
        margin-bottom: 16px;
    }
    
    .luxury-register-form-side {
        width: 100%;
        padding: 40px;
        max-height: none;
        overflow-y: visible;
    }
}

@media (max-width: 575px) {
    .luxury-register-visual {
        display: none; /* Hide visual on small screens */
    }
    
    .luxury-register-container {
        border-radius: 16px;
        border: none;
        box-shadow: none;
        background: transparent;
        margin: 20px 0;
    }
    
    .luxury-register-form-side {
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
        <div class="luxury-register-container">
          <!-- Left Visual Side -->
          <div class="luxury-register-visual" style="background-image: url('{{ asset('assets/img/62pSchastity-cortijo-M8iGdeTSOkg-unsplash.jpg') }}');">
            <div class="visual-overlay"></div>
            <div class="visual-content">
              <div class="brand-badge">{{ $setting->title }}</div>
              <h3>Begin Your Sleep Journey</h3>
              <p>Create an account to start configuring your custom beds, managing your shopping cart, and checking out seamlessly.</p>
            </div>
          </div>
          
          <!-- Right Form Side -->
          <div class="luxury-register-form-side">
            <!-- Background blobs for organic, premium feel -->
            <div class="bg-blob blob-1"></div>
            <div class="bg-blob blob-2"></div>
            
            <div class="form-wrapper">
              <div class="form-header">
                <h2>{{ __('Register') }}</h2>
                <p>{{ __('Please fill in the fields below to sign up') }}</p>
              </div>
              
              <form class="luxury-form" action="{{route('user.register.submit')}}" method="POST">
                @csrf
                <input type="text" name="honeypot" id="honeypot" value="" style="display:none;">

                <!-- First & Last Name Grid -->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group luxury-input-group">
                      <label for="reg-fn">{{__('First Name')}}*</label>
                      <div class="input-wrapper">
                        <input class="form-control" type="text" name="first_name" placeholder="{{__('First Name')}}" id="reg-fn" value="{{old('first_name')}}" required>
                        <span class="input-icon"><i class="icon-user"></i></span>
                      </div>
                      @error('first_name')
                        <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group luxury-input-group">
                      <label for="reg-ln">{{__('Last Name')}}*</label>
                      <div class="input-wrapper">
                        <input class="form-control" type="text" name="last_name" placeholder="{{__('Last Name')}}" id="reg-ln" value="{{old('last_name')}}" required>
                        <span class="input-icon"><i class="icon-user"></i></span>
                      </div>
                      @error('last_name')
                        <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                      @enderror
                    </div>
                  </div>
                </div>

                <!-- Email & Phone Grid -->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group luxury-input-group">
                      <label for="reg-email">{{__('E-mail Address')}}*</label>
                      <div class="input-wrapper">
                        <input class="form-control" type="email" name="email" placeholder="{{__('name@example.com')}}" id="reg-email" value="{{old('email')}}" required>
                        <span class="input-icon"><i class="icon-mail"></i></span>
                      </div>
                      @error('email')
                        <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group luxury-input-group">
                      <label for="reg-phone">{{__('Phone Number')}}*</label>
                      <div class="input-wrapper">
                        <input class="form-control" name="phone" type="text" placeholder="{{__('Phone Number')}}" id="reg-phone" value="{{old('phone')}}" required>
                        <span class="input-icon"><i class="icon-phone"></i></span>
                      </div>
                      @error('phone')
                        <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                      @enderror
                    </div>
                  </div>
                </div>

                <!-- Passwords Grid -->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group luxury-input-group">
                      <label for="reg-pass">{{__('Password')}}*</label>
                      <div class="input-wrapper">
                        <input class="form-control" type="password" name="password" placeholder="{{__('••••••••')}}" id="reg-pass" required>
                        <span class="input-icon"><i class="icon-lock"></i></span>
                      </div>
                      @error('password')
                        <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group luxury-input-group">
                      <label for="reg-pass-confirm">{{__('Confirm Password')}}*</label>
                      <div class="input-wrapper">
                        <input class="form-control" type="password" name="password_confirmation" placeholder="{{__('••••••••')}}" id="reg-pass-confirm" required>
                        <span class="input-icon"><i class="icon-lock"></i></span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Custom toggle for merchant registration -->
                <div class="custom-checkbox-wrapper">
                  <label class="custom-merchant-toggle" for="is_merchant">
                    <input type="checkbox" name="is_merchant" value="1" id="is_merchant" {{ old('is_merchant') ? 'checked' : '' }}>
                    <div class="toggle-switch"></div>
                    <span class="toggle-label">{{__('Register as a Merchant?')}}</span>
                  </label>
                </div>
                
                <!-- Store name block -->
                <div id="store_name_container" class="{{ old('is_merchant') ? 'active' : '' }}">
                  <div class="form-group luxury-input-group mb-0">
                    <label for="reg-store-name">{{__('Store Name (URL Slug)')}}</label>
                    <div class="input-wrapper">
                      <input class="form-control" type="text" name="store_name" placeholder="my-awesome-store" id="reg-store-name" value="{{old('store_name')}}">
                      <span class="input-icon"><i class="icon-pocket"></i></span>
                    </div>
                    <small class="url-preview">{{__('Your store link will be: ')}} {{url('/store')}}/<span id="reg_store_preview">my-awesome-store</span></small>
                    @error('store_name')
                      <p class="text-danger mt-1 font-size-sm">{{$message}}</p>
                    @enderror
                  </div>
                </div>

                <!-- Submit Button -->
                <button class="btn luxury-submit-btn" type="submit">
                  <span>{{__('Register')}}</span>
                </button>
              </form>

              <!-- Already registered link -->
              <p class="login-prompt text-center">
                {{ __("Already have an account ?") }} <a class="login-link" href="{{ route("user.login") }}">{{ __('Login now') }}</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
      // Toggle merchant store container
      document.getElementById('is_merchant')?.addEventListener('change', function(e) {
          const container = document.getElementById('store_name_container');
          const storeInput = document.getElementById('reg-store-name');
          if(e.target.checked) {
              container.classList.add('active');
              storeInput.setAttribute('required', 'required');
          } else {
              container.classList.remove('active');
              storeInput.removeAttribute('required');
          }
      });

      // Update URL slug preview dynamically
      document.getElementById('reg-store-name')?.addEventListener('input', function(e) {
          let val = e.target.value.toLowerCase().replace(/[^a-z0-9-]/g, '-');
          e.target.value = val;
          document.getElementById('reg_store_preview').innerText = val || 'my-awesome-store';
      });
  </script>
@endsection

