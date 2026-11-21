<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Printar</title>
    <meta name="description" content="Dashboard administrator Printar.">

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
            margin-bottom: 20px;
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

        /* Hero / Welcome */
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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

        .stat-trend {
            font-size: .72rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }
        .stat-trend.up { color: #10b981; background: rgba(16, 185, 129, 0.1); }

        .stat-value { font-size: 1.6rem; font-weight: 700; color: #1a3a5c; line-height: 1.1; letter-spacing: -0.02em; margin-bottom: 2px; }
        .stat-label { font-size: .78rem; color: #7a94b0; font-weight: 500; }

        .sparkline { height: 36px; width: 100%; margin-top: 12px; }
        .sparkline svg { width: 100%; height: 100%; overflow: visible; }

        /* Grid 2 col */
        .grid-2col {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 1100px) {
            .grid-2col { grid-template-columns: 1fr; }
        }

        /* Panel */
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
        .panel-head .see-all {
            font-size: .78rem;
            font-weight: 600;
            color: #2b7de0;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: gap .2s;
        }
        .panel-head .see-all:hover { gap: 8px; }
        .panel-head .see-all svg { width: 14px; height: 14px; }

        .table-wrap { overflow-x: auto; flex: 1; }
        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        thead th {
            text-align: left;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #94a8bf;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(90, 130, 175, 0.1);
            white-space: nowrap;
        }
        tbody td {
            padding: 12px 20px;
            font-size: .82rem;
            color: #3e5875;
            border-bottom: 1px solid rgba(90, 130, 175, 0.08);
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(225, 239, 255, 0.5); }
        td .order-num { font-weight: 600; color: #2b7de0; font-size: .8rem; }
        td .money { font-weight: 600; color: #1a3a5c; white-space: nowrap; }

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

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #94a8bf;
            font-size: .85rem;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Action grid */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        @media (max-width: 768px) {
            .action-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 18px 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-decoration: none;
            color: #3e5875;
            transition: all .2s ease;
            text-align: center;
        }
        .action-card:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(43, 125, 224, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 60, 100, 0.08);
        }
        .action-icon {
            width: 40px; height: 40px;
            display: grid; place-items: center;
            border-radius: 10px;
            background: rgba(43, 125, 224, 0.1);
            color: #2b7de0;
            margin-bottom: 4px;
        }
        .action-icon svg { width: 20px; height: 20px; }
        .action-card .ac-title { font-size: .8rem; font-weight: 600; color: #1a3a5c; line-height: 1.2; }

        /* Chart card */
        .chart-card {
            padding: 20px;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .chart-header h3 {
            font-size: .92rem;
            font-weight: 700;
            color: #1a3a5c;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .chart-header h3 svg { width: 18px; height: 18px; color: #2b7de0; }
        .chart-select {
            font-size: .75rem;
            font-weight: 600;
            color: #3e5875;
            padding: 4px 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(90, 130, 175, 0.2);
            cursor: pointer;
        }
        .chart-area { height: 140px; width: 100%; position: relative; }
        .chart-area svg { width: 100%; height: 100%; overflow: visible; }

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
            .stat-value { font-size: 1.3rem; }
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
        <!-- ============ SIDEBAR (VERIFIKASI MERCHANT DIHAPUS) ============ -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/>
                    </svg>
                </span>
                <span class="brand-text">PRINTAR</span>
                <span class="brand-sub">Print Your Ideas</span>
            </a>

            {{-- Utama --}}
            <div class="nav-label">Utama</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ url('/admin/dashboard') }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Kelola Pengguna
                    </a>
                </li>
            </ul>

            {{-- Verifikasi --}}
            <div class="nav-label">Verifikasi</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('admin.merchants.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        Kelola Merchant
                    </a>
                </li>
                {{-- MENU VERIFIKASI MERCHANT DIHAPUS DARI SINI --}}
                <li>
                    <a href="{{ route('admin.shops.index', ['status' => 'pending']) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        Verifikasi Toko
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index', ['status' => 'pending']) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Verifikasi Layanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payments.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        Verifikasi Pembayaran
                        @if ($waitingPayments > 0)
                            <span class="nav-badge">{{ $waitingPayments }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            {{-- Master Data --}}
            <div class="nav-label">Master Data</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('admin.categories.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><path d="M7 7h.01"/></svg>
                        Kelola Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.transactions') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        Laporan Transaksi
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="user-chip">
                    <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <div>
                        <div class="u-name">{{ auth()->user()->name }}</div>
                        <div class="u-role">Administrator</div>
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
                    {{-- Notif dot logic disesuaikan karena pendingMerchants mungkin sudah tidak dipakai di dashboard --}}
                    @if (($waitingPayments ?? 0) > 0)
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
                <h1>Selamat Datang, <span>Administrator!</span></h1>
                <p>Kelola sistem Printar dengan mudah dan efisien.</p>
            </div>

            <!-- 4 Stat Cards (dari data asli) -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </div>
                        <span class="stat-trend up">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                            12%
                        </span>
                    </div>
                    <div class="stat-value">{{ number_format($totalOrders, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                            <defs><linearGradient id="gradBlue" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#3b82f6" stop-opacity="0.3"/><stop offset="100%" stop-color="#3b82f6" stop-opacity="0"/></linearGradient></defs>
                            <path d="M0,25 Q10,22 20,20 T40,15 T60,18 T80,10 T100,5 L100,30 L0,30 Z" fill="url(#gradBlue)"/>
                            <path d="M0,25 Q10,22 20,20 T40,15 T60,18 T80,10 T100,5" fill="none" stroke="#3b82f6" stroke-width="1.5"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        </div>
                        <span class="stat-trend up">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                            8%
                        </span>
                    </div>
                    <div class="stat-value">{{ number_format($totalShops, 0, ',', '.') }}</div>
                    <div class="stat-label">Toko Terdaftar</div>
                    <div class="sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                            <defs><linearGradient id="gradGreen" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#10b981" stop-opacity="0.3"/><stop offset="100%" stop-color="#10b981" stop-opacity="0"/></linearGradient></defs>
                            <path d="M0,28 Q15,25 25,22 T45,18 T65,15 T80,8 T100,3 L100,30 L0,30 Z" fill="url(#gradGreen)"/>
                            <path d="M0,28 Q15,25 25,22 T45,18 T65,15 T80,8 T100,3" fill="none" stroke="#10b981" stroke-width="1.5"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon purple">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <span class="stat-trend up">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                            15%
                        </span>
                    </div>
                    <div class="stat-value">{{ number_format($totalUsers, 0, ',', '.') }}</div>
                    <div class="stat-label">Pengguna</div>
                    <div class="sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                            <defs><linearGradient id="gradPurple" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.3"/><stop offset="100%" stop-color="#8b5cf6" stop-opacity="0"/></linearGradient></defs>
                            <path d="M0,20 Q15,28 25,18 T45,25 T65,12 T80,15 T100,5 L100,30 L0,30 Z" fill="url(#gradPurple)"/>
                            <path d="M0,20 Q15,28 25,18 T45,25 T65,12 T80,15 T100,5" fill="none" stroke="#8b5cf6" stroke-width="1.5"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon orange">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span class="stat-trend up">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="18 15 12 9 6 15"/></svg>
                            20%
                        </span>
                    </div>
                    <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Transaksi</div>
                    <div class="sparkline">
                        <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                            <defs><linearGradient id="gradOrange" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#f59e0b" stop-opacity="0.3"/><stop offset="100%" stop-color="#f59e0b" stop-opacity="0"/></linearGradient></defs>
                            <path d="M0,22 Q10,20 20,25 T40,18 T60,12 T80,15 T100,4 L100,30 L0,30 Z" fill="url(#gradOrange)"/>
                            <path d="M0,22 Q10,20 20,25 T40,18 T60,12 T80,15 T100,4" fill="none" stroke="#f59e0b" stroke-width="1.5"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tabel Pesanan & Pembayaran Terbaru -->
            <div class="grid-2col">
                <!-- Pesanan Terbaru -->
                <div class="panel">
                    <div class="panel-head">
                        <h3>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Pesanan Terbaru
                        </h3>
                        <a href="{{ route('admin.reports.transactions') }}" class="see-all">
                            Lihat Semua
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                    @if ($latestOrders->count())
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Pengguna</th>
                                        <th>Layanan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders->take(5) as $order)
                                        <tr>
                                            <td><span class="order-num">{{ $order->order_number }}</span></td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->shop->name }}</td>
                                            <td><span class="money">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></td>
                                            <td>
                                                @php
                                                    $os = strtolower($order->status);
                                                    $orderClass = match(true) {
                                                        in_array($os, ['pending', 'waiting', 'menunggu']) => 'status-pending',
                                                        in_array($os, ['completed', 'success', 'selesai', 'paid', 'lunas']) => 'status-success',
                                                        in_array($os, ['cancelled', 'rejected', 'dibatalkan', 'ditolak', 'failed']) => 'status-danger',
                                                        in_array($os, ['processing', 'active', 'aktif', 'diproses']) => 'status-info',
                                                        default => 'status-neutral',
                                                    };
                                                @endphp
                                                <span class="status {{ $orderClass }}">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">Belum ada pesanan.</div>
                    @endif
                </div>

                <!-- Pembayaran Terbaru -->
                <div class="panel">
                    <div class="panel-head">
                        <h3>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                            Pembayaran Terbaru
                        </h3>
                        <a href="{{ route('admin.payments.index') }}" class="see-all">
                            Lihat Semua
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                    @if ($latestPayments->count())
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No. Transaksi</th>
                                        <th>Pengguna</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestPayments->take(5) as $payment)
                                        <tr>
                                            <td><span class="order-num">{{ $payment->order->order_number ?? '#' . $payment->id }}</span></td>
                                            <td>{{ $payment->order->user->name ?? '-' }}</td>
                                            <td><span class="money">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></td>
                                            <td>
                                                @php
                                                    $ps = strtolower($payment->status);
                                                    $payClass = match(true) {
                                                        in_array($ps, ['pending', 'waiting', 'menunggu']) => 'status-pending',
                                                        in_array($ps, ['paid', 'success', 'lunas', 'verified']) => 'status-success',
                                                        in_array($ps, ['rejected', 'failed', 'ditolak', 'cancelled']) => 'status-danger',
                                                        default => 'status-neutral',
                                                    };
                                                @endphp
                                                <span class="status {{ $payClass }}">{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</span>
                                            </td>
                                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">Belum ada pembayaran.</div>
                    @endif
                </div>
            </div>

            <!-- Aksi Cepat & Statistik -->
            <div class="grid-2col">
                <div class="panel" style="padding: 20px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#2b7de0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <h3 style="font-size: .92rem; font-weight: 700; color: #1a3a5c;">Aksi Cepat</h3>
                    </div>
                    <div class="action-grid">
                        <a href="{{ route('admin.shops.index', ['status' => 'pending']) }}" class="action-card">
                            <span class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                            </span>
                            <div class="ac-title">Verifikasi Toko</div>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="action-card">
                            <span class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </span>
                            <div class="ac-title">Kelola Pengguna</div>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="action-card">
                            <span class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><path d="M7 7h.01"/></svg>
                            </span>
                            <div class="ac-title">Tambah Kategori</div>
                        </a>
                        <a href="{{ route('admin.reports.transactions') }}" class="action-card">
                            <span class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                            </span>
                            <div class="ac-title">Lihat Laporan</div>
                        </a>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                            Statistik Bulanan
                        </h3>
                        <select class="chart-select">
                            <option>April 2025</option>
                            <option>Maret 2025</option>
                            <option>Februari 2025</option>
                        </select>
                    </div>
                    <div class="chart-area">
                        <svg viewBox="0 0 300 120" preserveAspectRatio="none">
                            <defs><linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#2b7de0" stop-opacity="0.25"/><stop offset="100%" stop-color="#2b7de0" stop-opacity="0"/></linearGradient></defs>
                            <line x1="0" y1="30" x2="300" y2="30" stroke="#e2eaf4" stroke-width="1" stroke-dasharray="4 4"/>
                            <line x1="0" y1="60" x2="300" y2="60" stroke="#e2eaf4" stroke-width="1" stroke-dasharray="4 4"/>
                            <line x1="0" y1="90" x2="300" y2="90" stroke="#e2eaf4" stroke-width="1" stroke-dasharray="4 4"/>
                            <path d="M0,95 Q30,90 50,85 T100,70 T150,75 T200,50 T250,40 T300,20 L300,120 L0,120 Z" fill="url(#chartGrad)"/>
                            <path d="M0,95 Q30,90 50,85 T100,70 T150,75 T200,50 T250,40 T300,20" fill="none" stroke="#2b7de0" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="50" cy="85" r="3.5" fill="#fff" stroke="#2b7de0" stroke-width="2"/>
                            <circle cx="100" cy="70" r="3.5" fill="#fff" stroke="#2b7de0" stroke-width="2"/>
                            <circle cx="150" cy="75" r="3.5" fill="#fff" stroke="#2b7de0" stroke-width="2"/>
                            <circle cx="200" cy="50" r="3.5" fill="#fff" stroke="#2b7de0" stroke-width="2"/>
                            <circle cx="250" cy="40" r="3.5" fill="#fff" stroke="#2b7de0" stroke-width="2"/>
                            <circle cx="300" cy="20" r="3.5" fill="#fff" stroke="#2b7de0" stroke-width="2"/>
                        </svg>
                        <div style="position: absolute; top: 10px; right: 10px; background: #fff; padding: 4px 10px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); font-size: .72rem; font-weight: 700; color: #1a3a5c;">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </div>
                    </div>
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
