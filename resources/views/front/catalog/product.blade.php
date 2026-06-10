@extends('master.front')

@section('styleplugins')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --primary-color: #667eea;
        --secondary-color: #764ba2;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 20px;
    }

    /* Modern Breadcrumb */
    .breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 16px 0;
        margin: 0;
        list-style: none;
    }

    .breadcrumbs li {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .breadcrumbs a {
        color: var(--gray-600);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumbs a:hover {
        color: var(--primary-color);
    }

    .breadcrumbs .separator::before {
        content: '›';
        color: var(--gray-400);
        margin: 0 4px;
        font-size: 18px;
    }

    /* Product Gallery Enhancements */
    .product-gallery {
        position: relative;
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .product-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 5;
        box-shadow: var(--shadow-md);
    }

    .ppp-t {
        top: 60px !important;
    }

    .customize-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--primary-gradient);
        color: white;
        padding: 8px 16px;
        border-radius: var(--radius-xl);
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 6px;
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .custom-video-wrapper {
        position: absolute;
        right: 20px;
        top: 20px;
        z-index: 10;
    }

    .video-button {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .video-button:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-xl);
    }

    .video-button .play-icon {
        width: 50px;
        height: 50px;
    }

    .video-button:hover .play-icon circle {
        fill: var(--primary-color);
    }

    /* Product Details Section */
    .details-page-top-right-content {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-md);
    }

    .p-title-main {
        font-size: 2.5rem !important;
        font-weight: 800 !important;
        line-height: 1.2 !important;
        letter-spacing: -1px !important;
        color: var(--gray-900) !important;
        margin-bottom: 20px !important;
    }

    @media (max-width: 768px) {
        .p-title-main {
            font-size: 1.8rem !important;
        }
    }

    .price-area {
        background: var(--gray-50);
        padding: 20px;
        border-radius: var(--radius-md);
        border-left: 4px solid var(--primary-color);
        margin-bottom: 24px !important;
    }

    .main-price {
        font-size: 2.5rem !important;
        font-weight: 800 !important;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Attributes Dropdown */
    .form-group label {
        font-weight: 600;
        font-size: 15px;
        color: var(--gray-700);
        margin-bottom: 8px;
        display: block;
    }

    .attribute_option {
        width: 100%;
        padding: 14px 18px;
        border-radius: var(--radius-md);
        border: 2px solid var(--gray-200);
        background: white;
        font-size: 15px;
        color: var(--gray-700);
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 20px;
        padding-right: 40px;
    }

    .attribute_option:hover {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .attribute_option:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
    }

    .attribute_option.is-invalid {
        border-color: var(--danger-color) !important;
        background-color: #fef2f2;
    }

    /* Quantity Selector */
    .qtySelector {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        padding: 6px;
        border-radius: var(--radius-xl);
        border: 2px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }

    .qtySelector span {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        user-select: none;
    }

    .qtySelector span:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }

    .qtyValue {
        width: 60px;
        text-align: center;
        font-weight: 700;
        font-size: 1.2rem;
        border: none;
        background: transparent;
        outline: none;
    }

    /* Customize Button */
    .btn-customize-bed {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 18px 32px;
        font-size: 18px;
        font-weight: 700;
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
    }

    .btn-customize-bed:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-customize-bed::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 100%);
        transition: left 0.5s ease;
    }

    .btn-customize-bed:hover::before {
        left: 100%;
    }

    .customize-info {
        font-size: 13px;
        color: var(--gray-600);
        margin-top: 10px;
        text-align: center;
    }

    /* Action Buttons */
    .p-action-button {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .p-action-button .btn {
        flex: 1;
        min-width: 160px;
        padding: 14px 24px;
        font-size: 16px;
        font-weight: 600;
        border-radius: var(--radius-md);
        border-width: 2px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .p-action-button .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: white;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
    }

    /* Discount Button */
    .btn-warning {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border: none;
        color: var(--gray-900);
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
    }

    @keyframes pulse-branding {
        0% { transform: scale(1); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 8px 20px rgba(245, 158, 11, 0.5); }
        100% { transform: scale(1); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    }

    .pulse-animation {
        animation: pulse-branding 2s infinite;
    }

    /* Discount Modal */
    .modal-content {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: var(--shadow-xl);
    }

    .modal-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 20px 30px;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 30px;
    }

    .discount-card {
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        min-width: 140px;
    }

    .discount-card:hover {
        background: var(--gray-50);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .discount-card.selected {
        background: #eff6ff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }

    /* Product Variations Card */
    .card {
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--gray-900);
    }

    .badge {
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 13px;
    }

    /* Preferences Textarea */
    #preferences {
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 14px;
        font-size: 15px;
        transition: all 0.3s ease;
        resize: none;
    }

    #preferences:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    @media (max-width: 767px) {
        #preferences {
            height: 140px !important;
        }
    }

    @media (min-width: 768px) {
        #preferences {
            height: 100px !important;
        }
    }

    /* File Upload Section */
    .form-label {
        font-weight: 600;
        font-size: 15px;
        color: var(--gray-700);
    }

    #sample_images {
        padding: 12px;
        border: 2px dashed var(--gray-300);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--gray-50);
    }

    #sample_images:hover {
        border-color: var(--primary-color);
        background: white;
    }

    /* Progress Bar */
    .progress {
        height: 20px;
        border-radius: var(--radius-md);
        background: var(--gray-100);
        overflow: hidden;
    }

    /* ===== ENHANCED UI IMPROVEMENTS ===== */

    /* Page Container */
    .container.padding-bottom-1x {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
        padding-top: 50px !important;
        padding-bottom: 50px !important;
        border-radius: 0;
    }

    /* Main Layout Grid */
    .row > [class*="col-"] {
        margin-bottom: 0;
    }

    /* Product Gallery Enhancement */
    .product-gallery {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        transition: all 0.3s ease;
    }

    .product-gallery:hover {
        box-shadow: var(--shadow-lg);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .product-thumbnails.insize {
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .product-thumbnails.insize .item img {
        transition: transform 0.3s ease;
    }

    .product-thumbnails.insize .item img:hover {
        transform: scale(1.05);
    }

    /* Details Right Content Card */
    .details-page-top-right-content {
        background: linear-gradient(135deg, #ffffff 0%, #fafbff 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        position: sticky;
        top: 20px;
    }

    /* Product Title Styling */
    .p-title-main {
        position: relative;
        padding-bottom: 15px;
    }

    .p-title-main::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* Price Area Enhancement */
    .price-area {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        border: 1px solid rgba(102, 126, 234, 0.15);
        position: relative;
        overflow: hidden;
    }

    .price-area::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .price-area > * {
        position: relative;
        z-index: 1;
    }

    /* Quantity Selector Enhancement */
    .qtySelector {
        background: linear-gradient(135deg, #ffffff 0%, #f9f9ff 100%);
        border: 2px solid rgba(102, 126, 234, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .qtySelector span {
        background: var(--gray-100);
        font-weight: 600;
        color: var(--gray-700);
    }

    /* Attribute Dropdown Enhancement */
    .form-group {
        position: relative;
    }

    .attribute_option {
        background: white url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") no-repeat right 12px center / 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Customize Button Enhancement */
    .btn-customize-bed {
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.35);
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .btn-customize-bed:active {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.25);
    }

    /* Action Buttons Row */
    .p-action-button {
        gap: 10px;
    }

    .p-action-button .btn {
        font-weight: 600;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .p-action-button .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .p-action-button .btn:active::after {
        width: 300px;
        height: 300px;
    }

    /* Product Meta Section */
    .t-c-b-area {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
    }

    .t-c-b-area > div {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 12px 0;
    }

    .t-c-b-area > div:last-child {
        border-bottom: none;
    }

    .t-c-b-area a {
        color: var(--primary-color);
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
    }

    .t-c-b-area a:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    /* Tabs Enhancement */
    .nav-tabs {
        border-bottom: 2px solid var(--gray-200);
        gap: 5px;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .nav-tabs .nav-link {
        color: var(--gray-600);
        border: none;
        font-weight: 600;
        font-size: 15px;
        padding: 16px 24px;
        position: relative;
        transition: all 0.3s ease;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background: var(--gray-50);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background: white;
        border: none;
    }

    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-gradient);
        border-radius: 2px 2px 0 0;
    }

    .tab-content {
        background: white;
        padding: 40px;
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        border: 1px solid var(--gray-200);
        border-top: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Product Variations Card */
    .card {
        border: 1px solid rgba(102, 126, 234, 0.1);
        background: linear-gradient(135deg, #ffffff 0%, #f9f9ff 100%);
    }

    .card-body {
        padding: 28px;
    }

    .card-title {
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 24px;
    }

    .card-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* Badges Enhancement */
    .badge {
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 8px 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
    }

    /* Form Controls */
    .form-control {
        border: 2px solid var(--gray-200);
        padding: 12px 16px;
        font-size: 15px;
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: var(--gray-400);
    }

    /* Input File Upload */
    input[type="file"] {
        cursor: pointer;
    }

    /* Related Products Section */
    .relatedproduct-section {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
        padding-top: 60px !important;
        padding-bottom: 60px !important;
        border-radius: var(--radius-lg);
    }

    .relatedproduct-section .section-title h2 {
        position: relative;
        padding-bottom: 20px;
    }

    .relatedproduct-section .section-title h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    .product-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid var(--gray-100);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .product-thumb {
        overflow: hidden;
        background: var(--gray-50);
        aspect-ratio: 1;
    }

    .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-thumb img {
        transform: scale(1.1);
    }

    .product-card-body {
        padding: 20px;
    }

    .product-category {
        font-size: 12px;
        color: var(--primary-color);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .product-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 12px;
        min-height: 35px;
    }

    .product-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }

    .product-title a:hover {
        color: var(--primary-color);
    }

    .product-price {
        font-size: 16px;
        color: var(--gray-900);
        font-weight: 700;
        margin-bottom: 0;
    }

    .product-price del {
        color: var(--gray-400);
        font-weight: 400;
        font-size: 14px;
    }

    /* Modal Enhancement */
    .modal-dialog {
        border-radius: var(--radius-xl);
    }

    .modal-content {
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .modal-header {
        border-bottom: none;
        padding: 30px;
    }

    .modal-body {
        padding: 30px;
    }

    .offer-card {
        cursor: pointer;
        outline: none;
        border: none;
        display: inline-flex;
        flex-direction: column;
        user-select: none;
        -webkit-user-select: none;
    }

    .offer-card input:checked + .discount-card {
        background: #eff6ff;
        border-color: var(--primary-color);
        transform: scale(1.02);
    }

    /* Alert Styling */
    .alert {
        border-radius: var(--radius-md);
        border: none;
        font-weight: 500;
    }

    .alert-info {
        background: rgba(6, 182, 212, 0.1);
        color: #0891b2;
    }

    /* Discount Discount Text */
    .ppp-t {
        animation: bounceAlert 1s infinite;
    }

    @keyframes bounceAlert {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Smooth Transitions */
    * {
        transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }

    button, a, input, select, textarea {
        transition: all 0.3s ease;
    }

    /* Responsive Improvements */
    @media (max-width: 768px) {
        .details-page-top-right-content {
            position: static;
        }

        .tab-content {
            padding: 20px;
        }

        .p-title-main {
            font-size: 1.8rem !important;
        }

        .nav-tabs .nav-link {
            padding: 12px 16px;
            font-size: 13px;
        }

        .card-body {
            padding: 16px;
        }

        .product-card-body {
            padding: 15px;
        }

        .relatedproduct-section {
            padding-top: 40px !important;
            padding-bottom: 40px !important;
        }
    }

    @media (max-width: 480px) {
        .p-action-button {
            flex-direction: column;
        }

        .p-action-button .btn {
            width: 100%;
        }

        .q-select {
            width: 100%;
        }

        .nav-tabs {
            gap: 0;
        }

        .nav-tabs .nav-link {
            padding: 12px;
            font-size: 12px;
        }
    }

    .progress-bar {
        background: var(--primary-gradient);
        font-weight: 600;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: width 0.3s ease;
    }

    /* Tabs */
    .nav-tabs {
        border-bottom: 2px solid var(--gray-200);
        gap: 8px;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: var(--gray-600);
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        background: var(--gray-50);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background: white;
    }

    .tab-content {
        padding: 30px;
        border-radius: 0 var(--radius-lg) var(--radius-lg) var(--radius-lg);
        box-shadow: var(--shadow-md);
    }

    /* Category Links */
    .t-c-b-area a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }

    .t-c-b-area a:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    /* Related Products */
    .product-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .product-thumb {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1;
    }

    .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-thumb img {
        transform: scale(1.1);
    }

    .product-card-body {
        padding: 20px;
    }

    .product-title a {
        color: var(--gray-900);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .product-title a:hover {
        color: var(--primary-color);
    }

    .product-price {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--primary-color);
        margin-top: 10px;
    }

    .product-price del {
        color: var(--gray-400);
        font-size: 0.9rem;
        margin-right: 8px;
    }

    /* Alert */
    .alert-info {
        background: #dbeafe;
        border: 2px solid #3b82f6;
        color: #1e40af;
        border-radius: var(--radius-md);
        padding: 14px 18px;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .details-page-top-right-content {
            padding: 20px;
        }

        .p-action-button .btn {
            min-width: 100%;
        }

        .qtySelector {
            width: 100%;
            justify-content: space-between;
        }
    }

    /* Loading Animation */
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    /* Section Title */
    .section-title h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 24px;
        position: relative;
        padding-bottom: 12px;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* Comparison Table */
    .comparison-table {
        overflow-x: auto;
    }

    .comparison-table table {
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .comparison-table th {
        background: var(--gray-100);
        font-weight: 600;
        color: var(--gray-900);
    }

    .comparison-table td {
        color: var(--gray-700);
    }
</style>
@endsection

@section('title')
    {{ $item->name }}
@endsection

@section('meta')
    <meta name="tile" content="{{ $item->title }}">
    <meta name="keywords" content="{{ $item->meta_keywords }}">
    <meta name="description" content="{{ $item->meta_description }}">

    <meta name="twitter:title" content="{{ $item->title }}">
    <meta name="twitter:image" content="{{ url('assets/img/' . $item->photo) }}">
    <meta name="twitter:description" content="{{ $item->meta_description }}">

    <meta name="og:title" content="{{ $item->title }}">
    <meta name="og:image" content="{{ url('assets/img/' . $item->photo) }}">
    <meta name="og:description" content="{{ $item->meta_description }}">
@endsection

@section('content')
    <script>
        window.bundleDiscount = @json($item->bundle_discount);
    </script>
    <div class="page-title" style="background: var(--gray-50); padding: 20px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumbs">
                        <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                        <li class="separator"></li>
                        <li><a href="{{ route('front.catalog') }}">{{ __('Shop') }}</a></li>
                        <li class="separator"></li>
                        <li style="color: var(--gray-900); font-weight: 600;">{{ $item->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container padding-bottom-1x mb-1" style="padding-top: 40px;">
        <!-- Breadcrumbs -->
        <div style="margin-bottom: 30px;">
            <ol class="breadcrumbs">
                <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                <li class="separator"></li>
                <li><a href="{{ route('front.catalog') }}">{{ __('Products') }}</a></li>
                <li class="separator"></li>
                <li style="color: var(--gray-700); font-weight: 600;">{{ $item->name }}</li>
            </ol>
        </div>

        <div class="row">
            <!-- Product Gallery-->
            <div class="col-xxl-5 col-lg-6 col-md-6 mb-4">
                <div class="product-gallery">
                    @if ($item->video)
                        <div class="custom-video-wrapper">
                            <div class="video-button">
                                <a href="{{ $item->video }}" title="Watch video" data-type="video">
                                    <svg class="play-icon" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                        viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="12" fill="#fff" />
                                        <polygon points="10,8 16,12 10,16" fill="#667eea" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Customizable Badge --}}
                    @php
                        $hasCustomizers = method_exists($item, 'hasBedCustomizers') && $item->hasBedCustomizers();
                    @endphp
                    @if($hasCustomizers)
                    <div class="customize-badge">
                        <i class="fas fa-cog"></i>
                        <span>{{ __('Customizable') }}</span>
                    </div>
                    @endif

                    @if ($item->is_stock())
                        <span class="product-badge @if ($item->is_type == 'feature') bg-warning
                            @elseif($item->is_type == 'new') bg-success
                            @elseif($item->is_type == 'top') bg-info
                            @elseif($item->is_type == 'best') bg-dark
                            @elseif($item->is_type == 'flash_deal') bg-success @endif">
                            {{ __($item->is_type != 'undefine' ? ucfirst(str_replace('_', ' ', $item->is_type)) : '') }}
                        </span>
                    @else
                        <span class="product-badge bg-secondary border-default text-body">{{ __('out of stock') }}</span>
                    @endif

                    @if ($item->previous_price && $item->previous_price != 0)
                        <div class="product-badge bg-danger ppp-t" style="background: var(--danger-color) !important;">
                            -{{ PriceHelper::DiscountPercentage($item) }}
                        </div>
                    @endif

                    @php $imageIndex = 0; @endphp
                    <div class="product-thumbnails insize">
                        <div class="product-details-slider owl-carousel" id="product-gallery">
                            <div class="item">
                                <img src="{{ url('assets/img/' . $item->photo) }}" alt="zoom" data-index="{{ $imageIndex++ }}" style="border-radius: var(--radius-md);" />
                            </div>
                            @foreach ($galleries as $key => $gallery)
                                <div class="item">
                                    <img src="{{ url('assets/img/' . $gallery->photo) }}" alt="zoom" data-index="{{ $imageIndex++ }}" style="border-radius: var(--radius-md);" />
                                </div>
                            @endforeach
                            {{-- Add attribute option images --}}
                            @foreach (($attributes ?? collect()) as $attribute)
                                @foreach (($attribute->options ?? collect()) as $option)
                                    @php
                                        $images = json_decode($option->variation_images, true) ?? [];
                                    @endphp
                                    @foreach (($images ?? []) as $img)
                                        @if (!empty($img))
                                            <div class="item">
                                                <img src="{{ url('assets/img/' . $img) }}" alt="zoom"
                                                    data-option-id="{{ $option->id }}"
                                                    data-attribute-id="{{ $attribute->id }}"
                                                    data-index="{{ $imageIndex++ }}" style="border-radius: var(--radius-md);" />
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Product Variations --}}
                <div class="card my-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Product Variations</h5>

                        @if (!empty($item->variations['customization_level']))
                            <div class="mb-4">
                                <strong>Customisation Level:</strong>
                                <span class="badge bg-info text-dark ms-2">
                                    {{ ucfirst(str_replace('_', ' ', $item->variations['customization_level'])) }}
                                </span>
                            </div>

                            @if (in_array($item->variations['customization_level'], ['customizable', 'partial_customizable']))
                                <h6 class="mb-3 fw-semibold">Add Customisation Preferences</h6>

                                <div class="form-group mb-3">
                                    <label for="preferences">Describe your preferences</label>
                                    <textarea name="preferences" id="preferences" rows="4" class="form-control" placeholder="Add notes about text placement, design ideas, or layout...">{{ old('preferences') }}</textarea>
                                </div>

                                @if ($item->variations['customization_level'] !== 'partial_customizable')
                                    <div class="card p-3 mb-3" style="background: var(--gray-50);">
                                        <div class="form-group">
                                            <label for="sample_images" class="form-label fw-semibold mb-2">
                                                Upload Reference or Sample Images
                                            </label>
                                            <input type="file" name="sample_images[]" id="sample_images" class="w-100" multiple>
                                            <div id="preview-area" class="mt-3"></div>
                                            <div id="shared-progress-wrapper" class="progress mt-3" style="display: none;">
                                                <div id="shared-progress-bar" class="progress-bar" style="width: 0%;" role="progressbar">0%</div>
                                            </div>
                                            <small class="text-muted d-block mt-2">
                                                You can upload multiple images (JPEG, PNG, etc.)
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif

                        @if (!empty($item->variations['custom_text']))
                            <div class="mb-1">
                                <strong>Important Note:</strong>
                                <span class="ms-2 text-muted">{{ $item->variations['custom_text'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Info-->
            <div class="col-xxl-7 col-lg-6 col-md-6">
                <div class="details-page-top-right-content">
                    <input type="hidden" id="item_id" value="{{ $item->id }}">
                    <input type="hidden" id="demo_price" value="{{ PriceHelper::setConvertPrice($item->discount_price) }}">
                    <input type="hidden" value="{{ PriceHelper::setCurrencySign() }}" id="set_currency">
                    <input type="hidden" value="{{ PriceHelper::setCurrencyValue() }}" id="set_currency_val">
                    <input type="hidden" value="{{ $setting->currency_direction }}" id="currency_direction">

                    <h1 class="p-title-main">{{ $item->name }}</h1>

                    @if ($item->is_type == 'flash_deal')
                        @if (date('d-m-y') != \Carbon\Carbon::parse($item->date)->format('d-m-y'))
                            <div class="countdown countdown-alt mb-4" data-date-time="{{ $item->date }}" style="background: var(--gray-50); padding: 15px; border-radius: var(--radius-md);"></div>
                        @endif
                    @endif

                    <div class="price-area">
                        @if ($item->previous_price != 0)
                            <small class="d-inline-block text-muted me-3" style="font-size: 1.2rem; text-decoration: line-through;">
                                <del>{{ PriceHelper::setPreviousPrice($item->previous_price) }}</del>
                            </small>
                        @endif
                        <span id="main_price" class="main-price" data-price="{{ PriceHelper::grandCurrencyPrice($item) }}">
                            {{ PriceHelper::grandCurrencyPrice($item) }}
                        </span>
                        <div id="discount_info" class="text-success mt-2" style="display:none; font-size:0.9rem;"></div>
                    </div>

                    <p class="text-muted mb-4" style="font-size: 16px; line-height: 1.6;">
                        {{ $item->sort_details }}
                        <a href="#details" class="scroll-to" style="color: var(--primary-color); font-weight: 600;">{{ __('Read more') }}</a>
                    </p>

                    {{-- Attributes --}}
                    <div class="row margin-top-1x mb-4">
                        @foreach (($attributes ?? collect()) as $attribute)
                            @if (($attribute->options ?? collect())->count() != 0)
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label for="{{ $attribute->name }}">{{ $attribute->name }}</label>
                                        <select class="form-control attribute_option" id="{{ $attribute->name }}">
                                            <option value="">Select {{ $attribute->name }}</option>
                                            @foreach (($attribute->options ?? collect())->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE) as $option)
                                                @php
                                                    $stockRaw = $option->stock ?? '';
                                                    $isNumericZero = is_numeric($stockRaw) && (int) $stockRaw === 0;
                                                    $isOut = $isNumericZero || trim((string) $stockRaw) === '0';
                                                    $images = json_decode($option->variation_images, true) ?: [];
                                                @endphp
                                                <option value="{{ $option->name }}"
                                                    data-type="{{ $attribute->id }}"
                                                    data-href="{{ $option->id }}"
                                                    data-images='@json($images)'
                                                    data-target="{{ PriceHelper::setConvertPrice($option->price) }}"
                                                    @if ($isOut) disabled style="color:#b00020;font-weight:600;background:#ffe5e5;" @endif>
                                                    {{ $option->name }} @if ($isOut) — Out of stock @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Quantity & Actions --}}
                    <div class="row align-items-end pb-4">
                        <div class="col-sm-12">
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                <div class="qtySelector product-quantity">
                                    <span class="decreaseQty subclick"><i class="fas fa-minus"></i></span>
                                    <input type="text" class="qtyValue cart-amount" value="1">
                                    <span class="increaseQty addclick"><i class="fas fa-plus"></i></span>
                                    <input type="hidden" value="{{ is_numeric($item->stock) ? (int)$item->stock : 9999 }}" id="current_stock">
                                </div>

                                <div id="total_container" class="w-100 mb-3 text-end">
                                    <button id="total_price_btn" class="btn btn-outline-secondary">
                                        {{ __('Total:') }} <span id="computed_total">{{ PriceHelper::grandCurrencyPrice($item) }}</span>
                                    </button>
                                </div>

                                {{-- Customize Button if product has customizers --}}
                                @if($hasCustomizers)
                                <div class="w-100">
                                    <a href="{{ route('front.bed.customize', $item->slug) }}" class="btn btn-customize-bed w-100">
                                        <i class="fas fa-cog me-2"></i>
                                        <span>{{ __('Customize This Bed') }}</span>
                                    </a>
                                    <small class="customize-info">
                                        <i class="fas fa-info-circle me-1"></i>
                                        {{ __('Customize size, fabric, headboard, mattress and more') }}
                                    </small>
                                </div>
                                @endif

                                <div class="p-action-button w-100">
                                    @if ($item->item_type != 'affiliate')
                                        @if ($item->is_stock())
                                            @if(!$hasCustomizers)
                                                <button class="btn btn-outline-primary" id="add_to_cart">
                                                    <i class="icon-bag me-2"></i><span>{{ __('Add to Cart') }}</span>
                                                </button>
                                                <button class="btn btn-primary" id="but_to_cart">
                                                    <i class="icon-bag me-2"></i><span>{{ __('Buy Now') }}</span>
                                                </button>
                                            @else
                                                <div class="alert alert-info w-100 mb-0">
                                                    <i class="fas fa-arrow-up me-2"></i>{{ __('Click "Customize This Bed" above to select your options and add to cart') }}
                                                </div>
                                            @endif
                                        @else
                                            <button class="btn btn-secondary disabled">
                                                <i class="icon-bag me-2"></i><span>{{ __('Out of stock') }}</span>
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ $item->affiliate_link }}" target="_blank" class="btn btn-primary">
                                            <i class="icon-bag me-2"></i>{{ __('Buy Now') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Discount Offer --}}
                            <div class="p-action-discount mt-3">
                                @if (isset($item->bundle_discount) && !empty($item->bundle_discount))
                                    @php
                                        $discountItems  = $item->bundle_discount['discount_items']     ?? [];
                                        $discountPrices = $item->bundle_discount['discountItems_price'] ?? [];
                                    @endphp

                                    @if(count($discountItems) > 0)
                                        <button class="btn btn-warning w-100 pulse-animation" id="avail_discount" data-bs-toggle="modal" data-bs-target="#discountModal">
                                            <i class="fas fa-gift me-2"></i>
                                            <span>{{ __('First Time Offer') }}</span>
                                        </button>

                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Product Meta --}}
                    <div class="t-c-b-area" style="background: var(--gray-50); padding: 20px; border-radius: var(--radius-md); margin-top: 20px;">
                        @if ($item->brand_id)
                            <div class="mb-2">
                                <span class="text-medium fw-semibold">{{ __('Brand') }}:</span>
                                <a href="{{ route('front.catalog') . '?brand=' . $item->brand->slug }}">{{ $item->brand->name }}</a>
                            </div>
                        @endif

                        <div class="mb-2">
                            <span class="text-medium fw-semibold">{{ __('Categories') }}:</span>
                            <a href="{{ route('front.catalog') . '?category=' . $item->category->slug }}">{{ $item->category->name }}</a>
                            @if ($item->subcategory->name) / @endif
                            <a href="{{ route('front.catalog') . '?subcategory=' . $item->subcategory->slug }}">{{ $item->subcategory->name }}</a>
                            @if ($item->childcategory->name) / @endif
                            <a href="{{ route('front.catalog') . '?childcategory=' . $item->childcategory->slug }}">{{ $item->childcategory->name }}</a>
                        </div>

                        <div class="mb-2">
                            <span class="text-medium fw-semibold">{{ __('Tags') }}:</span>
                            @if ($item->tags)
                                @foreach (explode(',', $item->tags) as $tag)
                                    @if ($loop->last)
                                        <a href="{{ route('front.catalog') . '?tag=' . $tag }}">{{ $tag }}</a>
                                    @else
                                        <a href="{{ route('front.catalog') . '?tag=' . $tag }}">{{ $tag }}</a>,
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        @if ($item->item_type == 'normal')
                            <div>
                                <span class="text-medium fw-semibold">{{ __('SKU') }}:</span> #{{ $item->sku }}
                            </div>
                        @endif
                    </div>


                </div>
            </div>

            {{-- Description & Specifications --}}
            <div class="padding-top-3x mb-3 w-100" id="details" style="margin-top: 60px;">
                <div class="col-lg-12">
                    <div style="margin-bottom: 30px;">
                        <h3 style="font-size: 1.8rem; font-weight: 700; color: var(--gray-900); position: relative; padding-bottom: 20px;">
                            {{ __('Product Details') }}
                            <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 4px; background: var(--primary-gradient); border-radius: 2px;"></span>
                        </h3>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                {{ __('Descriptions') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button" role="tab">
                                {{ __('Specifications') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            {!! $item->details !!}
                        </div>
                        <div class="tab-pane fade" id="specification" role="tabpanel">
                            <div class="comparison-table">
                                <table class="table table-bordered" style="margin-bottom: 0;">
                                    <tbody>
                                        <tr style="background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%); font-weight: 700;">
                                            <th class="text-uppercase" style="font-weight: 700; padding: 16px; color: var(--gray-900);">{{ __('Specifications') }}</th>
                                            <td style="padding: 16px;"><span class="text-medium" style="font-weight: 600;">{{ __('Descriptions') }}</span></td>
                                        </tr>
                                        @if ($sec_name)
                                            @foreach (array_combine($sec_name, $sec_details) as $sname => $sdetail)
                                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                                    <th style="background: var(--gray-50); font-weight: 600; padding: 14px; color: var(--gray-900); width: 30%;">{{ $sname }}</th>
                                                    <td style="padding: 14px; color: var(--gray-700);">{{ $sdetail }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="2">{{ __('No Specifications') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if (count($related_items) > 0)
        <div class="relatedproduct-section container padding-bottom-3x mb-1" style="padding-top: 60px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title" style="margin-bottom: 40px;">
                        <h2 class="h3" style="font-size: 1.8rem; font-weight: 700; color: var(--gray-900); position: relative; padding-bottom: 20px;">
                            {{ __('You May Also Like') }}
                            <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 4px; background: var(--primary-gradient); border-radius: 2px;"></span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="relatedproductslider owl-carousel">
                        @foreach ($related_items as $related)
                            <div class="slider-item">
                                <div class="product-card">
                                    @if ($related->is_stock())
                                        @if ($related->is_type != 'new')
                                            <div class="product-badge @if ($related->is_type == 'feature') bg-warning
                                                @elseif($related->is_type == 'top') bg-info
                                                @elseif($related->is_type == 'best') bg-dark
                                                @elseif($related->is_type == 'flash_deal') bg-success @endif">
                                                {{ $related->is_type != 'undefine' ? ucfirst(str_replace('_', ' ', $related->is_type)) : '' }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="product-badge bg-secondary">{{ __('out of stock') }}</div>
                                    @endif

                                    @php $relDiscPct = PriceHelper::DiscountPercentage($related); @endphp
                                    @if($relDiscPct)
                                        <div class="product-badge product-badge2 bg-danger" style="top: 60px; background: var(--danger-color) !important;">
                                            -{{ $relDiscPct }}
                                        </div>
                                    @endif

                                    <div class="product-thumb">
                                        <img class="lazy" data-src="{{ url('assets/img/' . $related->thumbnail) }}" alt="Product">
                                    </div>

                                    <div class="product-card-body">
                                        <div class="product-category">
                                            <a href="{{ route('front.catalog') . '?category=' . $related->category->slug }}">{{ $related->category->name }}</a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="{{ route('front.product', $related->slug) }}">{{ Str::limit($related->name, 35) }}</a>
                                        </h3>
                                        <h4 class="product-price">
                                            @if ($related->previous_price != 0)
                                                <del>{{ PriceHelper::setPreviousPrice($related->previous_price) }}</del>
                                            @endif
                                            {{ PriceHelper::grandCurrencyPrice($related) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Discount Modal Setup --}}
    @if (isset($item->bundle_discount) && !empty($item->bundle_discount))
        @php
            $discountItems  = $item->bundle_discount['discount_items']     ?? [];
            $discountPrices = $item->bundle_discount['discountItems_price'] ?? [];
        @endphp
        @if(count($discountItems) > 0)
            <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="discountModalLabel">🎁 {{ __('First Time Offer') }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted mb-3">
                                <small>{{ __('Hurry! Avail discount — limited time offer') }}</small>
                            </p>
                            <div class="d-flex flex-wrap gap-3" id="discount-options">
                                @for ($i = 0; $i < count($discountItems); $i++)
                                    <label class="offer-card">
                                        <input type="radio" name="discount_selected"
                                               value="{{ $i }}"
                                               data-pct="{{ $discountPrices[$i] ?? 0 }}"
                                               data-label="{{ $discountItems[$i] }}"
                                               class="d-none" />
                                        <div class="discount-card text-center">
                                            <div class="fw-semibold mb-2">{{ __('Buy') }} {{ $discountItems[$i] }}</div>
                                            <small class="text-muted d-block mb-1">{{ __('Save') }}</small>
                                            <div class="fw-bold text-primary" style="font-size: 1.5rem;">{{ number_format($discountPrices[$i] ?? 0) }}%</div>
                                        </div>
                                    </label>
                                @endfor
                            </div>
                            <div id="discount-no-selection-alert" class="alert alert-warning mt-3 d-none py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ __('Please select a discount tier first.') }}
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0 gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="button" class="btn btn-warning" id="applyDiscountBtn">
                                <i class="fas fa-check me-1"></i>{{ __('Apply Offer') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- Review Modal --}}
    @auth
        <form class="modal fade ratingForm" action="{{ route('front.review.submit') }}" method="post" id="leaveReview" tabindex="-1">
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Leave a Review') }}</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php $user = Auth::user(); @endphp
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-name">{{ __('Your Name') }}</label>
                                    <input class="form-control" type="text" id="review-name" value="{{ $user->first_name }}" required>
                                </div>
                            </div>
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-email">{{ __('Your Email') }}</label>
                                    <input class="form-control" type="email" id="review-email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-subject">{{ __('Subject') }}</label>
                                    <input class="form-control" type="text" name="subject" id="review-subject" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-rating">{{ __('Rating') }}</label>
                                    <select name="rating" class="form-control" id="review-rating">
                                        <option value="5">5 {{ __('Stars') }}</option>
                                        <option value="4">4 {{ __('Stars') }}</option>
                                        <option value="3">3 {{ __('Stars') }}</option>
                                        <option value="2">2 {{ __('Stars') }}</option>
                                        <option value="1">1 {{ __('Star') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="review-message">{{ __('Review') }}</label>
                            <textarea class="form-control" name="review" id="review-message" rows="8" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">{{ __('Submit Review') }}</button>
                    </div>
                </div>
            </div>
        </form>
    @endauth

    {{-- JavaScript --}}
    <script>
        // File Upload Preview
        const dt = new DataTransfer();

        document.getElementById('sample_images')?.addEventListener('change', function(e) {
            const input = e.target;
            const previewArea = document.getElementById('preview-area');
            const progressWrapper = document.getElementById('shared-progress-wrapper');
            const progressBar = document.getElementById('shared-progress-bar');

            progressBar.style.width = '0%';
            progressBar.innerText = '0%';
            progressBar.classList.remove('bg-success');
            progressWrapper.style.display = 'block';

            Array.from(input.files).forEach((file) => {
                if ([...dt.files].some(f => f.name === file.name && f.size === file.size)) return;
                dt.items.add(file);

                const container = document.createElement('div');
                container.className = 'd-inline-block text-center position-relative';
                container.style.cssText = 'width:120px;height:120px;margin:5px;border:2px solid var(--gray-200);border-radius:var(--radius-md);overflow:hidden;padding:5px;';

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.style.cssText = 'position:absolute;top:5px;right:5px;border:none;background:var(--danger-color);color:#fff;cursor:pointer;width:24px;height:24px;border-radius:50%;font-size:16px;line-height:20px;z-index:10;';
                removeBtn.title = 'Remove';

                removeBtn.addEventListener('click', function() {
                    const newDt = new DataTransfer();
                    [...dt.files].forEach(f => {
                        if (!(f.name === file.name && f.size === file.size)) {
                            newDt.items.add(f);
                        }
                    });
                    dt.items.clear();
                    [...newDt.files].forEach(f => dt.items.add(f));
                    input.files = dt.files;
                    container.remove();
                });

                container.appendChild(removeBtn);

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    const img = document.createElement('img');
                    img.style.cssText = 'max-width:100%;max-height:100%;border-radius:var(--radius-sm);';
                    reader.onload = (e) => img.src = e.target.result;
                    reader.readAsDataURL(file);
                    container.appendChild(img);
                } else {
                    const icon = document.createElement('i');
                    const ext = file.name.split('.').pop().toLowerCase();
                    icon.className = ext === 'pdf' ? 'fas fa-file-pdf fa-3x text-danger' :
                                    ['doc','docx'].includes(ext) ? 'fas fa-file-word fa-3x text-primary' :
                                    'fas fa-file-alt fa-3x text-secondary';
                    container.appendChild(icon);
                    const label = document.createElement('small');
                    label.innerText = file.name;
                    label.style.cssText = 'font-size:10px;word-break:break-word;display:block;margin-top:5px;';
                    container.appendChild(label);
                }

                previewArea.appendChild(container);
            });

            input.files = dt.files;

            let percent = 0;
            const interval = setInterval(() => {
                percent += 5;
                progressBar.style.width = percent + '%';
                progressBar.innerText = percent + '%';
                if (percent >= 100) {
                    clearInterval(interval);
                    progressBar.classList.add('bg-success');
                    progressBar.innerText = 'Done';
                    setTimeout(() => progressWrapper.style.display = 'none', 500);
                }
            }, 30);
        });

        // Gallery navigation
        const assetBaseUrl = "{{ url('assets/img') }}";
        document.addEventListener('DOMContentLoaded', function() {
            const gallery = $('#product-gallery');
            document.querySelectorAll('.attribute_option').forEach(select => {
                select.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const optionId = selected.getAttribute('data-href');
                    const selectedAttrId = selected.getAttribute('data-type');
                    if (!optionId || !selectedAttrId) return;

                    const items = $('#product-gallery .item img');
                    let foundIndex = -1;
                    items.each(function() {
                        if (this.getAttribute('data-option-id') === optionId &&
                            this.getAttribute('data-attribute-id') === selectedAttrId) {
                            foundIndex = parseInt(this.getAttribute('data-index'));
                            return false;
                        }
                    });
                    if (foundIndex !== -1) {
                        gallery.trigger('to.owl.carousel', [foundIndex, 300, true]);
                    }
                });
            });
        });

        // Discount card selection
        document.addEventListener('DOMContentLoaded', function() {
            const offerCards        = document.querySelectorAll('.offer-card');
            const noSelectionAlert  = document.getElementById('discount-no-selection-alert');
            const availBtn          = document.getElementById('avail_discount');

            // Highlight the card whose radio is checked
            offerCards.forEach(label => {
                const radio = label.querySelector('input[type="radio"]');
                const card  = label.querySelector('.discount-card');
                if (!radio || !card) return;

                radio.addEventListener('change', () => {
                    offerCards.forEach(l => {
                        const c = l.querySelector('.discount-card');
                        if (c) c.classList.remove('selected');
                    });
                    card.classList.add('selected');
                    // Hide the no-selection warning once a tier is chosen
                    if (noSelectionAlert) noSelectionAlert.classList.add('d-none');
                });

                if (radio.checked) card.classList.add('selected');
            });

            // Apply Offer button
            const applyBtn = document.getElementById('applyDiscountBtn');
            if (applyBtn) {
                applyBtn.addEventListener('click', function() {
                    const selectedRadio = document.querySelector('input[name="discount_selected"]:checked');

                    if (!selectedRadio) {
                        // Show inline warning — keep modal open
                        if (noSelectionAlert) noSelectionAlert.classList.remove('d-none');
                        return;
                    }

                    const discountPct   = parseFloat(selectedRadio.getAttribute('data-pct') || '0');
                    const discountLabel = selectedRadio.getAttribute('data-label') || '';

                    // If the label is a numeric quantity threshold, update the qty input
                    const qtyInput     = document.querySelector('.qtyValue.cart-amount');
                    const qtyThreshold = parseInt(discountLabel, 10);
                    if (!isNaN(qtyThreshold) && qtyThreshold >= 1 && qtyInput) {
                        qtyInput.value = qtyThreshold;
                    }

                    // Persist the applied discount percentage so:
                    //  a) getData() uses it when qty/options change, and
                    //  b) the cart-add AJAX request sends it to the server
                    window._activeDiscountPct = discountPct;

                    // Delegate the price re-render to getData() so formatting is
                    // identical to what happens on qty / option changes
                    if (typeof window.getData === 'function') {
                        window.getData(0);
                    }

                    // Visual feedback: change the trigger button to show "Applied"
                    if (availBtn) {
                        availBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i><span>{{ __("Offer Applied ✓") }}</span>';
                        availBtn.classList.remove('btn-warning', 'pulse-animation');
                        availBtn.classList.add('btn-success');
                    }

                    // Blur the currently focused element before hiding so Bootstrap's
                    // aria-hidden transition does not trap focus inside the modal,
                    // which would trigger the "Blocked aria-hidden on an element
                    // because its descendant retained focus" browser warning.
                    if (document.activeElement && document.activeElement !== document.body) {
                        document.activeElement.blur();
                    }

                    // Close the modal
                    const modalEl = document.getElementById('discountModal');
                    if (modalEl && typeof bootstrap !== 'undefined') {
                        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                    }
                });
            }

            // When the modal is reopened, clear the "no selection" warning and
            // reset any previously highlighted card so the user can re-pick
            const discountModalEl = document.getElementById('discountModal');
            if (discountModalEl) {
                discountModalEl.addEventListener('show.bs.modal', function() {
                    if (noSelectionAlert) noSelectionAlert.classList.add('d-none');
                });
            }
        });

        // Attribute validation
        document.addEventListener('DOMContentLoaded', function() {
            function validateAttributeOptions() {
                let valid = true;
                let firstInvalid = null;
                document.querySelectorAll('.attribute_option').forEach(function(select) {
                    if (select.options.length > 1 && !select.value) {
                        valid = false;
                        if (!firstInvalid) firstInvalid = select;
                        select.classList.add('is-invalid');
                    } else {
                        select.classList.remove('is-invalid');
                    }
                });
                if (!valid && firstInvalid) firstInvalid.focus();
                return valid;
            }

            document.getElementById('add_to_cart')?.addEventListener('click', function(e) {
                if (!validateAttributeOptions()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            document.getElementById('but_to_cart')?.addEventListener('click', function(e) {
                if (!validateAttributeOptions()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            document.querySelectorAll('.attribute_option').forEach(function(select) {
                select.addEventListener('change', function() {
                    if (select.value) select.classList.remove('is-invalid');
                });
            });
        });
    </script>
@endsection
