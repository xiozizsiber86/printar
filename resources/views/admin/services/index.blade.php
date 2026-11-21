<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Layanan - Printar Admin</title>
    <meta name="description" content="Verifikasi layanan Printar.">

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
        .alert-danger  { color: #b83a3a; background: rgba(224, 85, 85, 0.1); border-color: rgba(224, 85, 85, 0.25); }

        /* Filter Tabs */
        .filter-panel {
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            padding: 20px;
            margin-bottom: 20px;
        }
        .filter-panel h3 {
            font-size: .9rem;
            font-weight: 700;
            color: #1a3a5c;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .filter-panel h3 svg { width: 18px; height: 18px; color: #2b7de0; }

        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .filter-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            color: #5a7290;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(90, 130, 175, 0.18);
            text-decoration: none;
            transition: all .2s;
        }
        .filter-tab:hover { border-color: #2b7de0; color: #2b7de0; background: #fff; }
        .filter-tab.active {
            background: #2b7de0;
            color: #fff;
            border-color: #2b7de0;
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
        }

        .active-filter-info {
            font-size: .85rem;
            color: #6b829e;
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .active-filter-info strong { color: #2b7de0; }

        /* Cards Container */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        /* Service Card */
        .service-card {
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
        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(30, 60, 100, 0.12);
        }
        .service-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(90, 130, 175, 0.12);
            background: rgba(235, 244, 255, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }
        .service-card-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a3a5c;
            line-height: 1.3;
            margin: 0;
        }
        .service-card-header .s-id {
            font-size: .72rem;
            font-weight: 600;
            color: #7a94b0;
            background: rgba(255, 255, 255, 0.6);
            padding: 2px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }
        
        .service-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            font-size: .85rem;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(90, 130, 175, 0.15);
        }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-label {
            color: #6b829e;
            font-weight: 500;
            flex-shrink: 0;
        }
        .info-value {
            color: #1a3a5c;
            font-weight: 600;
            text-align: right;
            word-break: break-word;
        }
        .info-value.price {
            color: #2b7de0;
            font-size: .95rem;
        }

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
        
        .status-pending { color: #d99a1a; background: rgba(217, 154, 26, 0.12); }
        .status-approved { color: #16a36a; background: rgba(22, 163, 106, 0.1); }
        .status-rejected { color: #e05555; background: rgba(224, 85, 85, 0.1); }
        .status-active { color: #16a36a; background: rgba(22, 163, 106, 0.1); }
        .status-inactive { color: #7a94b0; background: rgba(122, 148, 176, 0.1); }

        .service-card-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(90, 130, 175, 0.12);
            background: rgba(235, 244, 255, 0.3);
        }

        .btn-detail {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            border: none;
            text-decoration: none;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.2);
        }
        .btn-detail:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }
        .btn-detail svg { width: 16px; height: 16px; }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
            color: #94a8bf;
            font-size: .88rem;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.6);
            border: 1px dashed rgba(90, 130, 175, 0.2);
            grid-column: 1 / -1;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 24px 0 0;
            display: flex;
            justify-content: center;
        }
        .pagination-wrap nav { width: 100%; }
        .pagination-wrap svg { width: 16px; height: 16px; }
        .pagination-wrap .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            list-style: none;
            justify-content: center;
            align-items: center;
        }
        .pagination-wrap .page-item .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 9px;
            font-size: .82rem;
            font-weight: 600;
            color: #5a7290;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(90, 130, 175, 0.18);
            text-decoration: none;
            transition: all .2s;
        }
        .pagination-wrap .page-item .page-link:hover { border-color: #2b7de0; color: #2b7de0; background: #fff; }
        .pagination-wrap .page-item.active .page-link {
            background: #2b7de0;
            color: #fff;
            border-color: #2b7de0;
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
        }
        .pagination-wrap .page-item.disabled .page-link { opacity: .45; pointer-events: none; }
        .pagination-wrap .page-item .page-link span { display: inline-flex; align-items: center; }
        .pagination-wrap .page-item:first-child .page-link svg,
        .pagination-wrap .page-item:last-child .page-link svg { width: 14px; height: 14px; }
        .pagination-wrap .page-item:first-child .page-link,
        .pagination-wrap .page-item:last-child .page-link { font-size: 0; }
        .pagination-wrap .page-item:first-child .page-link::before { content: "‹"; font-size: 1.1rem; }
        .pagination-wrap .page-item:last-child .page-link::after { content: "›"; font-size: 1.1rem; }

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
            .services-grid { grid-template-columns: 1fr; }
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
        <!-- ============ SIDEBAR ============ -->
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
                    <a href="{{ url('/admin/dashboard') }}">
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
                <li>
                    <a href="{{ route('admin.shops.index', ['status' => 'pending']) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        Verifikasi Toko
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index', ['status' => 'pending']) }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Verifikasi Layanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payments.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        Verifikasi Pembayaran
                        @if (($waitingPayments ?? 0) > 0)
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
                <div class="page-title">
                    <h1>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Verifikasi Layanan
                    </h1>
                    <p>Kelola pendaftaran dan status verifikasi layanan percetakan.</p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Kembali ke Dashboard</span>
                    </a>
                    <button class="icon-btn" aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @if (($waitingPayments ?? 0) > 0)
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

            @if (session('error'))
                <div class="alert alert-danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" style="display: flex; flex-direction: column; align-items: flex-start;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <strong>Terjadi Kesalahan:</strong>
                    </div>
                    @foreach ($errors->all() as $error)
                        <div style="margin-left: 28px;">- {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Filter Status -->
            <div class="filter-panel">
                <h3>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    Filter Status Layanan
                </h3>
                
                <div class="filter-tabs">
                    <a href="{{ route('admin.services.index', ['status' => 'pending']) }}" 
                       class="filter-tab {{ request('status') === 'pending' || !request('status') ? 'active' : '' }}">
                        Menunggu Verifikasi
                    </a>
                    <a href="{{ route('admin.services.index', ['status' => 'approved']) }}" 
                       class="filter-tab {{ request('status') === 'approved' ? 'active' : '' }}">
                        Disetujui
                    </a>
                    <a href="{{ route('admin.services.index', ['status' => 'rejected']) }}" 
                       class="filter-tab {{ request('status') === 'rejected' ? 'active' : '' }}">
                        Ditolak
                    </a>
                    <a href="{{ route('admin.services.index', ['status' => 'all']) }}" 
                       class="filter-tab {{ request('status') === 'all' ? 'active' : '' }}">
                        Semua
                    </a>
                </div>

                <div class="active-filter-info">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Filter aktif: <strong>{{ ucfirst($status) }}</strong>
                </div>
            </div>

            <!-- Daftar Layanan -->
            <div class="services-grid">
                @forelse ($services as $service)
                    <div class="service-card">
                        <div class="service-card-header">
                            <h3>{{ $service->name }}</h3>
                            <span class="s-id">#{{ $service->id }}</span>
                        </div>

                        <div class="service-card-body">
                            <div class="info-row">
                                <span class="info-label">Merchant</span>
                                <span class="info-value">{{ $service->shop->merchantProfile->user->name ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Toko</span>
                                <span class="info-value">{{ $service->shop->name ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kategori</span>
                                <span class="info-value">{{ $service->category->name ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Harga</span>
                                <span class="info-value price">Rp {{ number_format((float) $service->price, 0, ',', '.') }} / {{ $service->unit }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status Verifikasi</span>
                                <span class="status status-{{ $service->verification_status }}">
                                    @if ($service->verification_status === 'pending')
                                        Menunggu Verifikasi
                                    @elseif ($service->verification_status === 'approved')
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status Layanan</span>
                                <span class="status {{ $service->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $service->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>

                        <div class="service-card-footer">
                            <a href="{{ route('admin.services.show', $service->id) }}" class="btn-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat Detail dan Verifikasi
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        Belum ada layanan dengan status ini.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($services->hasPages())
                <div class="pagination-wrap">
                    {{ $services->links() }}
                </div>
            @endif

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
