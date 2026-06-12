@extends('master.front')

@section('styleplugins')
<style>
    /* ============================================================
       DESIGN TOKENS
    ============================================================ */
    :root {
        --primary:        {{ $setting->primary_color ?? '#0F3460' }};
        --primary-dark:   {{ $setting->primary_color ?? '#0a2342' }};
        --primary-light:  {{ $setting->primary_color ?? '#1a529c' }};
        --accent:         #d0a64b;
        --gold:           #d0a64b;
        --gold-dark:      #b88a3b;
        --success:        #00b894;
        --danger:         #d63031;
        --info:           #0984e3;
        --text-900:       #1a1a2e;
        --text-700:       #2d3436;
        --text-500:       #636e72;
        --text-300:       #b2bec3;
        --bg-page:        #f4f5f9;
        --bg-card:        #ffffff;
        --bg-soft:        #f8f8fc;
        --border:         #e8e8f0;
        --shadow-xs:      0 1px 3px rgba(15, 52, 96, .08);
        --shadow-sm:      0 4px 12px rgba(15, 52, 96, .10);
        --shadow-md:      0 8px 24px rgba(15, 52, 96, .14);
        --shadow-lg:      0 16px 40px rgba(15, 52, 96, .18);
        --shadow-xl:      0 24px 60px rgba(15, 52, 96, .22);
        --radius-sm:      8px;
        --radius-md:      14px;
        --radius-lg:      20px;
        --radius-xl:      28px;
        --radius-pill:    999px;
        --grad-primary:   linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        --grad-accent:    linear-gradient(135deg, var(--accent) 0%, var(--gold) 100%);
        --grad-success:   linear-gradient(135deg, var(--success) 0%, #00cec9 100%);
        --grad-gold:      linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
        --grad-page:      linear-gradient(160deg, #f4f5f9 0%, #e6eaf0 100%);
        --transition:     all .3s cubic-bezier(.4,0,.2,1);
        --font-main:      'Inter', 'Outfit', system-ui, sans-serif;
    }

    /* ============================================================
       GOOGLE FONTS
    ============================================================ */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap');

    body { font-family: var(--font-main); }

    /* ============================================================
       PAGE WRAPPER
    ============================================================ */
    .pdp-page-wrapper {
        background: var(--grad-page);
        min-height: 100vh;
        padding-bottom: 80px;
    }

    /* ============================================================
       BREADCRUMB HERO STRIP
    ============================================================ */
    .pdp-hero-strip {
        background: #2A4166;
        padding: 18px 0;
        position: relative;
        overflow: hidden;
    }
    .pdp-hero-strip::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .pdp-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
        z-index: 1;
    }
    .pdp-breadcrumbs li {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
    }
    .pdp-breadcrumbs li::after {
        content: '/';
        color: rgba(255,255,255,.35);
        font-size: 12px;
    }
    .pdp-breadcrumbs li:last-child::after { display: none; }
    .pdp-breadcrumbs a {
        color: rgba(255,255,255,.65);
        text-decoration: none;
        transition: var(--transition);
    }
    .pdp-breadcrumbs a:hover { color: var(--primary-light); }
    .pdp-breadcrumbs .current { color: #fff; font-weight: 600; }

    /* ============================================================
       MAIN GRID
    ============================================================ */
    .pdp-main-grid {
        /* using bootstrap row/cols */
    }

    /* ============================================================
       GALLERY COLUMN
    ============================================================ */
    .pdp-gallery-col {
        position: sticky;
        top: 20px;
    }
    .pdp-gallery-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--border);
    }
    .pdp-gallery-main {
        position: relative;
        background: var(--bg-soft);
    }
    .pdp-gallery-main .product-details-slider img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        display: block;
    }

    /* Badges on gallery */
    .pdp-badge-group {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 10;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .pdp-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        box-shadow: var(--shadow-sm);
    }
    .pdp-badge.badge-new    { background: var(--grad-success); color: #fff; }
    .pdp-badge.badge-hot    { background: var(--grad-gold);    color: #fff; }
    .pdp-badge.badge-sale   { background: #daa520 !important;       color: #fff; }
    .pdp-badge.badge-out    { background: #636e72;             color: #fff; }
    .pdp-badge.badge-top    { background: var(--info);         color: #fff; }
    .pdp-badge.badge-best   { background: var(--text-700);     color: #fff; }
    .pdp-badge.badge-custom {
        background: var(--grad-primary);
        color: #fff;
        animation: pdp-pulse-badge 2.5s ease-in-out infinite;
    }
    @keyframes pdp-pulse-badge {
        0%,100% { box-shadow: 0 0 0 0 rgba(108,92,231,.4); }
        50%      { box-shadow: 0 0 0 8px rgba(108,92,231,0); }
    }

    /* Video btn top-right */
    .pdp-video-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255,255,255,.95);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }
    .pdp-video-btn:hover {
        transform: scale(1.1);
        background: var(--primary);
    }
    .pdp-video-btn:hover svg circle { fill: var(--primary); }
    .pdp-video-btn:hover svg polygon { fill: #fff; }

    /* Discount ribbon */
    .pdp-discount-ribbon {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
        background: var(--danger);
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        box-shadow: var(--shadow-sm);
        animation: pdp-bounce 1.8s ease-in-out infinite;
    }
    @keyframes pdp-bounce {
        0%,100% { transform: translateY(0); }
        50%      { transform: translateY(-4px); }
    }

    /* Thumbnails strip */
    .pdp-thumbs-strip {
        padding: 14px;
        background: #fff;
        border-top: 1px solid var(--border);
    }
    .pdp-thumbs-strip .owl-item img {
        border-radius: var(--radius-sm);
        border: 2px solid transparent;
        cursor: pointer;
        transition: var(--transition);
        aspect-ratio: 1;
        object-fit: cover;
    }
    .pdp-thumbs-strip .owl-item.active img { border-color: var(--primary); }
    .pdp-thumbs-strip .owl-item img:hover   { border-color: var(--primary-light); }

    /* ============================================================
       VARIATIONS CARD (below gallery)
    ============================================================ */
    .pdp-variations-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        margin-top: 20px;
        overflow: hidden;
    }
    .pdp-variations-header {
        background: linear-gradient(135deg, #f8f8fc 0%, #ede9fe 100%);
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pdp-variations-header .icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: var(--grad-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        flex-shrink: 0;
    }
    .pdp-variations-header h5 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-900);
        margin: 0;
    }
    .pdp-variations-body { padding: 20px 24px; }

    .pdp-custom-level-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    /* File upload zone */
    .pdp-upload-zone {
        border: 2px dashed var(--primary-light);
        border-radius: var(--radius-md);
        padding: 20px;
        background: linear-gradient(135deg, rgba(108,92,231,.03) 0%, rgba(162,155,254,.05) 100%);
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
    }
    .pdp-upload-zone:hover {
        border-color: var(--primary);
        background: linear-gradient(135deg, rgba(108,92,231,.06) 0%, rgba(162,155,254,.08) 100%);
    }
    .pdp-upload-zone .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--grad-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        color: #fff;
        font-size: 18px;
    }

    /* ============================================================
       INFO COLUMN
    ============================================================ */
    .pdp-info-col {}
    .pdp-info-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .pdp-info-body { padding: 32px; }

    /* Product title */
    .pdp-product-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333333;
        line-height: 1.2;
        margin-bottom: 6px;
        letter-spacing: -.5px;
    }
    @media (max-width: 768px) {
        .pdp-product-title { font-size: 1.5rem; }
    }

    /* Short description */
    .pdp-short-desc {
        font-size: 15px;
        color: #444444;
        line-height: 1.65;
        margin-bottom: 0;
    }
    .pdp-short-desc .read-more-link {
        color: #333333;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }
    .pdp-short-desc .read-more-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Section divider */
    .pdp-section-divider {
        height: 1px;
        background: var(--border);
        margin: 22px 0;
    }

    /* ============================================================
       PRICE SECTION
    ============================================================ */
    .pdp-price-section {
        background: #fcfcfc;
        border: 1px solid #eaeaea;
        border-radius: var(--radius-md);
        padding: 20px 24px;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }
    .pdp-price-section::after {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(42,65,102,.05) 0%, transparent 70%);
        pointer-events: none;
    }
    .pdp-price-section .price-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #444444;
        margin-bottom: 6px;
    }
    .pdp-price-was {
        font-size: 15px;
        color: #555555;
        text-decoration: line-through;
        margin-right: 12px;
    }
    .pdp-price-now {
        font-size: 2.4rem;
        font-weight: 900;
        color: #333333;
        line-height: 1;
    }
    .pdp-price-discount-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(135deg, #d63031 0%, #e84393 100%);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        vertical-align: middle;
        margin-left: 10px;
        box-shadow: 0 4px 10px rgba(214, 48, 49, 0.25);
    }
    #discount_info {
        display: none;
        margin-top: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--success);
        background: rgba(0,184,148,.08);
        border: 1px solid rgba(0,184,148,.2);
        border-radius: var(--radius-sm);
        padding: 6px 12px;
    }

    /* Countdown */
    .pdp-countdown {
        background: linear-gradient(135deg, #2d3436 0%, #1a1a2e 100%);
        color: #fff;
        border-radius: var(--radius-md);
        padding: 14px 20px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
    }
    .pdp-countdown .countdown { color: var(--gold); font-weight: 700; }

    /* ============================================================
       ATTRIBUTES SECTION
    ============================================================ */
    .pdp-section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #666666;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pdp-section-label::before {
        content: '';
        display: block;
        width: 3px;
        height: 14px;
        border-radius: var(--radius-pill);
        background: #2A4166;
        flex-shrink: 0;
    }

    .pdp-attr-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 480px) { .pdp-attr-grid { grid-template-columns: 1fr; } }

    .pdp-attr-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-700);
        margin-bottom: 6px;
    }
    .pdp-attr-group .attribute_option {
        width: 100%;
        padding: 11px 36px 11px 14px;
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236c5ce7' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") no-repeat right 10px center / 18px;
        font-size: 14px;
        color: var(--text-700);
        cursor: pointer;
        appearance: none;
        transition: var(--transition);
        font-weight: 500;
    }
    .pdp-attr-group .attribute_option:hover,
    .pdp-attr-group .attribute_option:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(108,92,231,.12);
        outline: none;
    }
    .pdp-attr-group .attribute_option.is-invalid {
        border-color: var(--danger);
        background-color: #fff5f5;
        box-shadow: 0 0 0 3px rgba(214,48,49,.1);
    }
    .pdp-attr-group .invalid-msg {
        display: none;
        font-size: 12px;
        color: var(--danger);
        margin-top: 4px;
        font-weight: 500;
    }
    .pdp-attr-group .attribute_option.is-invalid ~ .invalid-msg { display: block; }

    /* ============================================================
       QUANTITY + TOTAL
    ============================================================ */
    .pdp-qty-row {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .pdp-qty-label {
        font-size: 13px;
        font-weight: 600;
        color: #000000;
    }
    .pdp-qty-control {
        display: inline-flex;
        align-items: center;
        background: var(--bg-soft);
        border: 2px solid var(--border);
        border-radius: var(--radius-pill);
        overflow: hidden;
    }
    .pdp-qty-control .qty-btn {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
        color: #000000;
        background: transparent;
        border: none;
        transition: var(--transition);
        font-weight: 700;
        user-select: none;
    }
    .pdp-qty-control .qty-btn:hover {
        background: #000000;
        color: #fff;
    }
    .pdp-qty-control .qtyValue {
        width: 52px;
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        border: none;
        background: transparent;
        outline: none;
        color: #000000;
    }
    .pdp-total-badge {
        margin-left: auto;
        background: var(--bg-soft);
        border: 2px solid var(--border);
        border-radius: var(--radius-pill);
        padding: 9px 20px;
        font-size: 14px;
        font-weight: 700;
        color: #000000;
        white-space: nowrap;
    }
    .pdp-total-badge span { color: #000000; }

    /* ============================================================
       CTA BUTTONS
    ============================================================ */
    .pdp-cta-wrap { display: flex; gap: 12px; flex-wrap: wrap; }

    .pdp-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: var(--radius-md);
        font-size: 15px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        flex: 1;
        min-width: 160px;
        letter-spacing: .2px;
    }
    .pdp-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0);
        transition: background .2s;
    }
    .pdp-btn:hover::after { background: rgba(255,255,255,.12); }

    .pdp-btn-primary {
        background: linear-gradient(135deg, #2A4166 0%, #1f314d 100%);
        color: #fff;
        box-shadow: 0 6px 20px rgba(42,65,102,.30);
    }
    .pdp-btn-primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 12px 28px rgba(42,65,102,.45);
        color: #fff;
    }

    .pdp-btn-outline {
        background: #fff;
        color: #2A4166;
        border: 2px solid #2A4166;
        box-shadow: 0 4px 10px rgba(0,0,0,.03);
    }
    .pdp-btn-outline:hover {
        background: #f8faff;
        color: #1f314d;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 16px rgba(42,65,102,.12);
    }

    .pdp-btn-gold {
        background: linear-gradient(135deg, #2A4166 0%, #1f314d 100%);
        color: #fff;
        box-shadow: 0 6px 20px rgba(42,65,102,.40);
        animation: pdp-pulse-blue 2.2s ease-in-out infinite;
    }
    .pdp-btn-gold:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 12px 28px rgba(42,65,102,.55);
        color: #fff;
        animation: none;
    }
    @keyframes pdp-pulse-blue {
        0%,100% { box-shadow: 0 6px 20px rgba(42,65,102,.30); }
        50%      { box-shadow: 0 6px 28px rgba(42,65,102,.60); }
    }

    .pdp-btn-customize {
        background: linear-gradient(135deg, #1f314d 0%, #2A4166 100%);
        color: #fff;
        border: 1px dashed rgba(255,255,255,0.4);
        box-shadow: 0 4px 15px rgba(42,65,102,.2);
        font-size: 15px;
        font-weight: 700;
        padding: 14px 28px;
        width: 100%;
        flex: none;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: var(--transition);
        animation: pdp-offer-glow 3s infinite;
    }
    .pdp-btn-customize:hover {
        transform: translateY(-2px) scale(1.01);
        background: #1f314d;
        color: #fff;
        border: 1px solid rgba(255,255,255,0.8);
        box-shadow: 0 8px 25px rgba(208, 166, 75, .3);
    }
    @keyframes pdp-offer-glow {
        0%, 100% { box-shadow: 0 4px 15px rgba(42,65,102,.2); }
        50% { box-shadow: 0 4px 25px rgba(208, 166, 75, .25); border-color: rgba(208, 166, 75, .6); }
    }

    .pdp-btn-disabled {
        background: var(--border);
        color: var(--text-300);
        cursor: not-allowed;
        pointer-events: none;
        flex: 1;
        min-width: 160px;
    }

    .pdp-customize-hint {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-500);
        margin-top: 8px;
        padding: 8px 12px;
        background: rgba(108,92,231,.05);
        border-radius: var(--radius-sm);
        border-left: 3px solid var(--primary-light);
    }

    .pdp-customize-action-hint {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--info);
        background: rgba(9,132,227,.07);
        border: 1px solid rgba(9,132,227,.2);
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        width: 100%;
        font-weight: 500;
    }

    /* ============================================================
       META INFO STRIP
    ============================================================ */
    .pdp-meta-strip {
        background: var(--bg-soft);
        border-top: 1px solid var(--border);
        padding: 20px 32px;
    }
    .pdp-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 24px;
    }
    @media (max-width: 480px) { .pdp-meta-grid { grid-template-columns: 1fr; } }
    .pdp-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .pdp-meta-icon {
        width: 28px;
        height: 28px;
        border-radius: var(--radius-sm);
        background: var(--grad-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 11px;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .pdp-meta-content { flex: 1; }
    .pdp-meta-content .meta-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text-300);
        display: block;
        line-height: 1.2;
    }
    .pdp-meta-content .meta-val {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-700);
    }
    .pdp-meta-content .meta-val a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }
    .pdp-meta-content .meta-val a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Trust badges */
    .pdp-trust-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border);
    }
    .pdp-trust-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-500);
        background: transparent;
        padding: 6px 10px;
        transition: var(--transition);
    }
    .pdp-trust-badge:hover {
        color: var(--text-900);
        transform: translateY(-1px);
    }
    .pdp-trust-badge i { color: #2A4166; font-size: 14px; }

    /* ============================================================
       DETAILS TABS SECTION
    ============================================================ */
    .pdp-details-section { margin-top: 48px; }
    .pdp-section-heading {
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--text-900);
        position: relative;
        padding-bottom: 16px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .pdp-section-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 52px;
        height: 4px;
        background: var(--grad-primary);
        border-radius: var(--radius-pill);
    }
    .pdp-section-heading .heading-icon {
        width: 42px;
        height: 42px;
        border-radius: var(--radius-md);
        background: var(--grad-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 16px;
        flex-shrink: 0;
    }

    /* Tab nav */
    .pdp-tab-nav {
        display: flex;
        gap: 4px;
        border-bottom: 2px solid var(--border);
        margin-bottom: 0;
        list-style: none;
        padding: 0;
        overflow-x: auto;
    }
    .pdp-tab-nav::-webkit-scrollbar { height: 0; }
    .pdp-tab-nav li a {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 14px 22px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-500);
        text-decoration: none;
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
        border: 2px solid transparent;
        border-bottom: none;
        transition: var(--transition);
        white-space: nowrap;
        position: relative;
        top: 2px;
    }
    .pdp-tab-nav li a:hover {
        color: var(--primary);
        background: rgba(108,92,231,.04);
    }
    .pdp-tab-nav li a.active {
        color: var(--primary);
        background: var(--bg-card);
        border-color: var(--border);
        border-bottom-color: var(--bg-card);
    }

    .pdp-tab-content {
        background: var(--bg-card);
        border: 2px solid var(--border);
        border-top: none;
        border-radius: 0 var(--radius-md) var(--radius-md) var(--radius-md);
        padding: 36px;
        box-shadow: var(--shadow-sm);
    }
    @media (max-width: 768px) { .pdp-tab-content { padding: 20px; } }

    /* Description content styling */
    .pdp-tab-content h1,
    .pdp-tab-content h2,
    .pdp-tab-content h3 { color: var(--text-900); font-weight: 700; }
    .pdp-tab-content p { color: var(--text-700); line-height: 1.7; }
    .pdp-tab-content ul,
    .pdp-tab-content ol { color: var(--text-700); line-height: 1.7; }

    /* Spec table */
    .pdp-spec-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .pdp-spec-table th {
        background: linear-gradient(135deg, #f8f8fc 0%, #ede9fe 100%);
        color: var(--text-900);
        font-weight: 700;
        padding: 16px 20px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 2px solid var(--border);
    }
    .pdp-spec-table td {
        padding: 14px 20px;
        color: var(--text-700);
        font-size: 14px;
        border-bottom: 1px solid var(--border);
        font-weight: 500;
    }
    .pdp-spec-table tbody tr:last-child td { border-bottom: none; }
    .pdp-spec-table tbody tr:nth-child(even) td { background: rgba(108,92,231,.025); }
    .pdp-spec-table .spec-key {
        background: var(--bg-soft);
        font-weight: 700;
        color: var(--text-900);
        width: 32%;
    }
    .pdp-spec-table tbody tr:nth-child(even) .spec-key { background: rgba(108,92,231,.05); }

    .pdp-no-spec {
        text-align: center;
        padding: 40px;
        color: var(--text-300);
    }
    .pdp-no-spec i { font-size: 40px; display: block; margin-bottom: 10px; }

    /* ============================================================
       RELATED PRODUCTS
    ============================================================ */
    .pdp-related-section { margin-top: 64px; }

    .pdp-product-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-xs);
        border: 1px solid var(--border);
        transition: var(--transition);
        position: relative;
    }
    .pdp-product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(108,92,231,.2);
    }
    .pdp-product-thumb {
        position: relative;
        overflow: hidden;
        background: var(--bg-soft);
        aspect-ratio: 1;
    }
    .pdp-product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s cubic-bezier(.4,0,.2,1);
    }
    .pdp-product-card:hover .pdp-product-thumb img { transform: scale(1.1); }

    .pdp-product-badge-wrap {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 5;
    }

    .pdp-product-body { padding: 18px 20px; }
    .pdp-product-cat {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--primary);
        margin-bottom: 6px;
    }
    .pdp-product-cat a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }
    .pdp-product-cat a:hover { color: var(--primary-dark); }
    .pdp-product-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-900);
        margin-bottom: 10px;
        line-height: 1.4;
        min-height: 38px;
    }
    .pdp-product-name a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }
    .pdp-product-name a:hover { color: var(--primary); }
    .pdp-product-price {
        font-size: 15px;
        font-weight: 800;
        color: var(--primary);
    }
    .pdp-product-price del {
        color: var(--text-300);
        font-weight: 400;
        font-size: 12px;
        margin-right: 5px;
    }

    /* ============================================================
       DISCOUNT MODAL
    ============================================================ */
    .pdp-modal .modal-content {
        border: none;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
    }
    .pdp-modal .modal-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d3436 100%);
        color: #fff;
        padding: 28px 30px;
        border-bottom: none;
    }
    .pdp-modal .modal-title {
        font-size: 1.4rem;
        font-weight: 800;
    }
    .pdp-modal .btn-close-white { filter: invert(1); }
    .pdp-modal .modal-body { padding: 28px 30px; }
    .pdp-modal .modal-footer {
        background: var(--bg-soft);
        border-top: 1px solid var(--border);
        padding: 18px 30px;
        gap: 10px;
    }

    .pdp-offer-card {
        cursor: pointer;
        outline: none;
        border: none;
        background: none;
        padding: 0;
        display: inline-flex;
        flex-direction: column;
        user-select: none;
        -webkit-user-select: none;
    }
    .pdp-discount-tile {
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        padding: 20px 16px;
        text-align: center;
        background: var(--bg-card);
        min-width: 130px;
        transition: var(--transition);
    }
    .pdp-discount-tile:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
        transform: translateY(-3px);
    }
    .pdp-offer-card input:checked + .pdp-discount-tile {
        border-color: var(--primary);
        background: rgba(108,92,231,.06);
        box-shadow: 0 0 0 3px rgba(108,92,231,.15);
        transform: scale(1.03);
    }
    .pdp-discount-tile .tile-qty {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-700);
        margin-bottom: 4px;
    }
    .pdp-discount-tile .tile-save {
        font-size: 11px;
        color: var(--text-300);
        margin-bottom: 6px;
    }
    .pdp-discount-tile .tile-pct {
        font-size: 2rem;
        font-weight: 900;
        background: var(--grad-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    /* ============================================================
       REVIEW MODAL
    ============================================================ */
    .pdp-review-modal .modal-content {
        border: none;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }
    .pdp-review-modal .modal-header {
        background: var(--grad-primary);
        color: #fff;
        border-bottom: none;
        padding: 24px 28px;
    }
    .pdp-review-modal .modal-title { font-weight: 700; font-size: 1.3rem; }

    /* ============================================================
       PROGRESS BAR
    ============================================================ */
    .progress { height: 8px; border-radius: var(--radius-pill); background: var(--border); overflow: hidden; }
    .progress-bar { background: var(--grad-primary); border-radius: var(--radius-pill); transition: width .3s ease; }

    /* ============================================================
       RESPONSIVE TWEAKS
    ============================================================ */
    @media (max-width: 768px) {
        .pdp-info-body { padding: 20px; }
        .pdp-meta-strip { padding: 16px 20px; }
        .pdp-section-heading { font-size: 1.3rem; }
        .pdp-price-now { font-size: 1.9rem; }
        .pdp-gallery-col { position: static; }
        .pdp-cta-wrap { flex-direction: column; }
        .pdp-btn { min-width: 100%; flex: none; }
        .pdp-btn-customize { flex: none; }
        .pdp-trust-row { gap: 7px; }
    }
    @media (max-width: 480px) {
        .pdp-qty-row { flex-direction: column; align-items: flex-start; }
        .pdp-total-badge { margin-left: 0; width: 100%; text-align: center; }
    }

    /* ============================================================
       MISC UTILITIES
    ============================================================ */
    .pdp-mt-6  { margin-top: 24px; }
    .pdp-tag {
        display: inline-block;
        background: rgba(108,92,231,.1);
        color: var(--primary);
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: var(--radius-pill);
        margin: 2px;
        text-decoration: none;
        transition: var(--transition);
    }
    .pdp-tag:hover {
        background: var(--primary);
        color: #fff;
    }
    .pdp-sku-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--bg-soft);
        border: 1px solid var(--border);
        border-radius: var(--radius-pill);
        padding: 4px 12px;
        font-size: 12px;
        color: var(--text-500);
        font-weight: 600;
    }
    .pdp-sku-pill span { color: var(--text-700); }
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

