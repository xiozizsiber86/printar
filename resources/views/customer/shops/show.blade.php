<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->name }} - Printar</title>
    <meta name="description" content="Detail toko percetakan {{ $shop->name }} di Printar.">

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

        /* Services Grid */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .service-card {
            display: flex;
            flex-direction: column;
            padding: 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(90, 130, 175, 0.15);
            transition: all .2s ease;
        }
        .service-card:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(43, 125, 224, 0.12);
            border-color: rgba(43, 125, 224, 0.35);
        }

        .service-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }
        .service-icon {
            width: 46px; height: 46px;
            flex-shrink: 0;
            border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, rgba(43, 125, 224, 0.15), rgba(95, 168, 245, 0.15));
            color: #2b7de0;
        }
        .service-icon svg { width: 22px; height: 22px; }
        .service-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1a3a5c;
            line-height: 1.3;
            margin: 0;
        }
        .service-cat {
            font-size: .75rem;
            color: #6b829e;
            margin-top: 2px;
        }
        .service-desc {
            font-size: .82rem;
            color: #6b829e;
            line-height: 1.45;
            margin-bottom: 14px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .service-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px dashed rgba(90, 130, 175, 0.15);
            margin-bottom: 14px;
        }
        .service-price-label {
            font-size: .78rem;
            color: #6b829e;
        }
        .service-price {
            font-size: 1rem;
            font-weight: 700;
            color: #2b7de0;
        }
        .service-price span {
            font-size: .75rem;
            font-weight: 500;
            color: #6b829e;
        }

        /* Add to Cart Form */
        .cart-form {
            display: flex;
            gap: 8px;
            align-items: stretch;
        }
        .qty-input-wrap {
            flex-shrink: 0;
            width: 80px;
        }
        .qty-input {
            width: 100%;
            height: 100%;
            padding: 10px 8px;
            border-radius: 10px;
            font-size: .88rem;
            font-family: inherit;
            color: #1e3a5f;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(90, 130, 175, 0.22);
            outline: none;
            text-align: center;
            transition: all .2s;
        }
        .qty-input:focus { border-color: #2b7de0; box-shadow: 0 0 0 3px rgba(43, 125, 224, 0.15); }

        .btn-add-cart {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            color: #fff;
            border: none;
            cursor: pointer;
            font-family: inherit;
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-add-cart:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }
        .btn-add-cart svg { width: 15px; height: 15px; }

        .service-unavailable {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            color: #b83a3a;
            background: rgba(224, 85, 85, 0.1);
            border: 1px solid rgba(224, 85, 85, 0.25);
        }
        .service-unavailable svg { width: 16px; height: 16px; }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
            gap: 12px;
        }
        .empty-state .empty-icon {
            width: 64px; height: 64px;
            border-radius: 50%;
            display: grid; place-items: center;
            background: rgba(235, 244, 255, 0.8);
            color: #94a8bf;
        }
        .empty-state .empty-icon svg { width: 30px; height: 30px; }
        .empty-state h3 { font-size: 1rem; font-weight: 700; color: #1a3a5c; margin: 0; }
        .empty-state p { font-size: .85rem; color: #6b829e; margin: 0; max-width: 320px; }

        /* Action Button (Cart) */
        .btn-cart-action {
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
            text-decoration: none;
            background: linear-gradient(135deg, #2b7de0, #5fa8f5);
            box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3);
            transition: all .2s;
            margin-top: 10px;
        }
        .btn-cart-action:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }
        .btn-cart-action svg { width: 18px; height: 18px; }

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
            .service-grid { grid-template-columns: 1fr; }
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
                    <!-- CLASS ACTIVE DIHAPUS DARI SINI -->
                    <a href="{{ route('customer.shops.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Cari Toko Percetakan
                    </a>
                </li>
                <li>
                    <!-- CLASS ACTIVE DIPINDAHKAN KE SINI -->
                    <a href="{{ route('customer.shops.index') }}" class="active">
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        {{ $shop->name }}
                    </h1>
                    <p>Detail Toko & Layanan Percetakan</p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('customer.shops.index') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Kembali ke Daftar Toko</span>
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

            <div class="content-grid" style="display: grid; grid-template-columns: 1fr; gap: 20px;">

                <!-- Card: Info Toko -->
                <div class="card">
                    <div class="card-header">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9 5 3h14l2 6"/><path d="M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M3 9h18"/></svg>
                        <h2>Informasi Toko</h2>
                    </div>

                    <div class="row">
                        <strong>Nama Toko</strong>
                        <div class="value">{{ $shop->name }}</div>
                    </div>
                    <div class="row">
                        <strong>Deskripsi</strong>
                        <div class="value">{{ $shop->description ?: 'Belum ada deskripsi toko.' }}</div>
                    </div>
                    <div class="row">
                        <strong>Alamat</strong>
                        <div class="value">{{ $shop->address }}</div>
                    </div>
                    <div class="row">
                        <strong>Telepon</strong>
                        <div class="value">{{ $shop->phone ?: '-' }}</div>
                    </div>

                    <a href="{{ route('customer.cart.index') }}" class="btn-cart-action">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Lihat Keranjang Belanja
                    </a>
                </div>

                <!-- Card: Layanan -->
                <div class="card">
                    <div class="card-header">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        <h2>Layanan Percetakan</h2>
                    </div>

                    @forelse($shop->services as $service)
                        @if($loop->first)
                            <div class="service-grid">
                        @endif

                        <div class="service-card">
                            <div class="service-top">
                                <span class="service-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                                </span>
                                <div style="min-width:0;">
                                    <h3 class="service-name">{{ $service->name }}</h3>
                                    <div class="service-cat">Kategori: {{ $service->category->name ?? '-' }}</div>
                                </div>
                            </div>

                            <p class="service-desc">{{ $service->description ?: 'Tidak ada deskripsi layanan.' }}</p>

                            <div class="service-price-row">
                                <span class="service-price-label">Harga</span>
                                <span class="service-price">
                                    Rp{{ number_format((float) $service->price, 0, ',', '.') }}
                                    <span>/ {{ $service->unit }}</span>
                                </span>
                            </div>

                            @if ($service->is_active && $shop->is_active)
                                <form action="{{ route('customer.cart.add', $service->id) }}" method="POST" class="cart-form">
                                    @csrf
                                    <div class="qty-input-wrap">
                                        <input
                                            type="number"
                                            id="quantity-{{ $service->id }}"
                                            name="quantity"
                                            class="qty-input"
                                            value="1"
                                            min="1"
                                            max="99999"
                                            required
                                            title="Jumlah"
                                            placeholder="Qty"
                                        >
                                    </div>
                                    <button type="submit" class="btn-add-cart">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <div class="service-unavailable">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    Layanan tidak tersedia.
                                </div>
                            @endif
                        </div>

                        @if($loop->last)
                            </div>
                        @endif
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                            </div>
                            <h3>Belum ada layanan</h3>
                            <p>Toko ini belum menambahkan layanan percetakan.</p>
                        </div>
                    @endforelse
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
