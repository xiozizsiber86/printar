<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Printar Merchant</title>
    <meta name="description" content="Detail pesanan masuk Printar.">

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

        /* Cards & Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }
        @media (max-width: 1024px) {
            .content-grid { grid-template-columns: 1fr; }
        }

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

        /* Info Rows */
        .row {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(90, 130, 175, 0.15);
            font-size: .9rem;
        }
        .row:last-child { border-bottom: none; padding-bottom: 0; }
        .row strong {
            flex-shrink: 0;
            width: 180px;
            color: #6b829e;
            font-weight: 600;
            font-size: .85rem;
        }
        .row .value {
            color: #1a3a5c;
            font-weight: 500;
            word-break: break-word;
        }
        .row .value.amount { color: #2b7de0; font-weight: 700; font-size: .95rem; }
        @media (max-width: 600px) {
            .row { flex-direction: column; gap: 4px; }
            .row strong { width: 100%; }
        }

        /* Status Badge */
        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .status-pending { color: #d99a1a; background: rgba(217, 154, 26, 0.12); }
        .status-success { color: #16a36a; background: rgba(22, 163, 106, 0.1); }
        .status-danger  { color: #e05555; background: rgba(224, 85, 85, 0.1); }
        .status-info    { color: #2b7de0; background: rgba(43, 125, 224, 0.1); }
        .status-neutral { color: #7a94b0; background: rgba(122, 148, 176, 0.1); }

        /* Action Forms */
        .action-form {
            margin-top: 16px;
        }
        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: .9rem;
            font-weight: 600;
            color: #fff;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all .2s;
        }
        .btn-accept { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
        .btn-accept:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4); }
        
        .btn-reject { background: linear-gradient(135deg, #ef4444, #f87171); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
        .btn-reject:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4); }

        .btn-process { background: linear-gradient(135deg, #2b7de0, #5fa8f5); box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3); }
        .btn-process:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }

        .btn-action svg { width: 18px; height: 18px; }

        .info-message {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 500;
            color: #6b829e;
            background: rgba(235, 244, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.15);
            line-height: 1.5;
        }
        .info-message svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; }
        .info-message.warning { color: #a87513; background: rgba(245, 190, 65, 0.1); border-color: rgba(245, 190, 65, 0.25); }

        /* Items List */
        .item-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .item-box {
            padding: 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.15);
        }
        .item-box .s-name { font-weight: 700; color: #1a3a5c; font-size: .95rem; margin-bottom: 8px; display: block; }
        .item-details { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: .85rem; color: #5a7290; margin-bottom: 12px; }
        .item-details .amount { font-weight: 600; color: #2b7de0; }
        
        .file-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            background: rgba(235, 244, 255, 0.5);
            border-radius: 8px;
            border: 1px solid rgba(90, 130, 175, 0.1);
            margin-bottom: 8px;
        }
        .file-info { font-size: .8rem; color: #3e5875; }
        .file-info strong { color: #1a3a5c; }
        
        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 600;
            color: #2b7de0;
            background: #fff;
            border: 1px solid rgba(43, 125, 224, 0.2);
            text-decoration: none;
            transition: all .2s;
        }
        .btn-download:hover { background: #2b7de0; color: #fff; border-color: #2b7de0; }
        .btn-download svg { width: 14px; height: 14px; }

        /* Form Input inside Card */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: .8rem; font-weight: 600; color: #1a3a5c; margin-bottom: 6px; }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: .85rem;
            font-family: inherit;
            color: #1e3a5f;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(90, 130, 175, 0.22);
            outline: none;
            transition: all .2s;
        }
        .form-control:focus { border-color: #2b7de0; box-shadow: 0 0 0 3px rgba(43, 125, 224, 0.15); }
        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%236b829e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='4 6 8 10 12 6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 38px;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
        }
        textarea.form-control { resize: vertical; min-height: 80px; }

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
            .item-details { grid-template-columns: 1fr; }
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
                    <a href="{{ route('merchant.orders.index') }}" class="active">
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Detail Pesanan
                    </h1>
                    <p>Pesanan: <strong>#{{ $order->order_number }}</strong></p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('merchant.orders.index') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Kembali ke Daftar</span>
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
                        <strong>Periksa kembali data berikut:</strong>
                    </div>
                    <ul style="margin-left: 28px; padding-left: 0; list-style-type: disc;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="content-grid">
                <!-- LEFT COLUMN: Info & Items -->
                <div class="left-col">
                    <!-- Informasi Pesanan -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                            <h2>Informasi Pesanan</h2>
                        </div>

                        <div class="row">
                            <strong>Nomor Pesanan</strong>
                            <div class="value">{{ $order->order_number }}</div>
                        </div>
                        <div class="row">
                            <strong>Status Pesanan</strong>
                            <div class="value">
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
                            </div>
                        </div>
                        <div class="row">
                            <strong>Tanggal Pesanan</strong>
                            <div class="value">{{ $order->created_at->format('d-m-Y H:i') }}</div>
                        </div>
                        <div class="row">
                            <strong>Catatan</strong>
                            <div class="value">{{ $order->notes ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Informasi Pelanggan -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <h2>Informasi Pelanggan</h2>
                        </div>

                        <div class="row">
                            <strong>Nama</strong>
                            <div class="value">{{ $order->user->name }}</div>
                        </div>
                        <div class="row">
                            <strong>Email</strong>
                            <div class="value">{{ $order->user->email }}</div>
                        </div>
                        @if ($order->address)
                            <div class="row">
                                <strong>Penerima</strong>
                                <div class="value">{{ $order->address->recipient_name }}</div>
                            </div>
                            <div class="row">
                                <strong>Telepon</strong>
                                <div class="value">{{ $order->address->phone }}</div>
                            </div>
                            <div class="row">
                                <strong>Alamat</strong>
                                <div class="value">{{ $order->address->address }}</div>
                            </div>
                        @else
                            <div class="row">
                                <strong>Alamat Pengiriman</strong>
                                <div class="value">Tidak tersedia</div>
                            </div>
                        @endif
                    </div>

                    <!-- Daftar Layanan & File -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                            <h2>Daftar Layanan & File Cetak</h2>
                        </div>

                        <div class="item-list">
                            @forelse ($order->items as $item)
                                <div class="item-box">
                                    <span class="s-name">{{ $item->service_name }}</span>
                                    
                                    <div class="item-details">
                                        <div>Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        <div>Jumlah: {{ $item->quantity }} {{ $item->unit }}</div>
                                        <div style="grid-column: span 2;">Subtotal: <span class="amount">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span></div>
                                    </div>

                                    <div style="font-size: .8rem; font-weight: 700; color: #1a3a5c; margin-bottom: 8px;">File Cetak Customer:</div>
                                    
                                    @forelse ($item->files as $file)
                                        <div class="file-box">
                                            <div class="file-info">
                                                <strong>{{ $file->original_name }}</strong><br>
                                                {{ $file->mime_type ?? 'Tidak diketahui' }} &middot; {{ number_format($file->file_size / 1024, 2) }} KB
                                            </div>
                                            <a href="{{ route('merchant.orders.files.download', ['id' => $order->id, 'fileId' => $file->id]) }}" class="btn-download">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                                Download
                                            </a>
                                        </div>
                                    @empty
                                        <div class="info-message">Customer belum mengunggah file cetak.</div>
                                    @endforelse
                                </div>
                            @empty
                                <div class="info-message">Tidak ada item pesanan.</div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Informasi Pengiriman & Form Kurir -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            <h2>Informasi Pengiriman</h2>
                        </div>

                        @if ($order->delivery)
                            <div class="row">
                                <strong>Metode</strong>
                                <div class="value">{{ ucfirst($order->delivery->delivery_method) }}</div>
                            </div>
                            <div class="row">
                                <strong>Alamat Pengiriman</strong>
                                <div class="value">{{ $order->delivery->delivery_address ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <strong>Biaya Pengiriman</strong>
                                <div class="value">Rp {{ number_format($order->delivery->delivery_fee, 0, ',', '.') }}</div>
                            </div>
                            <div class="row">
                                <strong>Jenis Kurir</strong>
                                <div class="value">
                                    @if ($order->delivery->courier_type === 'merchant')
                                        Kurir Merchant
                                    @elseif ($order->delivery->courier_type === 'third_party')
                                        Kurir Pihak Ketiga
                                    @else
                                        Belum ditentukan
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <strong>Nama Kurir</strong>
                                <div class="value">{{ $order->delivery->courier_name ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <strong>Telepon Kurir</strong>
                                <div class="value">{{ $order->delivery->courier_phone ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <strong>Catatan Pengiriman</strong>
                                <div class="value">{{ $order->delivery->notes ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <strong>Waktu Dikirim</strong>
                                <div class="value">{{ $order->delivery->shipped_at?->format('d-m-Y H:i') ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <strong>Waktu Diterima</strong>
                                <div class="value">{{ $order->delivery->received_at?->format('d-m-Y H:i') ?? '-' }}</div>
                            </div>

                            @if ($order->delivery->delivery_method === 'delivery')
                                @if (!$order->delivery->shipped_at && !$order->delivery->received_at)
                                    <div class="action-divider" style="margin: 20px 0; border-top: 1px dashed rgba(90, 130, 175, 0.15);"></div>
                                    <h4 style="font-size: .9rem; color: #1a3a5c; margin-bottom: 12px;">Pengaturan Informasi Kurir</h4>
                                    
                                    <form method="POST" action="{{ route('merchant.orders.delivery.update', $order->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label class="form-label">Jenis Kurir</label>
                                            <select name="courier_type" class="form-control" required>
                                                <option value="">-- Pilih Jenis Kurir --</option>
                                                <option value="merchant" {{ old('courier_type', $order->delivery->courier_type) === 'merchant' ? 'selected' : '' }}>Kurir Merchant</option>
                                                <option value="third_party" {{ old('courier_type', $order->delivery->courier_type) === 'third_party' ? 'selected' : '' }}>Kurir Pihak Ketiga</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Nama Kurir</label>
                                            <input type="text" name="courier_name" class="form-control" value="{{ old('courier_name', $order->delivery->courier_name) }}" maxlength="255" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Nomor Telepon Kurir</label>
                                            <input type="text" name="courier_phone" class="form-control" value="{{ old('courier_phone', $order->delivery->courier_phone) }}" maxlength="20">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Catatan Pengiriman</label>
                                            <textarea name="notes" class="form-control" rows="3" maxlength="1000">{{ old('notes', $order->delivery->notes) }}</textarea>
                                        </div>

                                        <button type="submit" class="btn-action btn-process">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                            Simpan Informasi Kurir
                                        </button>
                                    </form>
                                @else
                                    <div class="info-message" style="margin-top: 16px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        Informasi kurir sudah dikunci karena pesanan telah dikirim atau diterima.
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="info-message">Belum ada informasi pengiriman.</div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN: Status Actions & Summary -->
                <div class="right-col">
                    <!-- Tindakan Pesanan -->
                    <div class="card" style="position: sticky; top: 24px;">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            <h2>Tindakan Pesanan</h2>
                        </div>

                        @if ($order->status === 'pending')
                            <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Harap konfirmasi pesanan ini.</p>
                            <form method="POST" action="{{ route('merchant.orders.accept', $order->id) }}" class="action-form">
                                @csrf
                                <button type="submit" class="btn-action btn-accept" onclick="return confirm('Apakah kamu yakin ingin menerima pesanan ini?')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Terima Pesanan
                                </button>
                            </form>
                            <form method="POST" action="{{ route('merchant.orders.reject', $order->id) }}" class="action-form">
                                @csrf
                                <button type="submit" class="btn-action btn-reject" onclick="return confirm('Apakah kamu yakin ingin menolak pesanan ini?')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    Tolak Pesanan
                                </button>
                            </form>

                        @elseif ($order->status === 'confirmed')
                            <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Pesanan sudah diterima dan menunggu pengerjaan.</p>
                            <form method="POST" action="{{ route('merchant.orders.process', $order->id) }}" class="action-form">
                                @csrf
                                <button type="submit" class="btn-action btn-process" onclick="return confirm('Mulai kerjakan pesanan ini?')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                    Mulai Proses
                                </button>
                            </form>

                        @elseif ($order->status === 'processing')
                            <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Pesanan sedang dikerjakan.</p>
                            <form method="POST" action="{{ route('merchant.orders.ready', $order->id) }}" class="action-form">
                                @csrf
                                <button type="submit" class="btn-action btn-process" onclick="return confirm('Tandai pesanan sudah siap?')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Tandai Pesanan Siap
                                </button>
                            </form>

                        @elseif ($order->status === 'ready')
                            <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Pesanan sudah siap diambil atau dikirim.</p>
                            
                            @if ($order->delivery && $order->delivery->delivery_method === 'delivery')
                                @if (!$order->delivery->shipped_at)
                                    <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Pastikan informasi kurir sudah lengkap sebelum mengirim pesanan.</p>
                                    <form method="POST" action="{{ route('merchant.orders.shipped', $order->id) }}" class="action-form">
                                        @csrf
                                        <button type="submit" class="btn-action btn-process" onclick="return confirm('Apakah pesanan sudah diserahkan kepada kurir?')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                            Tandai Sudah Dikirim
                                        </button>
                                    </form>
                                @else
                                    <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Waktu pengiriman: {{ $order->delivery->shipped_at->format('d-m-Y H:i') }}</p>
                                    <form method="POST" action="{{ route('merchant.orders.complete', $order->id) }}" class="action-form">
                                        @csrf
                                        <button type="submit" class="btn-action btn-accept" onclick="return confirm('Apakah pesanan sudah diterima pelanggan?')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                            Selesaikan Pesanan
                                        </button>
                                    </form>
                                @endif
                            @elseif ($order->delivery && $order->delivery->delivery_method === 'pickup')
                                <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">Pesanan menunggu diambil pelanggan.</p>
                                <form method="POST" action="{{ route('merchant.orders.complete', $order->id) }}" class="action-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-accept" onclick="return confirm('Apakah pelanggan sudah mengambil pesanan?')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Selesaikan Pesanan
                                    </button>
                                </form>
                            @else
                                <div class="info-message warning">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    Data pengiriman belum tersedia.
                                </div>
                            @endif

                        @elseif ($order->status === 'completed')
                            <div class="info-message" style="color: #16a36a; background: rgba(22, 163, 106, 0.1); border-color: rgba(22, 163, 106, 0.25);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Pesanan sudah selesai.
                            </div>

                        @elseif ($order->status === 'rejected')
                            <div class="info-message" style="color: #e05555; background: rgba(224, 85, 85, 0.1); border-color: rgba(224, 85, 85, 0.25);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                Pesanan telah ditolak.
                            </div>

                        @elseif ($order->status === 'cancelled')
                            <div class="info-message" style="color: #e05555; background: rgba(224, 85, 85, 0.1); border-color: rgba(224, 85, 85, 0.25);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                Pesanan dibatalkan oleh pelanggan.
                            </div>

                        @else
                            <div class="info-message">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                Tidak ada tindakan yang tersedia untuk status pesanan ini.
                            </div>
                        @endif
                    </div>

                    <!-- Ringkasan Pembayaran -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                            <h2>Ringkasan Pembayaran</h2>
                        </div>

                        <div class="row">
                            <strong>Subtotal</strong>
                            <div class="value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</div>
                        </div>
                        <div class="row">
                            <strong>Biaya Pengiriman</strong>
                            <div class="value">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</div>
                        </div>
                        <div class="row" style="margin-top: 8px; border-top: 1px solid rgba(90, 130, 175, 0.2); padding-top: 12px;">
                            <strong>Total</strong>
                            <div class="value amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </div>

                        @if ($order->payment)
                            <div class="row" style="margin-top: 12px;">
                                <strong>Metode Pembayaran</strong>
                                <div class="value">{{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</div>
                            </div>
                            <div class="row">
                                <strong>Status Pembayaran</strong>
                                <div class="value">
                                    @php
                                        $ps = strtolower($order->payment->status);
                                        $payClass = match(true) {
                                            in_array($ps, ['pending', 'waiting', 'menunggu', 'waiting_verification']) => 'status-pending',
                                            in_array($ps, ['paid', 'success', 'lunas', 'verified']) => 'status-success',
                                            in_array($ps, ['rejected', 'failed', 'ditolak', 'cancelled']) => 'status-danger',
                                            in_array($ps, ['refunded', 'dikembalikan']) => 'status-purple',
                                            in_array($ps, ['expired', 'kedaluwarsa']) => 'status-neutral',
                                            default => 'status-neutral',
                                        };
                                    @endphp
                                    <span class="status {{ $payClass }}">{{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="info-message" style="margin-top: 16px;">Belum ada informasi pembayaran.</div>
                        @endif
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
