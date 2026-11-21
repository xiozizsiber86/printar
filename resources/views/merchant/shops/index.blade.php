<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Toko - Printar Merchant</title>
    <meta name="description" content="Kelola toko Anda di Printar.">

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
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            color: #2b7de0;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(43, 125, 224, 0.25);
            text-decoration: none;
            transition: all .2s;
        }
        .btn-back:hover { background: #fff; border-color: #2b7de0; }
        .btn-back svg { width: 16px; height: 16px; }

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

        /* Alert */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: .85rem;
            font-weight: 500;
            margin-bottom: 20px;
            backdrop-filter: blur(14px);
            border: 1px solid transparent;
        }
        .alert svg { width: 18px; height: 18px; flex-shrink: 0; }
        .alert-success { color: #117a4f; background: rgba(22, 163, 106, 0.1); border-color: rgba(22, 163, 106, 0.25); }

        /* Grid Container */
        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        /* Shop Card */
        .shop-card {
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
            display: flex;
            flex-direction: column;
        }
        .shop-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(30, 60, 100, 0.12);
        }
        .shop-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(90, 130, 175, 0.12);
            background: rgba(235, 244, 255, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }
        .shop-card-header h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a3a5c;
            line-height: 1.3;
            margin: 0;
        }
        .shop-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
        }
        .shop-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            font-size: .85rem;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(90, 130, 175, 0.15);
        }
        .shop-info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .shop-info-label { color: #6b829e; font-weight: 500; flex-shrink: 0; }
        .shop-info-value { color: #1a3a5c; font-weight: 600; text-align: right; word-break: break-word; }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .status-active { color: #16a36a; background: rgba(22, 163, 106, 0.1); }
        .status-inactive { color: #e05555; background: rgba(224, 85, 85, 0.1); }

        .shop-card-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(90, 130, 175, 0.12);
            background: rgba(235, 244, 255, 0.3);
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex: 1;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 600;
            color: #2b7de0;
            background: rgba(43, 125, 224, 0.08);
            border: 1px solid rgba(43, 125, 224, 0.18);
            text-decoration: none;
            transition: all .2s;
        }
        .btn-edit:hover { background: #2b7de0; color: #fff; border-color: #2b7de0; }
        .btn-edit svg { width: 14px; height: 14px; }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 600;
            color: #e05555;
            background: rgba(224, 85, 85, 0.08);
            border: 1px solid rgba(224, 85, 85, 0.18);
            cursor: pointer;
            font-family: inherit;
            transition: all .2s;
        }
        .btn-delete:hover { background: #e05555; color: #fff; border-color: #e05555; }
        .btn-delete svg { width: 14px; height: 14px; }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: .88rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            border: none;
            text-decoration: none;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
        }
        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }
        .btn-add svg { width: 16px; height: 16px; }

        .empty-state {
            grid-column: 1 / -1;
            padding: 50px 20px;
            text-align: center;
            color: #94a8bf;
            font-size: .88rem;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.6);
            border: 1px dashed rgba(90, 130, 175, 0.2);
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
            .page-title h1 { font-size: 1.2rem; }
            .top-actions { width: 100%; justify-content: space-between; }
            .btn-back span { display: none; }
            .profile-btn span:not(.avatar-sm) { display: none; }
            .profile-btn { padding: 6px; }
            .shops-grid { grid-template-columns: 1fr; }
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

    <div class="layout">
        <!-- ============ SIDEBAR MERCHANT ============ -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/>
                    </svg>
                </span>
                <span class="brand-text">PRINTAR</span>
                <span class="brand-sub">Merchant Panel</span>
            </a>

            {{-- Menu Merchant --}}
            <div class="nav-label">Menu Merchant</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('merchant.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.shops.index') }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        Kelola Toko
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.services.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Kelola Layanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.orders.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Kelola Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.notifications.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Notifikasi
                        @if (($unreadCount ?? 0) > 0)
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
                        <div class="u-role">Merchant</div>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        Kelola Toko Saya
                    </h1>
                    <p>Kelola informasi toko percetakan Anda.</p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('merchant.dashboard') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Kembali ke Dashboard</span>
                    </a>
                    <button class="icon-btn" aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @if (($unreadCount ?? 0) > 0)
                            <span class="notif-dot"></span>
                        @endif
                    </button>
                    <div class="profile-btn">
                        <span class="avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header Action: Add Button -->
            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                <a href="{{ route('merchant.shops.create') }}" class="btn-add">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Toko
                </a>
            </div>

            <!-- Daftar Toko (Grid) -->
            <div class="shops-grid">
                @forelse ($shops as $shop)
                    <div class="shop-card">
                        <div class="shop-card-header">
                            <h3>{{ $shop->name }}</h3>
                            <span class="status {{ $shop->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $shop->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>

                        <div class="shop-card-body">
                            <div class="shop-info-row">
                                <span class="shop-info-label">Deskripsi</span>
                                <span class="shop-info-value">{{ $shop->description ?: '-' }}</span>
                            </div>
                            <div class="shop-info-row">
                                <span class="shop-info-label">Alamat</span>
                                <span class="shop-info-value">{{ $shop->address }}</span>
                            </div>
                            <div class="shop-info-row">
                                <span class="shop-info-label">Telepon</span>
                                <span class="shop-info-value">{{ $shop->phone ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="shop-card-footer">
                            <a href="{{ route('merchant.shops.edit', $shop->id) }}" class="btn-edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit Toko
                            </a>
                            <form method="POST"
                                action="{{ route('merchant.shops.destroy', $shop->id) }}"
                                onsubmit="return confirm('Yakin ingin menghapus toko ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 42px; height: 42px; margin-bottom: 10px; color: #c3d3e5;"><circle cx="12" cy="12" r="10"/><line x1="8" y1="15" x2="16" y2="15"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                        <p>Belum ada toko yang terdaftar.</p>
                    </div>
                @endforelse
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
