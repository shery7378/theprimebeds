@extends('master.back-login')

@section('content')

    <div class="admin-login-wrapper">
        <div class="admin-login-card">

            <!-- Brand Section -->
            <div class="admin-login-brand">
                <div class="brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <h2>{{ __('Welcome Back') }}</h2>
                <p>{{ __('Sign in to your admin dashboard') }}</p>
            </div>

            <!-- Alerts -->
            <div class="admin-login-alerts">
                @include('alerts.alerts')
            </div>

            <!-- Login Form -->
            <form action="{{ route('back.login.submit') }}" method="POST" class="admin-login-form">
                @csrf

                <div class="form-group">
                    <label for="username" class="field-label">{{ __('Email Address') }}</label>
                    <input
                        id="username"
                        name="login_email"
                        type="email"
                        class="form-control"
                        placeholder="{{ __('Enter your email') }}"
                        value="{{ old('login_email') }}"
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="field-label">{{ __('Password') }}</label>
                    <div class="password-field-wrapper">
                        <input
                            id="password"
                            name="login_password"
                            type="password"
                            class="form-control"
                            placeholder="{{ __('Enter your password') }}"
                            autocomplete="current-password"
                            style="padding-right: 44px;"
                        >
                        <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                            <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

               

                <button type="submit" class="admin-login-btn">
                    {{ __('Sign In') }}
                </button>
            </form>
        </div>
    </div>

@endsection
