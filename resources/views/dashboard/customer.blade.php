<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - Printar</title>
    <meta name="description" content="Dashboard pelanggan Printar.">

    @fonts

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg: #eef4fc;
            --panel: rgba(255, 255, 255, 0.78);
            --panel-2: rgba(255, 255, 255, 0.9);
            --border: rgba(255, 255, 255, 0.92);
            --text: #1e3a5f;
            --muted: #6b829e;
            --accent: #2b7de0;
            --accent-soft: rgba(43, 125, 224, 0.12);
            --success: #16a36a;
            --warning: #d99a1a;
            --danger: #e05555;
            --radius: 16px;
            --shadow: 0 8px 32px rgba(30, 60, 100, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: "Instrument Sans", ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background:
                linear-gradient(rgba(238, 246, 255, 0.65), rgba(238, 246, 255, 0.75)),
                url('https://images.unsplash.com/photo-1562654501-a0ccc0fc3fb1?q=80&w=1920&auto=format&fit=crop') center center / cover fixed;
            color: var(--text);
            min-height: 100vh;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ---------- Layout ---------- */
        .layout { display: flex; min-height: 100vh; }

        /* ---------- Sidebar ---------- */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 24px 16px;
            overflow-y: auto;
            transition: transform .25s ease;
            z-index: 40;
            box-shadow: 4px 0 24px rgba(30, 60, 100, 0.04);
        }

        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 1.15rem;
            color: #1a3a5c;
            text-decoration: none;
            padding: 0 8px 24px;
            text-align: center;
        }
        .brand-mark {
            width: 44px; height: 44px;
            display: grid; place-items: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            box-shadow: 0 6px 16px rgba(43, 125, 224, 0.3);
            margin-bottom: 4px;
        }
        .brand-mark svg { width: 24px; height: 24px; color: #fff; }
        .brand-text { font-size: 1.2rem; letter-spacing: -0.02em; }
        .brand-sub { font-size: 0.65rem; color: #7a94b0; font-weight: 400; letter-spacing: 0.02em; }

        .nav-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #94a8bf;
            padding: 16px 12px 8px;
        }

        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 4px; }
        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: .88rem;
            color: #5a7290;
            text-decoration: none;
            transition: all .2s ease;
        }
        .nav-menu a:hover { background: rgba(43, 125, 224, 0.08); color: #2b7de0; }
        .nav-menu a.active {
            background: #2b7de0;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
        }
        .nav-menu a.active svg { color: #fff; }
        .nav-menu svg { width: 18px; height: 18px; flex-shrink: 0; color: #7a94b0; transition: color .2s; }

        .nav-badge {
            margin-left: auto;
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            background: #ffe6a8;
            color: #80570a;
        }
        .nav-menu a.active .nav-badge { background: rgba(255,255,255,0.25); color: #fff; }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(80, 120, 165, 0.15);
        }
        .user-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 12px;
            background: rgba(235, 244, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.9);
            margin-bottom: 12px;
        }
        .avatar {
            width: 38px; height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            display: grid; place-items: center;
            font-size: .85rem; font-weight: 700;
            background: linear-gradient(135deg, #2b7de0, #70b4f5);
            color: #fff;
            box-shadow: 0 2px 8px rgba(43, 125, 224, 0.3);
        }
        .user-chip .u-name { font-size: .85rem; font-weight: 600; color: #1a3a5c; line-height: 1.2; }
        .user-chip .u-role { font-size: .72rem; color: #7a94b0; }

        .btn-logout {
            width: 100%;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: .82rem; font-weight: 600;
            color: #6b829e;
            background: transparent;
            border: 1px solid rgba(80, 120, 165, 0.2);
            cursor: pointer;
            font-family: inherit;
            transition: all .2s ease;
        }
        .btn-logout:hover { border-color: #e05555; color: #e05555; background: rgba(224, 85, 85, 0.06); }
        .btn-logout svg { width: 16px; height: 16px; }

        /* ---------- Mobile toggle ---------- */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 16px; left: 16px;
            z-index: 60;
            width: 42px; height: 42px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            color: #1a3a5c;
            cursor: pointer;
            place-items: center;
            box-shadow: 0 4px 16px rgba(30, 60, 100, 0.1);
        }
        .mobile-toggle svg { width: 20px; height: 20px; }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(20, 40, 65, 0.3);
            backdrop-filter: blur(4px);
            z-index: 30;
        }

        /* ---------- Main ---------- */
        .main { flex: 1; min-width: 0; padding: 28px 32px 48px; }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .page-title h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a3a5c;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .page-title h1 svg { width: 24px; height: 24px; color: #2b7de0; }
        .page-title p { color: #6b829e; font-size: .85rem; margin-top: 3px; }

        .top-actions { display: flex; align-items: center; gap: 12px; }
        .icon-btn {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            display: grid; place-items: center;
            cursor: pointer;
            position: relative;
            color: #4a6a8a;
            box-shadow: 0 4px 12px rgba(30, 60, 100, 0.06);
            transition: all .2s;
            text-decoration: none;
        }
        .icon-btn:hover { background: #fff; color: #2b7de0; }
        .icon-btn svg { width: 20px; height: 20px; }
        .notif-dot {
            position: absolute;
            top: 8px; right: 8px;
            width: 8px; height: 8px;
            background: #e05555;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .profile-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 60, 100, 0.06);
            color: #1a3a5c;
            font-size: .85rem;
            font-weight: 600;
        }
        .profile-btn .avatar-sm {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2b7de0, #70b4f5);
            display: grid; place-items: center;
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
        }

        /* Cards & Grid */
        .card {
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(90, 130, 175, 0.12);
        }
        .card-header h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a3a5c;
            margin: 0;
        }
        .card-header svg { width: 20px; height: 20px; color: #2b7de0; }

        /* Menu Grid (Customer Menu) */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 14px;
        }

        .menu-card {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(90, 130, 175, 0.15);
            text-decoration: none;
            color: inherit;
            transition: all .2s ease;
            position: relative;
        }
        .menu-card:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(43, 125, 224, 0.12);
            border-color: rgba(43, 125, 224, 0.35);
        }
        .menu-icon {
            width: 44px; height: 44px;
            flex-shrink: 0;
            border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, rgba(43, 125, 224, 0.15), rgba(95, 168, 245, 0.15));
            color: #2b7de0;
        }
        .menu-icon svg { width: 22px; height: 22px; }
        .menu-text { flex: 1; min-width: 0; }
        .menu-text .m-title {
            font-size: .92rem;
            font-weight: 700;
            color: #1a3a5c;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .menu-text .m-desc {
            font-size: .78rem;
            color: #6b829e;
            line-height: 1.4;
        }
        .menu-badge {
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            background: #ffe6a8;
            color: #80570a;
            white-space: nowrap;
        }

        /* Welcome Banner */
        .welcome-banner {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 24px;
            border-radius: var(--radius);
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            color: #fff;
            box-shadow: 0 8px 24px rgba(43, 125, 224, 0.3);
            margin-bottom: 20px;
        }
        .welcome-banner .w-avatar {
            width: 54px; height: 54px;
            flex-shrink: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            display: grid; place-items: center;
            font-size: 1.2rem; font-weight: 700;
            border: 2px solid rgba(255, 255, 255, 0.4);
        }
        .welcome-banner .w-text h2 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0 0 3px;
        }
        .welcome-banner .w-text p {
            font-size: .82rem;
            opacity: .92;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                top: 0; left: 0;
                transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }
            .mobile-toggle { display: grid; }
            .overlay.show { display: block; }
            .main { padding: 80px 20px 40px; }
        }

        @media (max-width: 640px) {
            .main { padding: 76px 14px 36px; }
            .page-title h1 { font-size: 1.15rem; }
            .top-actions { gap: 8px; }
            .profile-btn span:not(.avatar-sm) { display: none; }
            .profile-btn { padding: 6px; }
            .card { padding: 18px; }
            .menu-grid { grid-template-columns: 1fr; gap: 10px; }
            .menu-card { padding: 14px; }
            .welcome-banner { padding: 16px; gap: 12px; }
            .welcome-banner .w-avatar { width: 44px; height: 44px; font-size: 1rem; }
            .welcome-banner .w-text h2 { font-size: 1rem; }
            .welcome-banner .w-text p { font-size: .78rem; }
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
    <div class="overlay" id="overlay"></div>

    @php
        $unreadCount = auth()->user()->unreadNotifications()->count();
    @endphp

    <div class="layout">
        <!-- ============ SIDEBAR CUSTOMER ============ -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/>
                    </svg>
                </span>
                <span class="brand-text">PRINTAR</span>
                <span class="brand-sub">Customer Panel</span>
            </a>

            {{-- Menu Customer --}}
            <div class="nav-label">Menu Customer</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('customer.dashboard') }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.shops.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        Cari Toko Percetakan
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.shops.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Lihat Layanan & Harga
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.orders.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Riwayat Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.addresses.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Kelola Alamat
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.notifications.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Notifikasi Pesanan
                        @if ($unreadCount > 0)
                            <span class="nav-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-chip">
                    <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <div>
                        <div class="u-name">{{ auth()->user()->name }}</div>
                        <div class="u-role">Customer</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ============ MAIN ============ -->
        <main class="main">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Dashboard Pelanggan
                    </h1>
                    <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!</p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('customer.notifications.index') }}" class="icon-btn" aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @if ($unreadCount > 0)
                            <span class="notif-dot"></span>
                        @endif
                    </a>
                    <div class="profile-btn">
                        <span class="avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="w-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="w-text">
                    <h2>Halo, {{ auth()->user()->name }}!</h2>
                    <p>Mau cetak apa hari ini? Pilih menu di bawah untuk memulai.</p>
                </div>
            </div>

            <!-- Menu Customer -->
            <div class="card">
                <div class="card-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    <h2>Menu Customer</h2>
                </div>

                <div class="menu-grid">
                    <a href="{{ route('customer.shops.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </span>
                        <div class="menu-text">
                            <div class="m-title">Cari Toko Percetakan</div>
                            <div class="m-desc">Temukan toko percetakan terdekat.</div>
                        </div>
                    </a>

                    <a href="{{ route('customer.shops.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </span>
                        <div class="menu-text">
                            <div class="m-title">Lihat Layanan & Harga</div>
                            <div class="m-desc">Cek daftar layanan dan harga cetak.</div>
                        </div>
                    </a>

                    <a href="{{ route('customer.orders.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </span>
                        <div class="menu-text">
                            <div class="m-title">Riwayat Pesanan</div>
                            <div class="m-desc">Lihat semua pesanan yang pernah dibuat.</div>
                        </div>
                    </a>

                    <a href="{{ route('customer.addresses.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </span>
                        <div class="menu-text">
                            <div class="m-title">Kelola Alamat</div>
                            <div class="m-desc">Atur alamat pengiriman dan penagihan.</div>
                        </div>
                    </a>

                    <a href="{{ route('customer.notifications.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </span>
                        <div class="menu-text">
                            <div class="m-title">
                                Notifikasi Pesanan
                                @if ($unreadCount > 0)
                                    <span class="menu-badge">{{ $unreadCount }} baru</span>
                                @endif
                            </div>
                            <div class="m-desc">Cek pembaruan status pesananmu.</div>
                        </div>
                    </a>
                </div>
            </div>

        </main>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            function openMenu() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
                toggle.setAttribute('aria-expanded', 'true');
            }
            function closeMenu() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                toggle.setAttribute('aria-expanded', 'false');
            }

            toggle.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeMenu() : openMenu();
            });
            overlay.addEventListener('click', closeMenu);

            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 1024) closeMenu();
                });
            });
        })();
    </script>
</body>
</html>
