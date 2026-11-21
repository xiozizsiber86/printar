<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Printar</title>
    <meta name="description" content="Checkout pesanan di Printar.">

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

        /* Cards */
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

        /* Grid for Checkout Content */
        .checkout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .checkout-grid { grid-template-columns: 1fr; }
        }

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
            width: 140px;
            color: #6b829e;
            font-weight: 600;
            font-size: .85rem;
        }
        .row .value {
            color: #1a3a5c;
            font-weight: 500;
            word-break: break-word;
        }
        @media (max-width: 600px) {
            .row { flex-direction: column; gap: 4px; }
            .row strong { width: 100%; }
        }

        /* Cart Items List */
        .item-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }
        .item-box {
            padding: 14px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .item-info .s-name {
            font-weight: 700;
            color: #1a3a5c;
            font-size: .9rem;
            margin-bottom: 4px;
        }
        .item-info .s-detail {
            font-size: .78rem;
            color: #6b829e;
        }
        .item-subtotal {
            font-weight: 700;
            color: #2b7de0;
            font-size: .95rem;
            white-space: nowrap;
        }

        /* Custom Radio / Checkbox */
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .radio-label {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.22);
            cursor: pointer;
            transition: all .2s ease;
        }
        .radio-label:hover {
            border-color: rgba(43, 125, 224, 0.4);
            background: rgba(235, 244, 255, 0.8);
        }
        .radio-label input[type="radio"] {
            margin-top: 4px;
            accent-color: #2b7de0;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .radio-content {
            flex: 1;
            min-width: 0;
        }
        .radio-title {
            font-size: .9rem;
            font-weight: 600;
            color: #1a3a5c;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .radio-badge {
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            background: #ffe6a8;
            color: #80570a;
        }
        .radio-subtitle {
            font-size: .82rem;
            color: #6b829e;
            margin-top: 4px;
            line-height: 1.4;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: #1a3a5c;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: .88rem;
            font-family: inherit;
            color: #1e3a5f;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(90, 130, 175, 0.22);
            outline: none;
            transition: all .2s;
        }
        .form-control:focus {
            border-color: #2b7de0;
            box-shadow: 0 0 0 3px rgba(43, 125, 224, 0.15);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        /* Buttons */
        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: .95rem;
            font-weight: 600;
            color: #fff;
            border: none;
            cursor: pointer;
            font-family: inherit;
            background: linear-gradient(135deg, #10b981, #34d399);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all .2s;
            margin-top: 10px;
        }
        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }
        .btn-action svg { width: 18px; height: 18px; }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 600;
            color: #2b7de0;
            background: #fff;
            border: 1px solid rgba(43, 125, 224, 0.25);
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
            font-family: inherit;
        }
        .btn-outline:hover { background: #2b7de0; color: #fff; border-color: #2b7de0; }
        .btn-outline svg { width: 14px; height: 14px; }

        /* Summary Box */
        .summary-box {
            padding: 16px;
            border-radius: 12px;
            background: rgba(235, 244, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.15);
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: .88rem;
            color: #5a7290;
        }
        .summary-row strong {
            color: #1a3a5c;
            font-weight: 600;
        }
        .summary-row.total {
            border-top: 1px dashed rgba(90, 130, 175, 0.25);
            margin-top: 8px;
            padding-top: 12px;
            font-size: 1rem;
            font-weight: 700;
        }
        .summary-row.total strong {
            color: #2b7de0;
            font-size: 1.15rem;
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
            .btn-back span { display: none; }
            .profile-btn span:not(.avatar-sm) { display: none; }
            .profile-btn { padding: 6px; }
            .card { padding: 18px; }
            .item-box { flex-direction: column; align-items: flex-start; gap: 6px; }
            .item-subtotal { align-self: flex-end; }
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

            <div class="nav-label">Menu Customer</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('customer.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.shops.index') }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Checkout Pesanan
                    </h1>
                    <p>Selesaikan pesanan Anda di {{ $cart->shop->name ?? '-' }}</p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('customer.cart.index') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Kembali ke Keranjang</span>
                    </a>
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

            <form action="{{ route('customer.checkout.store') }}" method="POST">
                @csrf

                <div class="checkout-grid">
                    <!-- Left Column: Detail Pesanan & Form -->
                    <div class="left-col">
                        <!-- Card: Daftar Layanan -->
                        <div class="card">
                            <div class="card-header">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                                <h2>Daftar Layanan</h2>
                            </div>

                            <div class="item-list">
                                @foreach($cart->items as $item)
                                    <div class="item-box">
                                        <div class="item-info">
                                            <div class="s-name">{{ $item->service->name ?? 'Layanan tidak tersedia' }}</div>
                                            <div class="s-detail">
                                                Rp{{ number_format((float) ($item->service->price ?? $item->price), 0, ',', '.') }}
                                                / {{ $item->service->unit ?? $item->unit }} &times; {{ $item->quantity }}
                                            </div>
                                        </div>
                                        <div class="item-subtotal">
                                            Rp{{ number_format((float) ($item->service->price ?? $item->price) * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Card: Metode Pesanan -->
                        <div class="card">
                            <div class="card-header">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                <h2>Metode Pesanan</h2>
                            </div>

                            <div class="radio-group">
                                <label class="radio-label">
                                    <input
                                        type="radio"
                                        name="delivery_method"
                                        value="pickup"
                                        {{ old('delivery_method', 'delivery') === 'pickup' ? 'checked' : '' }}
                                        required
                                    >
                                    <div class="radio-content">
                                        <div class="radio-title">Ambil di Toko</div>
                                        <div class="radio-subtitle">Anda akan mengambil pesanan langsung di toko percetakan.</div>
                                    </div>
                                </label>

                                <label class="radio-label">
                                    <input
                                        type="radio"
                                        name="delivery_method"
                                        value="delivery"
                                        {{ old('delivery_method', 'delivery') === 'delivery' ? 'checked' : '' }}
                                        required
                                    >
                                    <div class="radio-content">
                                        <div class="radio-title">Diantar ke Alamat</div>
                                        <div class="radio-subtitle">Pesanan akan diantar ke alamat yang Anda pilih.</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Card: Alamat Customer -->
                        <div class="card">
                            <div class="card-header">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <h2>Alamat Customer</h2>
                            </div>

                            <div class="radio-group" style="margin-bottom: 16px;">
                                @foreach($addresses as $address)
                                    <label class="radio-label">
                                        <input
                                            type="radio"
                                            name="address_id"
                                            value="{{ $address->id }}"
                                            {{ old('address_id', $addresses->firstWhere('is_default', true)?->id ?? $addresses->first()->id) == $address->id ? 'checked' : '' }}
                                            required
                                        >
                                        <div class="radio-content">
                                            <div class="radio-title">
                                                {{ $address->label }}
                                                @if($address->is_default)
                                                    <span class="radio-badge">Alamat Utama</span>
                                                @endif
                                            </div>
                                            <div class="radio-subtitle">
                                                <strong>{{ $address->recipient_name }}</strong> - {{ $address->phone }}
                                                <br>
                                                {{ $address->address }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div>
                                <a href="{{ route('customer.addresses.index') }}" class="btn-outline">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Kelola Alamat
                                </a>
                            </div>
                        </div>

                        <!-- Card: Catatan Pesanan -->
                        <div class="card">
                            <div class="card-header">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                <h2>Catatan Pesanan</h2>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="notes">Tambahkan catatan untuk toko (opsional)</label>
                                <textarea
                                    name="notes"
                                    id="notes"
                                    class="form-control"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Contoh: Mohon dikerjakan dengan rapi, warna cerah, dll."
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Ringkasan & Submit -->
                    <div class="right-col">
                        <div class="card" style="position: sticky; top: 24px;">
                            <div class="card-header">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                                <h2>Ringkasan Biaya</h2>
                            </div>

                            @php
                                $subtotal = $cart->items->sum(function ($item) {
                                    return (float) ($item->service->price ?? $item->price) * $item->quantity;
                                });
                            @endphp

                            <div class="summary-box">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                                </div>
                                <div class="summary-row">
                                    <span>Ongkos Kirim</span>
                                    <strong>Rp0</strong>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn-action">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

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
