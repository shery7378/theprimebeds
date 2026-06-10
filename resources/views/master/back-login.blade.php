
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ $setting->title }} - Admin Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ url('assets/img/'.$setting->favicon) }}" type="image/x-icon"/>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<!-- Fonts and icons -->
	<script src="{{ asset('assets/back/js/plugin/webfont/webfont.min.js') }}"></script>
	<script id="setFont" data-src="{{ asset("assets/back/css/fonts.css") }}" src="{{ asset('assets/back/js/plugin/webfont/setfont.js') }}"></script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/back/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/back/css/azzara.min.css') }}">

	@if(DB::table('languages')->where('type', 'Dashboard')->where('is_default',1)->first()->rtl == 1)
    <link rel="stylesheet" href="{{ asset('assets/back/css/rtl.css') }}">
    @endif

	<style>
		/* ===== Admin Login – White Premium UI ===== */
		*, *::before, *::after {
			box-sizing: border-box;
		}

		body.login {
			margin: 0;
			padding: 0;
			min-height: 100vh;
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
			background: #ffffff;
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
			overflow: hidden;
		}

		/* Subtle decorative gradient blobs on white */
		body.login::before,
		body.login::after {
			content: '';
			position: fixed;
			border-radius: 50%;
			filter: blur(120px);
			opacity: 0.35;
			z-index: 0;
			pointer-events: none;
			animation: blobFloat 10s ease-in-out infinite alternate;
		}

		body.login::before {
			width: 500px;
			height: 500px;
			background: radial-gradient(circle, #dbeafe, #c7d2fe);
			top: -150px;
			right: -120px;
		}

		body.login::after {
			width: 450px;
			height: 450px;
			background: radial-gradient(circle, #fce7f3, #e9d5ff);
			bottom: -120px;
			left: -100px;
			animation-delay: -5s;
		}

		@keyframes blobFloat {
			0% { transform: translate(0, 0) scale(1); }
			100% { transform: translate(20px, -20px) scale(1.08); }
		}

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

		@keyframes pulseIcon {
			0%, 100% { box-shadow: 0 6px 20px rgba(99, 102, 241, 0.25); }
			50% { box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4); }
		}

		/* Login wrapper */
		.admin-login-wrapper {
			position: relative;
			z-index: 1;
			width: 100%;
			max-width: 440px;
			padding: 20px;
			animation: fadeInUp 0.7s ease-out;
		}

		/* Card */
		.admin-login-card {
			background: #ffffff;
			border: 1px solid #f1f5f9;
			border-radius: 24px;
			padding: 48px 40px;
			box-shadow:
				0 4px 6px -1px rgba(0, 0, 0, 0.04),
				0 10px 30px -5px rgba(0, 0, 0, 0.06),
				0 25px 60px -12px rgba(0, 0, 0, 0.06);
			position: relative;
		}

		/* Top accent line */
		.admin-login-card::before {
			content: '';
			position: absolute;
			top: 0;
			left: 50%;
			transform: translateX(-50%);
			width: 60%;
			height: 3px;
			background: linear-gradient(90deg, #818cf8, #6366f1, #4f46e5);
			border-radius: 0 0 4px 4px;
		}

		/* Brand section */
		.admin-login-brand {
			text-align: center;
			margin-bottom: 36px;
		}

		.admin-login-brand .brand-icon {
			width: 60px;
			height: 60px;
			background: linear-gradient(135deg, #6366f1, #4f46e5);
			border-radius: 16px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			margin-bottom: 18px;
			animation: pulseIcon 3s ease-in-out infinite;
		}

		.admin-login-brand .brand-icon svg {
			width: 28px;
			height: 28px;
			color: #fff;
		}

		.admin-login-brand h2 {
			color: #1e293b;
			font-size: 24px;
			font-weight: 700;
			margin: 0 0 6px;
			letter-spacing: -0.3px;
		}

		.admin-login-brand p {
			color: #94a3b8;
			font-size: 14px;
			margin: 0;
			font-weight: 400;
		}

		/* Form styles */
		.admin-login-form .form-group {
			margin-bottom: 20px;
			position: relative;
		}

		.admin-login-form label.field-label {
			display: block;
			color: #475569;
			font-size: 13px;
			font-weight: 600;
			margin-bottom: 7px;
			letter-spacing: 0.2px;
		}

		.admin-login-form .form-control {
			background: #f8fafc;
			border: 1.5px solid #e2e8f0;
			border-radius: 12px;
			padding: 13px 16px;
			font-size: 15px;
			color: #1e293b;
			transition: all 0.25s ease;
			width: 100%;
			font-family: 'Inter', sans-serif;
			height: auto;
		}

		.admin-login-form .form-control::placeholder {
			color: #cbd5e1;
		}

		.admin-login-form .form-control:focus {
			outline: none;
			background: #fff;
			border-color: #818cf8;
			box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
		}

		/* Password field */
		.password-field-wrapper {
			position: relative;
		}

		.password-toggle {
			position: absolute;
			right: 14px;
			top: 50%;
			transform: translateY(-50%);
			background: none;
			border: none;
			color: #94a3b8;
			cursor: pointer;
			padding: 4px;
			display: flex;
			align-items: center;
			transition: color 0.2s;
		}

		.password-toggle:hover {
			color: #6366f1;
		}

		/* Forgot password link */
		.forgot-link {
			text-align: right;
			margin-bottom: 26px;
		}

		.forgot-link a {
			color: #6366f1;
			font-size: 13px;
			font-weight: 500;
			text-decoration: none;
			transition: color 0.2s;
		}

		.forgot-link a:hover {
			color: #4338ca;
			text-decoration: underline;
		}

		/* Submit button */
		.admin-login-btn {
			width: 100%;
			padding: 14px 24px;
			background: linear-gradient(135deg, #6366f1, #4f46e5);
			border: none;
			border-radius: 12px;
			color: #fff;
			font-size: 15px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			position: relative;
			overflow: hidden;
			font-family: 'Inter', sans-serif;
			letter-spacing: 0.3px;
		}

		.admin-login-btn::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 200%;
			height: 100%;
			background: linear-gradient(
				90deg,
				transparent,
				rgba(255, 255, 255, 0.2),
				transparent
			);
			transition: left 0.5s;
		}

		.admin-login-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
		}

		.admin-login-btn:hover::before {
			left: 100%;
		}

		.admin-login-btn:active {
			transform: translateY(0);
			box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
		}

		/* Alert overrides */
		.admin-login-alerts .alert {
			background: #fef2f2;
			border: 1px solid #fecaca;
			border-radius: 12px;
			color: #dc2626;
			font-size: 13px;
			padding: 12px 16px;
			margin-bottom: 18px;
		}

		.admin-login-alerts .alert-success {
			background: #f0fdf4;
			border-color: #bbf7d0;
			color: #16a34a;
		}

		/* Footer */
		.admin-login-footer {
			text-align: center;
			margin-top: 24px;
			color: #cbd5e1;
			font-size: 12px;
		}

		/* Responsive */
		@media (max-width: 480px) {
			.admin-login-card {
				padding: 36px 24px;
				border-radius: 20px;
			}

			.admin-login-brand h2 {
				font-size: 20px;
			}
		}
	</style>
</head>

<body class="login">

	@yield('content')

    @php
        $mainbs = [];
        $mainbs['is_announcement'] = $setting->is_announcement;
        $mainbs['announcement_delay'] = $setting->announcement_delay;
        $mainbs['overlay'] = $setting->overlay;
        $mainbs = json_encode($mainbs);
    @endphp

	<script src="{{ asset('assets/back/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('assets/back/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/back/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/back/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/back/js/ready.min.js') }}"></script>

	<script>
		// Password visibility toggle
		document.addEventListener('DOMContentLoaded', function() {
			const toggleBtn = document.querySelector('.password-toggle');
			if (toggleBtn) {
				toggleBtn.addEventListener('click', function() {
					const input = document.getElementById('password');
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
</body>
</html>
