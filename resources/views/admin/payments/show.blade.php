<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran - Printar Admin</title>
    <meta name="description" content="Detail pembayaran Printar.">

    @fonts

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap');

        :root {
            --text: #1e3a5f;
            --muted: #6b829e;
            --accent: #2b7de0;
            --success: #16a36a;
            --danger: #e05555;
            --radius: 16px;
            --shadow: 0 8px 32px rgba(30, 60, 100, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Instrument Sans", sans-serif;
            background:
                linear-gradient(rgba(238,246,255,.65), rgba(238,246,255,.75)),
                url('https://images.unsplash.com/photo-1562654501-a0ccc0fc3fb1?q=80&w=1920&auto=format&fit=crop') center/cover fixed;
            color: var(--text);
            min-height: 100vh;
            line-height: 1.5;
        }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(24px);
            border-right: 1px solid white;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 24px 16px;
            overflow-y: auto;
            z-index: 40;
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
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(135deg,#2b7de0,#5fa8f5);
            color: white;
            font-size: 22px;
        }

        .brand-sub { font-size: .65rem; color: #7a94b0; font-weight: 400; }

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
        }

        .nav-menu a:hover { background: rgba(43,125,224,.08); color: var(--accent); }

        .nav-menu a.active {
            background: var(--accent);
            color: white;
            font-weight: 600;
        }

        .nav-badge {
            margin-left: auto;
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            background: #ffe6a8;
            color: #80570a;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(80,120,165,.15);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 12px;
            background: rgba(235,244,255,.8);
            margin-bottom: 12px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 700;
            background: linear-gradient(135deg,#2b7de0,#70b4f5);
            color: white;
        }

        .u-name { font-size: .85rem; font-weight: 600; }
        .u-role { font-size: .72rem; color: #7a94b0; }

        .btn-logout {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            color: #6b829e;
            background: transparent;
            border: 1px solid rgba(80,120,165,.2);
            cursor: pointer;
            font-weight: 600;
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 60;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: white;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(20,40,65,.3);
            z-index: 30;
        }

        .main { flex: 1; min-width: 0; padding: 28px 32px 48px; }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .page-title h1 { font-size: 1.4rem; font-weight: 700; color: #1a3a5c; }
        .page-title p { color: var(--muted); font-size: .85rem; margin-top: 3px; }

        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 9px 16px;
            border-radius: 10px;
            color: var(--accent);
            background: rgba(255,255,255,.85);
            border: 1px solid rgba(43,125,224,.25);
            text-decoration: none;
            font-size: .82rem;
            font-weight: 600;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: .85rem;
            margin-bottom: 16px;
            background: rgba(255,255,255,.85);
        }

        .alert-success { color: #117a4f; border: 1px solid rgba(22,163,106,.3); }
        .alert-danger { color: #b83a3a; border: 1px solid rgba(224,85,85,.3); }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .card {
            border-radius: var(--radius);
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border: 1px solid white;
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
            border-bottom: 1px solid rgba(90,130,175,.12);
        }

        .card-header h2 { font-size: 1.05rem; color: #1a3a5c; }

        .row {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(90,130,175,.15);
            font-size: .9rem;
            gap: 10px;
        }

        .row:last-child { border-bottom: none; }
        .row strong { flex-shrink: 0; width: 180px; color: var(--muted); font-size: .85rem; }
        .value { color: #1a3a5c; font-weight: 500; overflow-wrap: anywhere; }
        .amount { color: var(--accent); font-weight: 700; }

        .status {
            display: inline-flex;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 600;
        }

        .status-pending { color: #d99a1a; background: rgba(217,154,26,.12); }
        .status-waiting_verification { color: var(--accent); background: rgba(43,125,224,.1); }
        .status-paid { color: var(--success); background: rgba(22,163,106,.1); }
        .status-rejected, .status-failed { color: var(--danger); background: rgba(224,85,85,.1); }
        .status-expired { color: #7a94b0; background: rgba(122,148,176,.1); }
        .status-refunded { color: #8b5cf6; background: rgba(139,92,246,.1); }

        .proof-box {
            padding: 20px;
            border-radius: 12px;
            background: rgba(255,255,255,.6);
            border: 1px dashed rgba(90,130,175,.25);
            text-align: center;
        }

        .proof-box.has-proof {
            border-style: solid;
            border-color: rgba(22,163,106,.3);
            background: rgba(22,163,106,.05);
        }

        .proof-text { font-size: .88rem; font-weight: 600; margin-bottom: 12px; }

        .btn-proof {
            display: inline-block;
            padding: 9px 16px;
            border-radius: 8px;
            color: white;
            background: linear-gradient(135deg,#2b7de0,#5fa8f5);
            text-decoration: none;
            font-size: .82rem;
            font-weight: 600;
        }

        .info-message {
            padding: 14px 16px;
            border-radius: 10px;
            font-size: .85rem;
            color: var(--muted);
            background: rgba(235,244,255,.7);
            border: 1px solid rgba(90,130,175,.15);
        }

        .btn-approve, .btn-reject {
            display: block;
            width: 100%;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: .9rem;
            font-weight: 600;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-approve { background: linear-gradient(135deg,#10b981,#34d399); }
        .btn-reject { background: linear-gradient(135deg,#ef4444,#f87171); }

        .action-divider {
            height: 1px;
            background: rgba(90,130,175,.15);
            margin: 24px 0;
        }

        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: .85rem;
            font-family: inherit;
            color: var(--text);
            background: white;
            border: 1px solid rgba(90,130,175,.22);
            min-height: 100px;
            resize: vertical;
            margin-bottom: 16px;
        }

        @media (max-width: 1024px) {
            .content-grid { grid-template-columns: 1fr; }
            .sidebar { position: fixed; left: 0; top: 0; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .mobile-toggle { display: block; }
            .overlay.show { display: block; }
            .main { padding: 80px 20px 40px; }
        }

        @media (max-width: 640px) {
            .main { padding: 76px 14px 36px; }
            .row { flex-direction: column; gap: 4px; }
            .row strong { width: 100%; }
            .card { padding: 18px; }
        }
    </style>
</head>

<body>

<button class="mobile-toggle" id="menuToggle" aria-label="Buka menu">☰</button>
<div class="overlay" id="overlay"></div>

<div class="layout">

    <aside class="sidebar" id="sidebar">
        <a href="{{ url('/') }}" class="brand">
            <span class="brand-mark">P</span>
            <span>PRINTAR</span>
            <span class="brand-sub">Print Your Ideas</span>
        </a>

        <div class="nav-label">Utama</div>
        <ul class="nav-menu">
            <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}">Kelola Pengguna</a></li>
        </ul>

        <div class="nav-label">Verifikasi</div>
        <ul class="nav-menu">
            <li><a href="{{ route('admin.merchants.index') }}">Kelola Merchant</a></li>
            <li><a href="{{ route('admin.shops.index', ['status' => 'pending']) }}">Verifikasi Toko</a></li>
            <li><a href="{{ route('admin.services.index', ['status' => 'pending']) }}">Verifikasi Layanan</a></li>
            <li>
                <a href="{{ route('admin.payments.index') }}" class="active">
                    Verifikasi Pembayaran
                    @if (($waitingPayments ?? 0) > 0)
                        <span class="nav-badge">{{ $waitingPayments }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <div class="nav-label">Master Data</div>
        <ul class="nav-menu">
            <li><a href="{{ route('admin.categories.index') }}">Kelola Kategori</a></li>
            <li><a href="{{ route('admin.reports.transactions') }}">Laporan Transaksi</a></li>
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
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </aside>

    <main class="main">

        <div class="top-bar">
            <div class="page-title">
                <h1>Detail Pembayaran</h1>
                <p>Pesanan: <strong>#{{ $payment->order->order_number ?? '-' }}</strong></p>
            </div>

            <a href="{{ route('admin.payments.index') }}" class="btn-back">
                ← Kembali ke Daftar
            </a>
        </div>

        {{-- Pesan berhasil --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pesan gagal --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Pesan validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="content-grid">

            <div class="left-col">

                <div class="card">
                    <div class="card-header">
                        <h2>Informasi Pesanan</h2>
                    </div>

                    <div class="row">
                        <strong>Nomor Pesanan</strong>
                        <div class="value">{{ $payment->order->order_number ?? '-' }}</div>
                    </div>

                    <div class="row">
                        <strong>Customer</strong>
                        <div class="value">{{ $payment->order->user->name ?? '-' }}</div>
                    </div>

                    <div class="row">
                        <strong>Email</strong>
                        <div class="value">{{ $payment->order->user->email ?? '-' }}</div>
                    </div>

                    <div class="row">
                        <strong>Toko</strong>
                        <div class="value">{{ $payment->order->shop->name ?? '-' }}</div>
                    </div>

                    <div class="row">
                        <strong>Total Pesanan</strong>
                        <div class="value amount">
                            Rp {{ number_format($payment->order->total_price ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Informasi Pembayaran</h2>
                    </div>

                    <div class="row">
                        <strong>Jumlah Pembayaran</strong>
                        <div class="value amount">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="row">
                        <strong>Metode</strong>
                        <div class="value">
                            {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                        </div>
                    </div>

                    <div class="row">
                        <strong>Status</strong>
                        <div class="value">
                            <span class="status status-{{ $payment->status }}">
                                {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <strong>Tanggal Pembayaran</strong>
                        <div class="value">
                            {{ $payment->paid_at ? $payment->paid_at->format('d-m-Y H:i') : 'Belum lunas' }}
                        </div>
                    </div>

                    <div class="row">
                        <strong>Catatan</strong>
                        <div class="value">{{ $payment->notes ?? '-' }}</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Bukti Transfer Customer</h2>
                    </div>

                    @if ($payment->proof_file)
                        <div class="proof-box has-proof">
                            <div class="proof-text">Bukti pembayaran sudah diunggah.</div>

                            <a
                                href="{{ route('admin.payments.proof', $payment->id) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-proof"
                            >
                                Lihat Bukti Transfer
                            </a>
                        </div>
                    @else
                        <div class="proof-box">
                            <div class="proof-text">
                                Customer belum mengunggah bukti transfer.
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <div class="right-col">

                @if (
                    $payment->status === 'waiting_verification' &&
                    $payment->method === 'manual_transfer' &&
                    $payment->proof_file
                )

                    <div class="card">
                        <div class="card-header">
                            <h2>Verifikasi Pembayaran</h2>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('admin.payments.approve', $payment->id) }}"
                            onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?');"
                            style="margin-bottom: 24px;"
                        >
                            @csrf

                            <p style="font-size:.85rem;color:#6b829e;margin-bottom:16px;">
                                Pastikan bukti transfer sudah sesuai sebelum menyetujui.
                            </p>

                            <button type="submit" class="btn-approve">
                                Setujui Pembayaran
                            </button>
                        </form>

                        <div class="action-divider"></div>

                        <form
                            method="POST"
                            action="{{ route('admin.payments.reject', $payment->id) }}"
                            onsubmit="return confirm('Yakin ingin menolak pembayaran ini?');"
                        >
                            @csrf

                            <label for="notes" class="form-label">
                                Alasan Penolakan
                            </label>

                            <textarea
                                name="notes"
                                id="notes"
                                rows="4"
                                class="form-control"
                                placeholder="Tuliskan alasan penolakan pembayaran..."
                                maxlength="500"
                                required
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <p style="color:#e05555;font-size:.8rem;margin-bottom:12px;">
                                    {{ $message }}
                                </p>
                            @enderror

                            <button type="submit" class="btn-reject">
                                Tolak Pembayaran
                            </button>
                        </form>
                    </div>

                @else

                    <div class="card">
                        <div class="card-header">
                            <h2>Informasi</h2>
                        </div>

                        <div class="info-message">
                            @if (!$payment->proof_file)
                                Customer belum mengunggah bukti pembayaran.
                            @elseif ($payment->method !== 'manual_transfer')
                                Metode pembayaran ini belum mendukung verifikasi manual.
                            @else
                                Pembayaran ini tidak sedang menunggu verifikasi.
                                Tindakan verifikasi tidak tersedia.
                            @endif
                        </div>
                    </div>

                @endif

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
        }

        function closeMenu() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }

        toggle.addEventListener('click', function () {
            sidebar.classList.contains('open') ? closeMenu() : openMenu();
        });

        overlay.addEventListener('click', closeMenu);
    })();
</script>

</body>
</html>