<div class="pdp-page-wrapper">

    {{-- ── BREADCRUMB HERO STRIP ── --}}
    <div class="pdp-hero-strip">
        <div class="container">
            <ul class="pdp-breadcrumbs">
                <li><a href="{{ route('front.index') }}"><i class="fas fa-home me-1"></i>{{ __('Home') }}</a></li>
                <li><a href="{{ route('front.catalog') }}">{{ __('Shop') }}</a></li>
                <li><span class="current">{{ Str::limit($item->name, 50) }}</span></li>
            </ul>
        </div>
    </div>

    <div class="container" style="padding-top: 10px; padding-bottom: 10px;">

        {{-- ══════════════════════════════════════════════
             MAIN GRID: GALLERY ← → INFO
        ══════════════════════════════════════════════ --}}
        <div class="row mt-4 pdp-main-grid">

            {{-- ─────────── GALLERY COLUMN ─────────── --}}
            <div class="col-lg-6 pdp-gallery-col">

                {{-- Main Gallery Card --}}
                <div class="pdp-gallery-card">
                    <div class="pdp-gallery-main">

                        {{-- Top-Left Badge Group --}}
                        <div class="pdp-badge-group">
                            @if ($item->is_stock())
                                @php $typeClass = match($item->is_type) {
                                    'feature'    => 'badge-hot',
                                    'new'        => 'badge-new',
                                    'top'        => 'badge-top',
                                    'best'       => 'badge-best',
                                    'flash_deal' => 'badge-new',
                                    default      => '',
                                }; @endphp
                                @if ($item->is_type !== 'undefine' && $typeClass)
                                    <span class="pdp-badge {{ $typeClass }}">
                                        @if ($item->is_type === 'flash_deal') <i class="fas fa-bolt"></i> @endif
                                        {{ ucfirst(str_replace('_', ' ', $item->is_type)) }}
                                    </span>
                                @endif
                            @else
                                <span class="pdp-badge badge-out"><i class="fas fa-times-circle"></i>{{ __('Out of Stock') }}</span>
                            @endif

                            @if ($item->previous_price && $item->previous_price != 0)
                                <span class="pdp-badge badge-sale" style="backgournd-color:#daa520 !important">
                                    <i class="fas fa-tag"></i>-{{ PriceHelper::DiscountPercentage($item) }}
                                </span>
                            @endif

                            @php $hasCustomizers = method_exists($item, 'hasBedCustomizers') && $item->hasBedCustomizers(); @endphp
                            @if ($hasCustomizers)
                                <span class="pdp-badge badge-custom"><i class="fas fa-magic"></i>{{ __('Customizable') }}</span>
                            @endif
                        </div>

                        {{-- Video Button --}}
                        @if ($item->video)
                            <a href="{{ $item->video }}" class="pdp-video-btn" title="Watch video" data-type="video">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="12" fill="#f0eeff"/>
                                    <polygon points="10,8 17,12 10,16" fill="#6c5ce7"/>
                                </svg>
                            </a>
                        @endif

                        {{-- Gallery Slider --}}
                        @php $imageIndex = 0; @endphp
                        <div class="product-thumbnails insize">
                            <div class="product-details-slider owl-carousel" id="product-gallery">
                                <div class="item">
                                    <img src="{{ url('assets/img/' . $item->photo) }}" alt="{{ $item->name }}" data-index="{{ $imageIndex++ }}" style="border-radius: 0;" />
                                </div>
                                @foreach ($galleries as $gallery)
                                    <div class="item">
                                        <img src="{{ url('assets/img/' . $gallery->photo) }}" alt="{{ $item->name }}" data-index="{{ $imageIndex++ }}" style="border-radius: 0;" />
                                    </div>
                                @endforeach
                                @foreach (($attributes ?? collect()) as $attribute)
                                    @foreach (($attribute->options ?? collect()) as $option)
                                        @php $images = json_decode($option->variation_images, true) ?? []; @endphp
                                        @foreach (($images ?? []) as $img)
                                            @if (!empty($img))
                                                <div class="item">
                                                    <img src="{{ url('assets/img/' . $img) }}" alt="zoom"
                                                        data-option-id="{{ $option->id }}"
                                                        data-attribute-id="{{ $attribute->id }}"
                                                        data-index="{{ $imageIndex++ }}" style="border-radius: 0;" />
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Thumbnail Strip --}}
                    <div class="pdp-thumbs-strip">
                        <div class="product-thumbnails">
                            <div class="owl-carousel product-thumbnails-slider">
                                <div class="item"><img src="{{ url('assets/img/' . $item->photo) }}" alt="thumb" /></div>
                                @foreach ($galleries as $gallery)
                                    <div class="item"><img src="{{ url('assets/img/' . $gallery->photo) }}" alt="thumb" /></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>



            </div>{{-- /gallery col --}}

            {{-- ─────────── INFO COLUMN ─────────── --}}
            <div class="col-lg-6 pdp-info-col">
                <div class="pdp-info-card">

                    {{-- Hidden inputs --}}
                    <input type="hidden" id="item_id"          value="{{ $item->id }}">
                    <input type="hidden" id="demo_price"       value="{{ PriceHelper::setConvertPrice($item->discount_price) }}">
                    <input type="hidden" id="set_currency"     value="{{ PriceHelper::setCurrencySign() }}">
                    <input type="hidden" id="set_currency_val" value="{{ PriceHelper::setCurrencyValue() }}">
                    <input type="hidden" id="currency_direction" value="{{ $setting->currency_direction }}">

                    <div class="pdp-info-body">

                        {{-- ① PRODUCT TITLE ──────────────────── --}}
                        <h1 class="pdp-product-title">{{ $item->name }}</h1>

                        {{-- Flash Deal Countdown --}}
                        @if ($item->is_type == 'flash_deal')
                            @if (date('d-m-y') != \Carbon\Carbon::parse($item->date)->format('d-m-y'))
                                <div class="pdp-countdown">
                                    <i class="fas fa-fire" style="color:var(--gold);"></i>
                                    <span>{{ __('Flash Deal ends in') }}:</span>
                                    <div class="countdown" data-date-time="{{ $item->date }}"></div>
                                </div>
                            @endif
                        @endif

                        {{-- Short Description --}}
                        @if($item->sort_details)
                        <p class="pdp-short-desc">
                            {{ $item->sort_details }}
                            <a href="#pdp-details" class="scroll-to read-more-link">{{ __('Read more →') }}</a>
                        </p>
                        @endif

                        <div class="pdp-section-divider"></div>

                        {{-- ② PRICE SECTION ───────────────────── --}}
                        <div class="pdp-price-section">
                            <div class="price-label"><i class="fas fa-tag me-1"></i>{{ __('Price') }}</div>
                            <div class="d-flex align-items-baseline flex-wrap gap-1" style="margin-bottom:4px;">
                                @if ($item->previous_price != 0)
                                    <span class="pdp-price-was">{{ PriceHelper::setPreviousPrice($item->previous_price) }}</span>
                                @endif
                                <span id="main_price" class="pdp-price-now" data-price="{{ PriceHelper::grandCurrencyPrice($item) }}">
                                    {{ PriceHelper::grandCurrencyPrice($item) }}
                                </span>
                                @if ($item->previous_price && $item->previous_price != 0)
                                    <span class="product-badge bg-info" style="position:static; display:inline-block; margin-left:10px; color:#fff;">
                                        -{{ PriceHelper::DiscountPercentage($item) }}
                                    </span>
                                @endif
                            </div>
                            <div id="discount_info"></div>
                        </div>

                        <div class="pdp-section-divider"></div>

                        {{-- ③ ATTRIBUTES ───────────────────────── --}}
                        @if(($attributes ?? collect())->filter(fn($a) => ($a->options ?? collect())->count() > 0)->count() > 0)
                        <div>
                            <div class="pdp-section-label"><i class="fas fa-layer-group"></i>{{ __('Select Options') }}</div>
                            <div class="pdp-attr-grid">
                                @foreach (($attributes ?? collect()) as $attribute)
                                    @if (($attribute->options ?? collect())->count() != 0)
                                        <div class="pdp-attr-group">
                                            <label for="attr-{{ $attribute->id }}">{{ $attribute->name }}</label>
                                            <select class="attribute_option" id="attr-{{ $attribute->id }}">
                                                <option value="">{{ __('Select') }} {{ $attribute->name }}</option>
                                                @foreach (($attribute->options ?? collect())->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE) as $option)
                                                    @php
                                                        $stockRaw = $option->stock ?? '';
                                                        $isOut    = is_numeric($stockRaw) && (int) $stockRaw === 0;
                                                        $images   = json_decode($option->variation_images, true) ?: [];
                                                    @endphp
                                                    <option value="{{ $option->name }}"
                                                        data-type="{{ $attribute->id }}"
                                                        data-href="{{ $option->id }}"
                                                        data-images='@json($images)'
                                                        data-target="{{ PriceHelper::setConvertPrice($option->price) }}"
                                                        @if ($isOut) disabled style="color:#d63031;font-weight:600;background:#fff0f0;" @endif>
                                                        {{ $option->name }} @if ($isOut) — {{ __('Out of stock') }} @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-msg"><i class="fas fa-exclamation-circle me-1"></i>{{ __('Please select') }} {{ $attribute->name }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="pdp-section-divider"></div>
                        @endif

                        {{-- ④ QUANTITY ──────────────────────────── --}}
                        <div>
                            <div class="pdp-section-label"><i class="fas fa-sort-amount-up"></i>{{ __('Quantity') }}</div>
                            <div class="pdp-qty-row">
                                <span class="pdp-qty-label">{{ __('Qty') }}:</span>
                                <div class="pdp-qty-control product-quantity">
                                    <span class="qty-btn decreaseQty subclick"><i class="fas fa-minus"></i></span>
                                    <input type="text" class="qtyValue cart-amount" value="1">
                                    <span class="qty-btn increaseQty addclick"><i class="fas fa-plus"></i></span>
                                    <input type="hidden" value="{{ (is_numeric($item->stock) && $item->stock > 0) ? (int)$item->stock : 9999 }}" id="current_stock">
                                </div>
                            </div>
                        </div>

                        <div class="pdp-section-divider"></div>

                        {{-- ⑤ CTA BUTTONS ──────────────────────── --}}
                        <div>
                            <div class="pdp-section-label"><i class="fas fa-shopping-bag"></i>{{ __('Add to Your Order') }}</div>

                            {{-- Customize CTA (if customizable) --}}
                            @if($hasCustomizers)
                            <div style="margin-bottom:12px;">
                                <a href="{{ route('front.bed.customize', $item->slug) }}" class="pdp-btn pdp-btn-customize">
                                    <i class="fas fa-magic"></i>
                                    <span>{{ __('Customize This Bed') }}</span>
                                </a>
                                <div class="pdp-customize-hint">
                                    <i class="fas fa-info-circle" style="color:var(--primary);"></i>
                                    {{ __('Customize size, fabric, headboard, mattress and more') }}
                                </div>
                            </div>
                            @endif

                            {{-- Add to Cart / Buy Now --}}
                            @if ($item->item_type != 'affiliate')
                                @if ($item->is_stock())
                                    @if(!$hasCustomizers)
                                        <div class="pdp-cta-wrap">
                                            <button class="pdp-btn pdp-btn-outline" id="add_to_cart" style="width: 100%;">
                                                <i class="fas fa-shopping-cart"></i>
                                                <span>{{ __('Add to Cart') }}</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="pdp-customize-action-hint">
                                            <i class="fas fa-arrow-up"></i>
                                            {{ __('Click "Customize This Bed" above to select your options and add to cart') }}
                                        </div>
                                    @endif
                                @else
                                    <div class="pdp-cta-wrap">
                                        <button class="pdp-btn pdp-btn-disabled" disabled>
                                            <i class="fas fa-ban"></i>
                                            <span>{{ __('Out of Stock') }}</span>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="pdp-cta-wrap">
                                    <a href="{{ $item->affiliate_link }}" target="_blank" class="pdp-btn pdp-btn-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                        <span>{{ __('Buy Now') }}</span>
                                    </a>
                                </div>
                            @endif

                            {{-- Bundle Discount Offer --}}
                            @if (isset($item->bundle_discount) && !empty($item->bundle_discount))
                                @php $discountItems = $item->bundle_discount['discount_items'] ?? []; @endphp
                                @if(count($discountItems) > 0)
                                    <div style="margin-top:12px;">
                                        <button class="pdp-btn pdp-btn-gold w-100" id="avail_discount"
                                            data-bs-toggle="modal" data-bs-target="#discountModal">
                                            <i class="fas fa-gift"></i>
                                            <span>{{ __('🎁 First Time Offer — Tap to Unlock') }}</span>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        </div>

                    </div>{{-- /pdp-info-body --}}

                    {{-- ⑥ META STRIP ─────────────────────────── --}}
                    <div class="pdp-meta-strip">
                        <div class="pdp-meta-grid">
                            @if ($item->brand_id)
                                <div class="pdp-meta-item">
                                    <div class="pdp-meta-icon"><i class="fas fa-copyright"></i></div>
                                    <div class="pdp-meta-content">
                                        <span class="meta-label">{{ __('Brand') }}</span>
                                        <div class="meta-val">
                                            <a href="{{ route('front.catalog') . '?brand=' . $item->brand->slug }}">{{ $item->brand->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="pdp-meta-item">
                                <div class="pdp-meta-icon"><i class="fas fa-th-large"></i></div>
                                <div class="pdp-meta-content">
                                    <span class="meta-label">{{ __('Category') }}</span>
                                    <div class="meta-val">
                                        <a href="{{ route('front.catalog') . '?category=' . $item->category->slug }}">{{ $item->category->name }}</a>
                                        @if ($item->subcategory->name) /
                                            <a href="{{ route('front.catalog') . '?subcategory=' . $item->subcategory->slug }}">{{ $item->subcategory->name }}</a>
                                        @endif
                                        @if ($item->childcategory->name) /
                                            <a href="{{ route('front.catalog') . '?childcategory=' . $item->childcategory->slug }}">{{ $item->childcategory->name }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($item->tags)
                                <div class="pdp-meta-item" style="grid-column:1/-1;">
                                    <div class="pdp-meta-icon"><i class="fas fa-tags"></i></div>
                                    <div class="pdp-meta-content">
                                        <span class="meta-label">{{ __('Tags') }}</span>
                                        <div class="meta-val" style="margin-top:4px;">
                                            @foreach (explode(',', $item->tags) as $tag)
                                                <a href="{{ route('front.catalog') . '?tag=' . trim($tag) }}" class="pdp-tag">{{ trim($tag) }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($item->item_type == 'normal')
                                <div class="pdp-meta-item">
                                    <div class="pdp-meta-icon"><i class="fas fa-barcode"></i></div>
                                    <div class="pdp-meta-content">
                                        <span class="meta-label">{{ __('SKU') }}</span>
                                        <div class="meta-val"><span class="pdp-sku-pill"><span>#{{ $item->sku }}</span></span></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Trust Badges --}}
                        <div class="pdp-trust-row">
                            <div class="pdp-trust-badge"><i class="fas fa-shield-alt"></i>{{ __('Secure Checkout') }}</div>
                            <div class="pdp-trust-badge"><i class="fas fa-truck"></i>{{ __('Fast Delivery') }}</div>
                            <div class="pdp-trust-badge"><i class="fas fa-undo-alt"></i>{{ __('Easy Returns') }}</div>
                            <div class="pdp-trust-badge"><i class="fas fa-headset"></i>{{ __('24/7 Support') }}</div>
                        </div>
                    </div>

                </div>{{-- /pdp-info-card --}}
            </div>{{-- /info col --}}

        </div>{{-- /row pdp-main-grid --}}

        {{-- ══════════════════════════════════════════════
             PRODUCT DETAILS TABS
        ══════════════════════════════════════════════ --}}
        <div class="pdp-details-section" id="pdp-details" style="margin-bottom: 40px;">
            <h2 class="pdp-section-heading">
                <span class="heading-icon"><i class="fas fa-info-circle"></i></span>
                {{ __('Product Details') }}
            </h2>

            <ul class="pdp-tab-nav nav" id="pdpTabNav" role="tablist">
                <li role="presentation">
                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        <i class="fas fa-align-left"></i>{{ __('Description') }}
                    </a>
                </li>
                <li role="presentation">
                    <a class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button" role="tab">
                        <i class="fas fa-list-ul"></i>{{ __('Specifications') }}
                    </a>
                </li>
            </ul>

            <div class="pdp-tab-content tab-content">
                {{-- Description --}}
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    {!! $item->details !!}
                </div>

                {{-- Specifications --}}
                <div class="tab-pane fade" id="specification" role="tabpanel">
                    @if ($sec_name)
                        <table class="pdp-spec-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Specification') }}</th>
                                    <th>{{ __('Details') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (array_combine($sec_name, $sec_details) as $sname => $sdetail)
                                    <tr>
                                        <td class="spec-key">{{ $sname }}</td>
                                        <td>{{ $sdetail }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="pdp-no-spec">
                            <i class="fas fa-clipboard-list"></i>
                            {{ __('No specifications available for this product.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Product Variations Card (customization options) --}}
        @if (!empty($item->variations['customization_level']) || (!empty($item->variations['custom_text'])))
        <h2 class="pdp-section-heading">
            <span class="heading-icon"><i class="fas fa-sliders-h"></i></span>
            {{ __('Product Variations & Customisation') }}
        </h2>
        <div class="pdp-variations-card" style="margin-top: 0; margin-bottom: 40px;">
            <div class="pdp-variations-body">

                @if (!empty($item->variations['customization_level']))
                    <div class="pdp-custom-level-badge">
                        <i class="fas fa-star"></i>
                        {{ ucfirst(str_replace('_', ' ', $item->variations['customization_level'])) }}
                    </div>

                    @if (in_array($item->variations['customization_level'], ['customizable', 'partial_customizable']))
                        <h6 style="font-size:14px; font-weight:700; color:var(--text-900); margin-bottom:14px;">
                            <i class="fas fa-pencil-alt me-2" style="color:var(--primary);"></i>{{ __('Add Your Customisation Preferences') }}
                        </h6>

                        <div class="mb-3">
                            <label for="preferences" style="font-size:13px; font-weight:600; color:var(--text-700); display:block; margin-bottom:6px;">{{ __('Describe your preferences') }}</label>
                            <textarea name="preferences" id="preferences" rows="3"
                                class="form-control"
                                style="border:2px solid var(--border); border-radius:var(--radius-sm); padding:12px; font-size:14px; resize:none; transition:var(--transition);"
                                placeholder="{{ __('Add notes about text placement, design ideas, colours, or layout…') }}">{{ old('preferences') }}</textarea>
                        </div>

                        @if ($item->variations['customization_level'] !== 'partial_customizable')
                            <div class="pdp-upload-zone" onclick="document.getElementById('sample_images').click()">
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <div style="font-size:14px; font-weight:600; color:var(--text-700); margin-bottom:4px;">{{ __('Upload Reference Images') }}</div>
                                <div style="font-size:12px; color:var(--text-300);">{{ __('JPEG, PNG supported — click or drag & drop') }}</div>
                                <input type="file" name="sample_images[]" id="sample_images" class="d-none" multiple>
                            </div>
                            <div id="preview-area" class="mt-3 d-flex flex-wrap gap-2"></div>
                            <div id="shared-progress-wrapper" class="progress mt-2" style="display: none !important;">
                                <div id="shared-progress-bar" class="progress-bar" style="width:0%;" role="progressbar">0%</div>
                            </div>
                            <small class="text-muted d-block mt-2" style="font-size:11px;">{{ __('You can upload multiple images') }}</small>
                        @endif
                    @endif
                @endif

                @if (!empty($item->variations['custom_text']))
                    <div class="d-flex align-items-center" style="background:rgba(0,123,255,.05); border:1px solid rgba(0,123,255,.2); border-radius:var(--radius-sm); padding:12px 14px; font-size:13px; color:var(--text-700); margin-top:14px;">
                        <span style="display:flex; justify-content:center; align-items:center; width:24px; height:24px; background:#007bff; color:#fff; border-radius:6px; margin-right:12px; flex-shrink:0;">
                            <i class="fas fa-info" style="font-size: 12px;"></i>
                        </span>
                        <div>
                            <strong>{{ __('Important Note:') }}</strong> {{ $item->variations['custom_text'] }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════
             RELATED PRODUCTS
        ══════════════════════════════════════════════ --}}
        @if (count($related_items) > 0)
        <div class="pdp-related-section">
            <div class="section-title">
                <h2 class="h3">{{ __('You May Also Like') }}</h2>
            </div>

            <div class="relatedproductslider owl-carousel">
                @foreach ($related_items as $related)
                    <div class="slider-item">
                        <div class="product-card">
                            <div class="product-thumb">
                                @if (!$related->is_stock())
                                    <div class="product-badge bg-secondary border-default text-body">
                                        {{ __('out of stock') }}
                                    </div>
                                @endif

                                @php $discPct = PriceHelper::DiscountPercentage($related); @endphp
                                @if($discPct)
                                    <div class="product-badge bg-warning" style="background-color:#daa520 !important;">-{{ $discPct }}</div>
                                @endif
                                <img class="lazy" data-src="{{ url('assets/img/' . $related->thumbnail) }}" alt="{{ $related->name }}">
                                <div class="product-button-group">
                                    <a class="product-button wishlist_store"
                                        href="{{ route('user.wishlist.store', $related->id) }}"
                                        title="{{ __('Wishlist') }}"><i class="icon-heart"></i></a>
                                    <a class="product-button"
                                        href="{{ route('front.product', $related->slug) }}"
                                        title="{{ __('Details') }}"><i class="icon-search"></i></a>
                                    @include('includes.item_footer', ['sitem' => $related])
                                </div>
                            </div>
                            <div class="product-card-body">
                                <div class="product-category"><a
                                        href="{{ route('front.catalog') . '?category=' . $related->category->slug }}">{{ $related->category->name }}</a>
                                </div>
                                <h3 class="product-title"><a
                                        href="{{ route('front.product', $related->slug) }}">
                                        {{ Str::limit($related->name, 35) }}
                                    </a></h3>
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
        @endif

    </div>{{-- /container --}}
</div>{{-- /pdp-page-wrapper --}}

{{-- ══════════════════════════════════════════════
     DISCOUNT MODAL
══════════════════════════════════════════════ --}}
@if (isset($item->bundle_discount) && !empty($item->bundle_discount))
    @php
        $discountItems  = $item->bundle_discount['discount_items']     ?? [];
        $discountPrices = $item->bundle_discount['discountItems_price'] ?? [];
    @endphp
    @if(count($discountItems) > 0)
        <div class="modal fade pdp-modal" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="discountModalLabel">
                            🎁 {{ __('First Time Offer') }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p style="font-size:14px; color:var(--text-500); margin-bottom:20px;">
                            <i class="fas fa-clock me-2" style="color:var(--gold-dark);"></i>
                            {{ __('Hurry! Limited time bundle discount — pick a tier below') }}
                        </p>
                        <div class="d-flex flex-wrap gap-3" id="discount-options">
                            @for ($i = 0; $i < count($discountItems); $i++)
                                <label class="pdp-offer-card">
                                    <input type="radio" name="discount_selected"
                                        value="{{ $i }}"
                                        data-pct="{{ $discountPrices[$i] ?? 0 }}"
                                        data-label="{{ $discountItems[$i] }}"
                                        class="d-none" />
                                    <div class="pdp-discount-tile">
                                        <div class="tile-qty">{{ __('Buy') }} {{ $discountItems[$i] }}</div>
                                        <div class="tile-save">{{ __('Save') }}</div>
                                        <div class="tile-pct">{{ number_format($discountPrices[$i] ?? 0) }}%</div>
                                    </div>
                                </label>
                            @endfor
                        </div>
                        <div id="discount-no-selection-alert" class="mt-3 d-none"
                            style="background:rgba(214,48,49,.08); border:1px solid rgba(214,48,49,.2); border-radius:var(--radius-sm); padding:10px 14px; font-size:13px; color:var(--danger); font-weight:600;">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Please select a discount tier first.') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="pdp-btn pdp-btn-primary" id="applyDiscountBtn" style="flex:none; min-width:auto; padding:12px 24px;">
                            <i class="fas fa-check me-1"></i>{{ __('Apply Offer') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

{{-- ══════════════════════════════════════════════
     REVIEW MODAL
══════════════════════════════════════════════ --}}
@auth
    <form class="modal fade pdp-review-modal ratingForm" action="{{ route('front.review.submit') }}" method="post" id="leaveReview" tabindex="-1">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Leave a Review') }}</h4>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:28px;">
                    @php $user = Auth::user(); @endphp
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="review-name" style="font-size:13px; font-weight:600; color:var(--text-700); margin-bottom:6px; display:block;">{{ __('Your Name') }}</label>
                                <input class="form-control" type="text" id="review-name" value="{{ $user->first_name }}" required style="border:2px solid var(--border); border-radius:var(--radius-sm); padding:10px 14px;">
                            </div>
                        </div>
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="review-email" style="font-size:13px; font-weight:600; color:var(--text-700); margin-bottom:6px; display:block;">{{ __('Your Email') }}</label>
                                <input class="form-control" type="email" id="review-email" value="{{ $user->email }}" required style="border:2px solid var(--border); border-radius:var(--radius-sm); padding:10px 14px;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="review-subject" style="font-size:13px; font-weight:600; color:var(--text-700); margin-bottom:6px; display:block;">{{ __('Subject') }}</label>
                                <input class="form-control" type="text" name="subject" id="review-subject" required style="border:2px solid var(--border); border-radius:var(--radius-sm); padding:10px 14px;">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="review-rating" style="font-size:13px; font-weight:600; color:var(--text-700); margin-bottom:6px; display:block;">{{ __('Rating') }}</label>
                                <select name="rating" class="form-control" id="review-rating" style="border:2px solid var(--border); border-radius:var(--radius-sm); padding:10px 14px;">
                                    <option value="5">5 {{ __('Stars') }} ⭐⭐⭐⭐⭐</option>
                                    <option value="4">4 {{ __('Stars') }} ⭐⭐⭐⭐</option>
                                    <option value="3">3 {{ __('Stars') }} ⭐⭐⭐</option>
                                    <option value="2">2 {{ __('Stars') }} ⭐⭐</option>
                                    <option value="1">1 {{ __('Star') }}  ⭐</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review-message" style="font-size:13px; font-weight:600; color:var(--text-700); margin-bottom:6px; display:block;">{{ __('Your Review') }}</label>
                        <textarea class="form-control" name="review" id="review-message" rows="5" required
                            style="border:2px solid var(--border); border-radius:var(--radius-sm); padding:12px 14px; resize:none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background:var(--bg-soft); border-top:1px solid var(--border); padding:18px 28px;">
                    <button class="pdp-btn pdp-btn-primary" type="submit" style="flex:none; min-width:auto; padding:12px 28px;">
                        <i class="fas fa-paper-plane me-2"></i>{{ __('Submit Review') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endauth

{{-- ══════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════ --}}
<script>
// ── File Upload Preview ──────────────────────────────────────────
const dt = new DataTransfer();

document.getElementById('sample_images')?.addEventListener('change', function(e) {
    const input       = e.target;
    const previewArea = document.getElementById('preview-area');
    const progressWrap = document.getElementById('shared-progress-wrapper');
    const progressBar  = document.getElementById('shared-progress-bar');

    if (progressBar) { progressBar.style.width = '0%'; progressBar.innerText = '0%'; progressBar.classList.remove('bg-success'); }
    if (progressWrap) progressWrap.style.display = 'block';

    Array.from(input.files).forEach((file) => {
        if ([...dt.files].some(f => f.name === file.name && f.size === file.size)) return;
        dt.items.add(file);

        const container = document.createElement('div');
        container.className = 'd-inline-block text-center position-relative';
        container.style.cssText = 'width:100px;height:100px;margin:4px;border:2px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;padding:4px;background:#fff;';

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.style.cssText = 'position:absolute;top:4px;right:4px;border:none;background:var(--danger);color:#fff;cursor:pointer;width:22px;height:22px;border-radius:50%;font-size:14px;line-height:18px;z-index:10;padding:0;';
        removeBtn.title = 'Remove';

        removeBtn.addEventListener('click', function() {
            const newDt = new DataTransfer();
            [...dt.files].forEach(f => { if (!(f.name === file.name && f.size === file.size)) newDt.items.add(f); });
            dt.items.clear();
            [...newDt.files].forEach(f => dt.items.add(f));
            input.files = dt.files;
            container.remove();
        });

        container.appendChild(removeBtn);

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            const img = document.createElement('img');
            img.style.cssText = 'max-width:100%;max-height:100%;border-radius:4px;';
            reader.onload = (e) => img.src = e.target.result;
            reader.readAsDataURL(file);
            container.appendChild(img);
        } else {
            const icon = document.createElement('i');
            const ext  = file.name.split('.').pop().toLowerCase();
            icon.className = ext === 'pdf' ? 'fas fa-file-pdf fa-2x text-danger' :
                             ['doc','docx'].includes(ext) ? 'fas fa-file-word fa-2x text-primary' :
                             'fas fa-file-alt fa-2x text-secondary';
            icon.style.cssText = 'display:block;margin:20px auto 6px;';
            const label = document.createElement('small');
            label.innerText = file.name;
            label.style.cssText = 'font-size:9px;word-break:break-word;display:block;';
            container.appendChild(icon);
            container.appendChild(label);
        }

        previewArea.appendChild(container);
    });

    input.files = dt.files;

    if (progressBar) {
        let percent = 0;
        const interval = setInterval(() => {
            percent += 5;
            progressBar.style.width = percent + '%';
            progressBar.innerText   = percent + '%';
            if (percent >= 100) {
                clearInterval(interval);
                progressBar.classList.add('bg-success');
                progressBar.innerText = 'Done ✓';
                setTimeout(() => { if (progressWrap) progressWrap.style.display = 'none'; }, 600);
            }
        }, 25);
    }
});

// ── Gallery Navigation on Attribute Change ──────────────────────
const assetBaseUrl = "{{ url('assets/img') }}";
document.addEventListener('DOMContentLoaded', function() {
    const gallery = $('#product-gallery');
    document.querySelectorAll('.attribute_option').forEach(select => {
        select.addEventListener('change', function() {
            const selected      = this.options[this.selectedIndex];
            const optionId      = selected.getAttribute('data-href');
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
            if (foundIndex !== -1) gallery.trigger('to.owl.carousel', [foundIndex, 300, true]);
        });
    });
});

// ── Discount Card Logic ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    const offerCards       = document.querySelectorAll('.pdp-offer-card');
    const noSelectionAlert = document.getElementById('discount-no-selection-alert');
    const availBtn         = document.getElementById('avail_discount');

    offerCards.forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        const tile  = label.querySelector('.pdp-discount-tile');
        if (!radio || !tile) return;

        radio.addEventListener('change', () => {
            offerCards.forEach(l => { const t = l.querySelector('.pdp-discount-tile'); if (t) t.style.cssText = ''; });
            if (noSelectionAlert) noSelectionAlert.classList.add('d-none');
        });

        if (radio.checked) tile.style.borderColor = 'var(--primary)';
    });

    const applyBtn = document.getElementById('applyDiscountBtn');
    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            const selectedRadio = document.querySelector('input[name="discount_selected"]:checked');

            if (!selectedRadio) {
                if (noSelectionAlert) noSelectionAlert.classList.remove('d-none');
                return;
            }

            const discountPct   = parseFloat(selectedRadio.getAttribute('data-pct') || '0');
            const discountLabel = selectedRadio.getAttribute('data-label') || '';

            const qtyInput     = document.querySelector('.qtyValue.cart-amount');
            const qtyThreshold = parseInt(discountLabel, 10);
            if (!isNaN(qtyThreshold) && qtyThreshold >= 1 && qtyInput) qtyInput.value = qtyThreshold;

            window._activeDiscountPct = discountPct;
            if (typeof window.getData === 'function') window.getData(0);

            if (availBtn) {
                availBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i><span>{{ __("Offer Applied ✓") }}</span>';
                availBtn.classList.remove('pdp-btn-gold', 'w-100');
                availBtn.classList.add('pdp-btn-primary');
                availBtn.style.animation = 'none';
            }

            if (document.activeElement && document.activeElement !== document.body) document.activeElement.blur();

            const modalEl = document.getElementById('discountModal');
            if (modalEl && typeof bootstrap !== 'undefined') bootstrap.Modal.getOrCreateInstance(modalEl).hide();
        });
    }

    const discountModalEl = document.getElementById('discountModal');
    if (discountModalEl) {
        discountModalEl.addEventListener('show.bs.modal', function() {
            if (noSelectionAlert) noSelectionAlert.classList.add('d-none');
        });
    }
});

// ── Attribute Validation ─────────────────────────────────────────
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
        if (!validateAttributeOptions()) { e.preventDefault(); e.stopPropagation(); }
    });

    document.getElementById('but_to_cart')?.addEventListener('click', function(e) {
        if (!validateAttributeOptions()) { e.preventDefault(); e.stopPropagation(); }
    });

    document.querySelectorAll('.attribute_option').forEach(function(select) {
        select.addEventListener('change', function() {
            if (select.value) select.classList.remove('is-invalid');
        });
    });
});
</script>
@endsection
