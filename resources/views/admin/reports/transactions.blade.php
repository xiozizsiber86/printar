<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Printar Admin</title>
    <meta name="description" content="Laporan transaksi Printar.">

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

        /* Card / Panel */
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

        /* Filter Form */
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: flex-end;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-label {
            font-size: .75rem;
            font-weight: 600;
            color: #5a7290;
            letter-spacing: .02em;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: .85rem;
            font-family: inherit;
            color: #1e3a5f;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(90, 130, 175, 0.22);
            outline: none;
            transition: all .2s;
            -webkit-appearance: none;
            appearance: none;
        }
        .form-control:focus { border-color: #2b7de0; box-shadow: 0 0 0 3px rgba(43, 125, 224, 0.15); }
        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%236b829e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='4 6 8 10 12 6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 38px;
            cursor: pointer;
        }

        .filter-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            grid-column: 1 / -1;
            margin-top: 4px;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            border: none;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }
        .btn-primary svg { width: 16px; height: 16px; }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            color: #6b829e;
            background: transparent;
            border: 1px solid rgba(80, 120, 165, 0.22);
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-outline:hover { border-color: #2b7de0; color: #2b7de0; background: rgba(43, 125, 224, 0.06); }
        .btn-outline svg { width: 15px; height: 15px; }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        .summary-card {
            padding: 20px;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
        }
        .summary-label {
            font-size: .75rem;
            font-weight: 600;
            color: #6b829e;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 6px;
        }
        .summary-value {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1a3a5c;
            letter-spacing: -0.02em;
        }
        .summary-value.accent { color: #2b7de0; }
        .summary-value.success { color: #16a36a; }
        .summary-value.warning { color: #d99a1a; }

        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
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
        .status-purple  { color: #8b5cf6; background: rgba(139, 92, 246, 0.1); }

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #94a8bf;
            font-size: .88rem;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 16px 20px;
            border-top: 1px solid rgba(90, 130, 175, 0.1);
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
            .card { padding: 18px; }
            .filter-grid { grid-template-columns: 1fr; }
            .filter-actions { flex-direction: column; }
            .btn-primary, .btn-outline { width: 100%; justify-content: center; }
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
                    <a href="{{ route('admin.services.index', ['status' => 'pending']) }}">
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
                    <a href="{{ route('admin.reports.transactions') }}" class="active">
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        Laporan Transaksi
                    </h1>
                    <p>Ringkasan dan riwayat transaksi platform Printar.</p>
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

            <!-- Filter Card -->
            <div class="card">
                <div class="card-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    <h2>Filter Laporan</h2>
                </div>

                <form action="{{ route('admin.reports.transactions') }}" method="GET">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label class="form-label">Tanggal Mulai</label>
                            <input
                                type="date"
                                name="start_date"
                                class="form-control"
                                value="{{ $validated['start_date'] ?? '' }}"
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Akhir</label>
                            <input
                                type="date"
                                name="end_date"
                                class="form-control"
                                value="{{ $validated['end_date'] ?? '' }}"
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status Pesanan</label>
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                @foreach ([
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Dikonfirmasi',
                                    'processing' => 'Diproses',
                                    'ready' => 'Siap Diambil',
                                    'shipped' => 'Dikirim',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    'rejected' => 'Ditolak',
                                ] as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(($validated['status'] ?? '') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="payment_status" class="form-control">
                                <option value="">Semua Status Pembayaran</option>
                                @foreach ([
                                    'pending' => 'Menunggu Pembayaran',
                                    'waiting_verification' => 'Menunggu Verifikasi',
                                    'paid' => 'Lunas',
                                    'failed' => 'Gagal',
                                    'rejected' => 'Ditolak',
                                    'expired' => 'Kedaluwarsa',
                                    'refunded' => 'Dikembalikan',
                                ] as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(($validated['payment_status'] ?? '') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('admin.reports.transactions') }}" class="btn-outline">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                            Reset Filter
                        </a>
                        <a href="{{ route('admin.reports.transactions.export', request()->query()) }}" class="btn-outline" style="margin-left: auto;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Export Laporan CSV
                        </a>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-label">Total Pesanan</div>
                    <div class="summary-value">{{ number_format($totalOrders, 0, ',', '.') }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Total Nilai Transaksi</div>
                    <div class="summary-value accent">Rp {{ number_format($totalTransaction, 0, ',', '.') }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Total Pendapatan Lunas</div>
                    <div class="summary-value success">Rp {{ number_format($paidRevenue, 0, ',', '.') }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Pembayaran Menunggu Verifikasi</div>
                    <div class="summary-value warning">{{ number_format($waitingPayments, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="padding: 18px 20px; border-bottom: 1px solid rgba(90, 130, 175, 0.12); display: flex; align-items: center; gap: 10px;">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#2b7de0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    <h2 style="font-size: 1.05rem; font-weight: 700; color: #1a3a5c; margin: 0;">Daftar Transaksi</h2>
                </div>

                @if ($orders->isEmpty())
                    <div class="empty-state">
                        Belum ada transaksi yang sesuai dengan filter.
                    </div>
                @else
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 60px;">No</th>
                                    <th>Nomor Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Toko</th>
                                    <th>Total Transaksi</th>
                                    <th>Status Pesanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <td><span class="row-number">{{ $orders->firstItem() + $index }}</span></td>
                                        <td><span class="order-num">{{ $order->order_number }}</span></td>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                        <td>{{ $order->shop->name ?? '-' }}</td>
                                        <td><span class="money">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></td>
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
                                        <td>
                                            @php
                                                $ps = strtolower($order->payment->status ?? 'belum ada');
                                                $payClass = match(true) {
                                                    in_array($ps, ['pending', 'waiting', 'menunggu', 'waiting_verification']) => 'status-pending',
                                                    in_array($ps, ['paid', 'success', 'lunas', 'verified']) => 'status-success',
                                                    in_array($ps, ['rejected', 'failed', 'ditolak', 'cancelled']) => 'status-danger',
                                                    in_array($ps, ['refunded', 'dikembalikan']) => 'status-purple',
                                                    in_array($ps, ['expired', 'kedaluwarsa']) => 'status-neutral',
                                                    default => 'status-neutral',
                                                };
                                            @endphp
                                            <span class="status {{ $payClass }}">{{ ucfirst(str_replace('_', ' ', $order->payment->status ?? 'belum ada')) }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrap">
                        {{ $orders->links() }}
                    </div>
                @endif
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
