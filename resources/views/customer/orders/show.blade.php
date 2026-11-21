<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Printar</title>
    <meta name="description" content="Detail dan pelacakan pesanan customer Printar.">

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

        /* Cards & Layout */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            align-items: start;
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
            width: 160px;
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

        /* Forms & Inputs */
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
        textarea.form-control { resize: vertical; min-height: 80px; }

        /* Buttons */
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
        .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
        .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4); }
        .btn-primary { background: linear-gradient(135deg, #2b7de0, #5fa8f5); box-shadow: 0 4px 12px rgba(43, 125, 224, 0.3); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(43, 125, 224, 0.4); }
        .btn-success { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
        .btn-success:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4); }
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

        .btn-danger-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 600;
            color: #e05555;
            background: rgba(224, 85, 85, 0.06);
            border: 1px solid rgba(224, 85, 85, 0.25);
            cursor: pointer;
            font-family: inherit;
            transition: all .2s;
        }
        .btn-danger-outline:hover { background: #e05555; color: #fff; border-color: #e05555; }
        .btn-danger-outline svg { width: 14px; height: 14px; }

        /* Timeline */
        .timeline {
            margin: 10px 0 0 0;
            padding-left: 10px;
        }
        .timeline-item {
            position: relative;
            padding: 0 0 25px 30px;
            border-left: 2px solid rgba(90, 130, 175, 0.2);
            margin-left: 8px;
        }
        .timeline-item:last-child {
            border-left: 2px solid transparent;
            padding-bottom: 0;
        }
        .timeline-dot {
            position: absolute;
            left: -9px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #94a8bf;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.8);
        }
        .timeline-dot.completed { background: #16a36a; border-color: #16a36a; }
        .timeline-dot.cancelled,
        .timeline-dot.rejected { background: #e05555; border-color: #e05555; }
        
        .timeline-content {
            padding: 14px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.12);
        }
        .timeline-content h4 {
            font-size: .9rem;
            font-weight: 700;
            color: #1a3a5c;
            margin: 0 0 8px 0;
        }
        .timeline-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: .78rem;
            color: #6b829e;
        }
        .timeline-meta strong { color: #1a3a5c; font-weight: 600; }
        
        .timeline-status-current {
            display: inline-block;
            margin-top: 8px;
            font-size: .72rem;
            font-weight: 700;
            color: #16a36a;
            background: rgba(22, 163, 106, 0.1);
            padding: 3px 8px;
            border-radius: 6px;
        }

        /* Info Message */
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
            margin-top: 16px;
        }
        .info-message svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; }
        .info-message.warning { color: #a87513; background: rgba(245, 190, 65, 0.1); border-color: rgba(245, 190, 65, 0.25); }
        .info-message.danger { color: #b83a3a; background: rgba(224, 85, 85, 0.1); border-color: rgba(224, 85, 85, 0.25); }

        /* File Box */
        .file-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: rgba(235, 244, 255, 0.5);
            border-radius: 8px;
            border: 1px solid rgba(90, 130, 175, 0.1);
            margin-bottom: 8px;
        }
        .file-info { font-size: .8rem; color: #3e5875; min-width: 0; word-break: break-all; }
        .file-info strong { color: #1a3a5c; display: block; margin-bottom: 2px; }

        /* Item List */
        .item-list { display: flex; flex-direction: column; gap: 16px; }
        .item-box {
            padding: 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(90, 130, 175, 0.15);
        }
        .item-box .s-name { font-weight: 700; color: #1a3a5c; font-size: .95rem; margin-bottom: 8px; display: block; }
        .item-details { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: .85rem; color: #5a7290; margin-bottom: 12px; }
        .item-details .amount { font-weight: 600; color: #2b7de0; }
        
        /* Summary Rows */
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(90, 130, 175, 0.15);
            font-size: .9rem;
        }
        .summary-row:last-child { border-bottom: none; }
        .summary-row.total {
            border-top: 1px solid rgba(90, 130, 175, 0.2);
            border-bottom: none;
            margin-top: 8px;
            padding-top: 16px;
        }
        .summary-label { color: #6b829e; font-weight: 600; }
        .summary-value { color: #1a3a5c; font-weight: 600; }
        .summary-row.total .summary-label { color: #1a3a5c; font-weight: 700; font-size: .95rem; }
        .summary-row.total .summary-value { color: #2b7de0; font-weight: 700; font-size: 1.15rem; }

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
            .item-details { grid-template-columns: 1fr; }
            .file-box { flex-direction: column; align-items: flex-start; }
            .file-box form, .file-box a { width: 100%; }
            .file-box button, .file-box a { width: 100%; justify-content: center; }
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
                    <a href="{{ route('customer.shops.index') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Cari Toko Percetakan
                    </a>
                </li>
                <li>
                    <!-- MENU INI YANG DIBERI CLASS ACTIVE -->
                    <a href="{{ route('customer.shops.index') }}" class="active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Lihat Layanan & Harga
                    </a>
                </li>
                <li>
                    <!-- CLASS ACTIVE DIHAPUS DARI SINI -->
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                        Detail Pesanan
                    </h1>
                    <p>Pesanan: <strong>#{{ $order->order_number }}</strong></p>
                </div>
                <div class="top-actions">
                    <a href="{{ route('customer.orders.index') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Kembali ke Riwayat</span>
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

            @php
                $statusLabels = [
                    'pending' => 'Menunggu Konfirmasi Merchant',
                    'confirmed' => 'Pesanan Diterima',
                    'processing' => 'Sedang Dicetak',
                    'ready' => 'Pesanan Siap',
                    'shipped' => 'Pesanan Sedang Dikirim',
                    'completed' => 'Pesanan Selesai',
                    'rejected' => 'Pesanan Ditolak',
                    'cancelled' => 'Pesanan Dibatalkan',
                ];

                $currentStatusLabel = $statusLabels[$order->status] ?? ucfirst($order->status);

                $canManageFiles = in_array($order->status, ['pending', 'confirmed']);
            @endphp

            <div class="content-grid">
                <!-- LEFT COLUMN -->
                <div class="left-col">
                    <!-- Card: Informasi Pesanan -->
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
                            <strong>Tanggal</strong>
                            <div class="value">{{ $order->created_at->format('d-m-Y H:i') }}</div>
                        </div>
                        <div class="row">
                            <strong>Nama Toko</strong>
                            <div class="value">{{ $order->shop->name ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <strong>Status Saat Ini</strong>
                            <div class="value">
                                @php
                                    $badgeClass = 'status-neutral';
                                    if (in_array($order->status, ['pending'])) $badgeClass = 'status-pending';
                                    if (in_array($order->status, ['confirmed', 'processing', 'ready', 'shipped'])) $badgeClass = 'status-info';
                                    if (in_array($order->status, ['completed'])) $badgeClass = 'status-success';
                                    if (in_array($order->status, ['cancelled', 'rejected'])) $badgeClass = 'status-danger';
                                @endphp
                                <span class="status {{ $badgeClass }}">{{ $currentStatusLabel }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <strong>Catatan</strong>
                            <div class="value">{{ $order->notes ?? '-' }}</div>
                        </div>

                        <!-- Pembatalan Pesanan -->
                        @if ($order->status === 'pending')
                            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed rgba(90,130,175,0.15);">
                                <h4 style="font-size: .9rem; color: #e05555; margin-bottom: 8px;">Pembatalan Pesanan</h4>
                                <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">
                                    Pesanan masih menunggu konfirmasi merchant. Kamu masih bisa membatalkan pesanan ini.
                                </p>
                                <form
                                    action="{{ route('customer.orders.cancel', $order->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                                >
                                    @csrf
                                    <div class="form-group">
                                        <label for="cancellation_reason" class="form-label">Alasan Pembatalan (Opsional)</label>
                                        <textarea
                                            id="cancellation_reason"
                                            name="cancellation_reason"
                                            class="form-control"
                                            rows="3"
                                            maxlength="500"
                                            placeholder="Tuliskan alasan pembatalan..."
                                        ></textarea>
                                    </div>
                                    <button type="submit" class="btn-action btn-danger">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            </div>
                        @elseif ($order->status === 'cancelled')
                            <div class="info-message danger" style="margin-top: 20px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                Pesanan ini sudah dibatalkan.
                            </div>
                        @elseif ($order->status !== 'rejected')
                            <div class="info-message warning" style="margin-top: 20px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                Pesanan tidak dapat dibatalkan karena sudah diproses merchant.
                            </div>
                        @endif
                    </div>

                    <!-- Card: Perjalanan Pesanan -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <h2>Perjalanan Pesanan</h2>
                        </div>
                        
                        <p style="font-size: .85rem; color: #6b829e; margin-bottom: 16px;">
                            Berikut adalah riwayat perjalanan pesanan kamu dari awal hingga status terakhir.
                        </p>

                        <div class="timeline">
                            @forelse ($order->statusHistories->sortBy('created_at') as $history)
                                <div class="timeline-item">
                                    <div class="timeline-dot {{ in_array($history->status, ['completed', 'cancelled', 'rejected']) ? $history->status : '' }}"></div>
                                    <div class="timeline-content">
                                        <h4>{{ $statusLabels[$history->status] ?? ucfirst($history->status) }}</h4>
                                        
                                        <div class="timeline-meta">
                                            <div><strong>Waktu:</strong> {{ $history->created_at->format('d-m-Y H:i:s') }}</div>
                                            <div><strong>Oleh:</strong> {{ $history->changedBy->name ?? 'Sistem' }}</div>
                                            <div><strong>Catatan:</strong> {{ $history->notes ?? '-' }}</div>
                                        </div>

                                        @if ($history->status === $order->status)
                                            <span class="timeline-status-current">Status saat ini</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="info-message">Belum ada riwayat perubahan status.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Card: Daftar Layanan & File -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                            <h2>Daftar Layanan dan File Cetak</h2>
                        </div>

                        <div class="item-list">
                            @forelse ($order->items as $item)
                                <div class="item-box">
                                    <span class="s-name">{{ $item->service_name }}</span>
                                    <div class="item-details">
                                        <div>Harga: Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                        <div>Jumlah: {{ $item->quantity }} {{ $item->unit }}</div>
                                        <div style="grid-column: span 2;">Subtotal: <span class="amount">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span></div>
                                    </div>

                                    <div style="font-size: .8rem; font-weight: 700; color: #1a3a5c; margin-bottom: 10px;">File Cetak yang Diunggah:</div>
                                    
                                    @forelse ($item->files as $file)
                                        <div class="file-box">
                                            <div class="file-info">
                                                <strong>{{ $file->original_name }}</strong>
                                                Ukuran: {{ number_format($file->file_size / 1024, 2) }} KB
                                            </div>
                                            @if ($canManageFiles)
                                                <form
                                                    action="{{ route('customer.orders.files.destroy', [$order->id, $file->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus file ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-danger-outline">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                        Hapus File
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="info-message" style="margin-top: 0; padding: 10px 14px; font-size: .8rem;">Belum ada file cetak.</div>
                                    @endforelse

                                    @if ($canManageFiles)
                                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed rgba(90,130,175,0.15);">
                                            <div style="font-size: .8rem; font-weight: 700; color: #1a3a5c; margin-bottom: 8px;">Upload File Cetak Baru:</div>
                                            <form
                                                action="{{ route('customer.orders.files.store', [$order->id, $item->id]) }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                            >
                                                @csrf
                                                <div class="form-group" style="margin-bottom: 10px;">
                                                    <input
                                                        type="file"
                                                        name="files[]"
                                                        class="form-control"
                                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                        multiple
                                                        required
                                                        style="padding: 8px;"
                                                    >
                                                    <p style="font-size: .72rem; color: #6b829e; margin-top: 6px; line-height: 1.4;">
                                                        Format: PDF, DOC, DOCX, JPG, JPEG, PNG. Maks. 10 MB/file, 10 file sekali upload.
                                                    </p>
                                                </div>
                                                <button type="submit" class="btn-action btn-primary">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                                    Upload File
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="info-message warning" style="margin-top: 14px;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                            Upload dan penghapusan file sudah ditutup karena pesanan tidak lagi menunggu konfirmasi.
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="info-message">Tidak ada layanan dalam pesanan ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="right-col">
                    <!-- Card: Informasi Pengiriman -->
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

                            @if ($order->delivery->delivery_method === 'delivery')
                                <div class="row">
                                    <strong>Kurir</strong>
                                    <div class="value">{{ $order->delivery->courier_name ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <strong>Telepon Kurir</strong>
                                    <div class="value">{{ $order->delivery->courier_phone ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <strong>Alamat Pengiriman</strong>
                                    <div class="value">{{ $order->delivery->delivery_address ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <strong>Catatan Pengiriman</strong>
                                    <div class="value">{{ $order->delivery->notes ?? '-' }}</div>
                                </div>
                            @else
                                <div class="info-message" style="margin-top: 12px; padding: 10px 14px; font-size: .8rem;">
                                    Pesanan diambil langsung oleh pelanggan di toko.
                                </div>
                            @endif

                            <div class="row">
                                <strong>Waktu Dikirim</strong>
                                <div class="value">{{ $order->delivery->shipped_at?->format('d-m-Y H:i:s') ?? 'Belum dikirim' }}</div>
                            </div>
                            <div class="row">
                                <strong>Waktu Diterima</strong>
                                <div class="value">{{ $order->delivery->received_at?->format('d-m-Y H:i:s') ?? 'Belum diterima' }}</div>
                            </div>
                        @else
                            <div class="info-message">Informasi pengiriman belum tersedia.</div>
                        @endif
                    </div>

                    <!-- Card: Ringkasan Pembayaran -->
                    <div class="card">
                        <div class="card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                            <h2>Ringkasan Pembayaran</h2>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Biaya Pengiriman</span>
                            <span class="summary-value">Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row total">
                            <span class="summary-label">Total</span>
                            <span class="summary-value">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        @if ($order->payment)
                            <div class="row" style="margin-top: 16px;">
                                <strong>Metode</strong>
                                <div class="value">{{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</div>
                            </div>
                            <div class="row">
                                <strong>Status</strong>
                                <div class="value">
                                    @php
                                        $payClass = 'status-neutral';
                                        if (in_array($order->payment->status, ['pending', 'rejected'])) $payClass = 'status-pending';
                                        if (in_array($order->payment->status, ['paid', 'success', 'verified'])) $payClass = 'status-success';
                                    @endphp
                                    <span class="status {{ $payClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}
                                    </span>
                                </div>
                            </div>

                            <div style="margin-top: 16px;">
                                @if (in_array($order->payment->status, ['pending', 'rejected']))
                                    <a href="{{ route('customer.payments.show', $order->id) }}" class="btn-action btn-success" style="text-decoration: none;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                                        Bayar Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('customer.payments.show', $order->id) }}" class="btn-action btn-primary" style="text-decoration: none;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Lihat Detail Pembayaran
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="info-message" style="margin-top: 16px;">Informasi pembayaran belum tersedia.</div>
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
