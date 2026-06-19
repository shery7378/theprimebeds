<script>
    if (localStorage.getItem('sidebarState') === 'open') {
        document.documentElement.classList.add('sidebar-active');
    }
</script>
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
<style>
    /* ── Palette & Typography ─────────────────── */
    :root {
        --white:       #ffffff;
        --bg:          #f5f7fa;
        --surface:     #ffffff;
        --border:      #e8ecf0;
        --text-dark:   #1a1f2e;
        --text-mid:    #4b5563;
        --text-light:  #9ca3af;
        --accent:      var(--primary-color, #8C7558);
        --accent-hover:var(--primary-color, #8C7558);
        --accent-soft: #fcf9f2;
        --accent-mid:  #e9e0d2;
    }

    body { overflow-x: hidden; }

    .dash-wrapper {
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
    }

    @media (min-width: 992px) {
        body.sidebar-active .dash-wrapper,
        html.sidebar-active .dash-wrapper {
            padding-left: 300px;
        }
    }

    /* ── Sidebar (Global Off-canvas) ───────────────────────── */
    .sidebar {
        background: var(--surface);
        border: 1px solid var(--border);
        position: fixed;
        top: 130px;
        left: -320px;
        bottom: 0;
        width: 280px;
        height: calc(100vh - 130px);
        z-index: 9999;
        border-radius: 0;
        margin: 0;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
    }
        
    .sidebar.active {
        left: 0;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: transparent;
        z-index: 9998;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .btn-sidebar-toggle {
        background: none;
        border: none;
        font-size: 24px;
        color: var(--text-dark);
        cursor: pointer;
        padding: 4px 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: background-color 0.2s;
    }

    .btn-sidebar-toggle:hover {
        background-color: var(--accent-soft);
        color: var(--accent);
    }

    .user-avatar-edit:hover {
        transform: scale(1.1);
        color: var(--accent) !important;
    }

    .sidebar-profile {
        background: var(--accent);
        padding: 1.75rem 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-align: center;
    }

    .avatar-ring {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        border: 2.5px solid rgba(255,255,255,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 1px;
    }

    .sidebar-name {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .sidebar-since {
        font-size: 12px;
        color: rgba(255,255,255,0.65);
        margin: 0;
    }

    .sidebar-nav {
        padding: 0.75rem 0.75rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 13.5px;
        color: var(--text-mid);
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        position: relative;
    }

    .nav-link:hover {
        background: var(--bg);
        color: var(--text-dark);
    }

    .nav-link.active {
        background: var(--accent-soft);
        color: var(--accent);
        font-weight: 600;
    }

    .nav-link i { font-size: 17px; flex-shrink: 0; }

    .nav-badge {
        margin-left: auto;
        background: var(--accent-soft);
        color: var(--accent);
        font-size: 11px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 20px;
        min-width: 22px;
        text-align: center;
    }

    .nav-link.active .nav-badge {
        background: var(--accent-mid);
    }

    .nav-divider {
        height: 1px;
        background: var(--border);
        margin: 0.5rem 0.75rem;
    }
</style>
@endpush

{{-- ── Sidebar ── --}}
<aside class="sidebar">
    <div class="sidebar-profile">
        <div class="user-avatar-wrap" style="position: relative; display: inline-block;">
            @if(auth()->user()->photo)
                <img id="avater_photo_view" src="{{ url('assets/img/'.auth()->user()->photo) }}" alt="Avatar" class="avatar-ring" style="object-fit: cover; display: block;">
            @else
                <div class="avatar-ring">
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                </div>
            @endif
            <button type="button" class="user-avatar-edit" onclick="document.getElementById('user_avatar_upload').click()" title="{{ __('Edit Avatar') }}" style="position: absolute; bottom: 2px; right: 2px; width: 22px; height: 22px; background: #white; background-color: #fff; border-radius: 50%; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; color: #4b5563; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 0; z-index: 10; transition: transform 0.2s, color 0.2s;">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </button>
        </div>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" id="user_avatar_form" style="display:none;">
            @csrf
            <input type="file" name="photo" id="user_avatar_upload" accept="image/jpeg,image/jpg,image/png,image/svg+xml" onchange="document.getElementById('user_avatar_form').submit();">
            <input type="hidden" name="first_name" value="{{ auth()->user()->first_name }}">
            <input type="hidden" name="last_name" value="{{ auth()->user()->last_name }}">
            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
            <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
        </form>

        <p class="sidebar-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
        <p class="sidebar-since">{{ __('Joined') }} {{ auth()->user()->created_at->format('M Y') }}</p>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="ti ti-layout-dashboard"></i>
            {{ __('Dashboard') }}
        </a>
        <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <i class="ti ti-user"></i>
            {{ __('Profile') }}
        </a>
        <a href="{{ route('user.ticket') }}" class="nav-link {{ request()->routeIs('user.ticket*') ? 'active' : '' }}">
            <i class="ti ti-headset"></i>
            {{ __('Support Tickets') }}
        </a>

        <div class="nav-divider"></div>

        <a href="{{ route('user.order.index') }}" class="nav-link {{ request()->routeIs('user.order*') ? 'active' : '' }}">
            <i class="ti ti-shopping-bag"></i>
            {{ __('Orders') }}
            @if(auth()->user()->orders->count() > 0)
                <span class="nav-badge">{{ auth()->user()->orders->count() }}</span>
            @endif
        </a>
        <a href="{{ route('user.address') }}" class="nav-link {{ request()->routeIs('user.address*') ? 'active' : '' }}">
            <i class="ti ti-map-pin"></i>
            {{ __('Addresses') }}
        </a>
        <a href="{{ route('user.wishlist.index') }}" class="nav-link {{ request()->routeIs('user.wishlist*') ? 'active' : '' }}">
            <i class="ti ti-heart"></i>
            {{ __('Wishlist') }}
        </a>

        @if(auth()->check() && auth()->user()->is_merchant == 1)
            <div class="nav-divider"></div>

            <a href="{{ route('user.merchant.dashboard') }}" class="nav-link">
                <i class="ti ti-store"></i>
                {{ __('Merchant Dashboard') }}
            </a>
        @endif
    </nav>
</aside>

<div id="sidebarOverlay" class="sidebar-overlay"></div>

<script>
    // Load persisted state instantly to prevent layout shift or visual flashing
    if (localStorage.getItem('sidebarState') === 'open') {
        document.querySelector('.sidebar').classList.add('active');
        document.getElementById('sidebarOverlay').classList.add('active');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const header = document.querySelector('.site-header');

        function adjustSidebarPosition() {
            if (header && sidebar) {
                const headerRect = header.getBoundingClientRect();
                const topOffset = Math.max(0, headerRect.bottom);
                sidebar.style.top = topOffset + 'px';
                sidebar.style.height = 'calc(100vh - ' + topOffset + 'px)';
            }
        }

        function toggleSidebar() {
            if (sidebar && overlay) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.classList.toggle('sidebar-active');
                document.documentElement.classList.toggle('sidebar-active');
                
                if (sidebar.classList.contains('active')) {
                    localStorage.setItem('sidebarState', 'open');
                    adjustSidebarPosition();
                } else {
                    localStorage.setItem('sidebarState', 'closed');
                }
            }
        }

        if(toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
        if(overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Adjust position dynamically when window is resized or scrolled
        window.addEventListener('resize', function() {
            if (sidebar && sidebar.classList.contains('active')) {
                adjustSidebarPosition();
            }
        });
        window.addEventListener('scroll', function() {
            if (sidebar && sidebar.classList.contains('active')) {
                adjustSidebarPosition();
            }
        });

        // Set initial positions if sidebar is active on load
        if (sidebar && sidebar.classList.contains('active')) {
            document.body.classList.add('sidebar-active');
            document.documentElement.classList.add('sidebar-active');
            adjustSidebarPosition();
        } else {
            document.body.classList.remove('sidebar-active');
            document.documentElement.classList.remove('sidebar-active');
        }
    });
</script>
