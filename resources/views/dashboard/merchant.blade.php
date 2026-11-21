<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Merchant - Printar</title>
    <meta name="description" content="Dashboard merchant Printar.">

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
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
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

        /* Hero */
        .hero-card {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: var(--radius);
            padding: 28px 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .hero-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2b7de0, #5fa8f5, #2b7de0);
            border-radius: var(--radius) var(--radius) 0 0;
        }
        .hero-card h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a3a5c;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .hero-card h1 span { color: #2b7de0; }
        .hero-card p {
            color: #6b829e;
            font-size: .88rem;
            margin-top: 6px;
        }

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            padding: 20px;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(30, 60, 100, 0.12);
        }
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: grid; place-items: center;
            color: #fff;
            flex-shrink: 0;
        }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
        .stat-icon.green { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); box-shadow: 0 4px 12px rgba(139,92,246,0.3); }
        .stat-icon.orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 12px rgba(245,158,11,0.3); }

        .stat-value { font-size: 1.5rem; font-weight: 700; color: #1a3a5c; line-height: 1.1; letter-spacing: -0.02em; margin-bottom: 2px; }
        .stat-label { font-size: .78rem; color: #7a94b0; font-weight: 500; }
        .stat-meta { font-size: .7rem; color: #94a8bf; margin-top: 4px; }
        .stat-meta b { color: #2b7de0; font-weight: 600; }

        /* Panels */
        .panel {
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            margin-bottom: 24px;
        }
        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(90, 130, 175, 0.12);
        }
        .panel-head h3 {
            font-size: .92rem;
            font-weight: 700;
            color: #1a3a5c;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .panel-head h3 svg { width: 18px; height: 18px; color: #2b7de0; }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        thead th {
            text-align: left;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #94a8bf;
            padding: 13px 18px;
            border-bottom: 1px solid rgba(90, 130, 175, 0.12);
            background: rgba(235, 244, 255, 0.4);
            white-space: nowrap;
        }
        tbody td {
            padding: 13px 18px;
            font-size: .84rem;
            color: #3e5875;
            border-bottom: 1px solid rgba(90, 130, 175, 0.08);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(225, 239, 255, 0.55); }
        .row-number { color: #94a8bf; font-weight: 600; font-size: .78rem; }
        .order-num { font-weight: 600; color: #2b7de0; font-size: .82rem; }
        .money { font-weight: 600; color: #1a3a5c; white-space: nowrap; }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: .72rem;
            font-weight: 600;
            text-transform: capitalize;
            white-space: nowrap;
        }
        .status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .status-pending { color: #d99a1a; background: rgba(217, 154, 26, 0.12); }
        .status-success { color: #16a36a; background: rgba(22, 163, 106, 0.1); }
        .status-danger  { color: #e05555; background: rgba(224, 85, 85, 0.1); }
        .status-info    { color: #2b7de0; background: rgba(43, 125, 224, 0.1); }
        .status-neutral { color: #7a94b0; background: rgba(122, 148, 176, 0.1); }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: .74rem;
            font-weight: 600;
            color: #2b7de0;
            background: rgba(43, 125, 224, 0.08);
            border: 1px solid rgba(43, 125, 224, 0.18);
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-detail:hover { background: #2b7de0; color: #fff; border-color: #2b7de0; }
        .btn-detail svg { width: 12px; height: 12px; }

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #94a8bf;
            font-size: .88rem;
        }

        /* Quick Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            padding: 20px;
        }
        .menu-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-decoration: none;
            color: #3e5875;
            transition: all .2s ease;
        }
        .menu-card:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(43, 125, 224, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 60, 100, 0.08);
        }
        .menu-icon {
            width: 40px; height: 40px;
            display: grid; place-items: center;
            border-radius: 10px;
            background: rgba(43, 125, 224, 0.1);
            color: #2b7de0;
            flex-shrink: 0;
        }
        .menu-icon svg { width: 20px; height: 20px; }
        .menu-card .menu-title { font-size: .85rem; font-weight: 600; color: #1a3a5c; }
        .menu-card .menu-badge {
            margin-left: auto;
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            background: #e05555;
            color: #fff;
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
            .hero-card { padding: 20px; }
            .hero-card h1 { font-size: 1.3rem; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .stat-card { padding: 14px; }
            .stat-value { font-size: 1.2rem; }
            .panel-head { padding: 14px; }
            thead th, tbody td { padding: 10px 14px; }
            .top-bar { margin-bottom: 12px; }
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
                    <a href="{{ route('merchant.dashboard') }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.shops.index') }}">
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
                        {{-- PERBAIKAN: Menggunakan ?? 0 agar tidak error jika variabel tidak dikirim Controller --}}
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
                <button class="icon-btn" aria-label="Notifikasi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    {{-- PERBAIKAN: Menggunakan ?? 0 --}}
                    @if (($unreadCount ?? 0) > 0)
                        <span class="notif-dot"></span>
                    @endif
                </button>
                <div class="profile-btn">
                    <span class="avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>

            <!-- Hero -->
            <div class="hero-card">
                <h1>Selamat Datang, <span>{{ auth()->user()->name }}!</span></h1>
                <p>Berikut ringkasan toko dan pesanan Anda di platform Printar.</p>
            </div>

            <!-- Stat Grid: Ringkasan Toko -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($totalShops, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Toko</div>
                    <div class="stat-meta"><b>{{ number_format($activeShops, 0, ',', '.') }}</b> aktif</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($totalServices, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Layanan</div>
                    <div class="stat-meta"><b>{{ number_format($activeServices, 0, ',', '.') }}</b> aktif</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon purple">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($totalOrders, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-meta"><b>{{ number_format($activeOrders, 0, ',', '.') }}</b> aktif &middot; <b>{{ number_format($completedOrders, 0, ',', '.') }}</b> selesai</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon orange">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <div class="stat-value">Rp {{ number_format((float) $totalRevenue, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-meta">{{ number_format($waitingPayments, 0, ',', '.') }} pembayaran menunggu</div>
                </div>
            </div>

            <!-- Tabel Pesanan Terbaru -->
            <div class="panel">
                <div class="panel-head">
                    <h3>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        5 Pesanan Terbaru
                    </h3>
                    <a href="{{ route('merchant.orders.index') }}" class="btn-detail">
                        Lihat Semua
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

                @if ($latestOrders->isEmpty())
                    <div class="empty-state">Belum ada pesanan masuk.</div>
                @else
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No.</th>
                                    <th>Nomor Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Toko</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestOrders as $index => $order)
                                    <tr>
                                        <td><span class="row-number">{{ $index + 1 }}</span></td>
                                        <td><span class="order-num">{{ $order->order_number }}</span></td>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                        <td>{{ $order->shop->name ?? '-' }}</td>
                                        <td><span class="money">Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</span></td>
                                        <td>
                                            @php
                                                $os = strtolower($order->status);
                                                $orderClass = match(true) {
                                                    in_array($os, ['pending', 'waiting', 'menunggu']) => 'status-pending',
                                                    in_array($os, ['completed', 'success', 'selesai', 'paid', 'lunas']) => 'status-success',
                                                    in_array($os, ['cancelled', 'rejected', 'dibatalkan', 'ditolak', 'failed']) => 'status-danger',
                                                    in_array($os, ['processing', 'active', 'aktif', 'diproses', 'confirmed', 'dikonfirmasi', 'ready', 'siap diambil', 'shipped', 'dikirim']) => 'status-info',
                                                    default => 'status-neutral',
                                                };
                                            @endphp
                                            <span class="status {{ $orderClass }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                        <td style="text-align: right;">
                                            <a href="{{ route('merchant.orders.show', $order->id) }}" class="btn-detail">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Menu Merchant -->
            <div class="panel">
                <div class="panel-head">
                    <h3>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Menu Cepat Merchant
                    </h3>
                </div>
                <div class="menu-grid">
                    <a href="{{ route('merchant.shops.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        </span>
                        <span class="menu-title">Kelola Toko</span>
                    </a>

                    <a href="{{ route('merchant.services.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        </span>
                        <span class="menu-title">Kelola Layanan</span>
                    </a>

                    <a href="{{ route('merchant.orders.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </span>
                        <span class="menu-title">Pesanan Masuk</span>
                    </a>

                    <a href="{{ route('merchant.notifications.index') }}" class="menu-card">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </span>
                        <span class="menu-title">Notifikasi</span>
                        {{-- PERBAIKAN: Menggunakan ?? 0 --}}
                        @if (($unreadCount ?? 0) > 0)
                            <span class="menu-badge">{{ $unreadCount }}</span>
                        @endif
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
