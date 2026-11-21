<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PRINTAR - Layanan Cetak Online</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 110px; /* offset untuk navbar fixed */
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #101b3c;
            background: #f4f8ff;
            overflow-x: hidden; /* cegah scroll horizontal */
        }

        /* ===================== */
        /* NAVBAR                */
        /* ===================== */
        .navbar {
            position: fixed;
            top: 18px;
            left: 4%;
            width: 92%;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(20,50,100,.08);
        }

        .logo {
            font-size: 26px;
            font-weight: 800;
            color: #1555df;
            letter-spacing: -1px;
            line-height: 1;
        }

        .logo span {
            display: block;
            color: #25365e;
            font-size: 10px;
            letter-spacing: 1px;
            font-weight: 600;
            margin-top: 4px;
        }

        .nav-menu {
            display: flex;
            gap: 34px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #263653;
            font-weight: 600;
            font-size: 14px;
            transition: color .2s;
        }

        .nav-menu a:hover {
            color: #1555df;
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: .3s;
            text-align: center;
            white-space: nowrap;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-outline {
            color: #1555df;
            border: 1px solid #1555df;
            background: transparent;
        }

        .btn-primary {
            color: white;
            background: #1555df;
            border: 1px solid #1555df;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(21,85,223,.2);
        }

        .btn-primary:hover {
            background: #1249bd;
            border-color: #1249bd;
        }

        /* ===================== */
        /* HERO                  */
        /* ===================== */
        .hero {
            min-height: 760px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 160px 7% 90px;
            background:
                linear-gradient(
                    90deg,
                    rgba(241,247,255,.99) 0%,
                    rgba(241,247,255,.96) 38%,
                    rgba(241,247,255,.65) 58%,
                    rgba(241,247,255,.10) 100%
                ),
                url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=2000&q=85');
            background-size: cover;
            background-position: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .badge {
            display: inline-block;
            padding: 10px 19px;
            background: #dceaff;
            color: #1555df;
            border-radius: 30px;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 26px;
        }

        .hero h1 {
            font-size: clamp(32px, 5vw, 65px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: #1555df;
        }

        .hero p {
            color: #61718d;
            font-size: clamp(15px, 1.2vw, 17px);
            line-height: 1.8;
            max-width: 620px;
            margin-bottom: 28px;
        }

        .features {
            display: flex;
            gap: 35px;
            margin: 28px 0;
            flex-wrap: wrap;
        }

        .feature {
            color: #344564;
            font-size: 13px;
            font-weight: 600;
        }

        .feature strong {
            display: block;
            color: #1555df;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hero-buttons .btn {
            padding: 15px 25px;
            font-size: 15px;
        }

        /* ===================== */
        /* SECTION               */
        /* ===================== */
        .section {
            padding: 80px 7%;
            text-align: center;
        }

        .section h2 {
            font-size: clamp(26px, 3vw, 34px);
            margin-bottom: 14px;
            color: #15213d;
            letter-spacing: -.5px;
        }

        .section > p {
            color: #71809a;
            margin-bottom: 40px;
            font-size: 15px;
            line-height: 1.7;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            padding: 35px 25px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(20,50,100,.06);
            transition: transform .25s, box-shadow .25s;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 40px rgba(20,50,100,.12);
        }

        .service-card .icon {
            font-size: 35px;
            margin-bottom: 18px;
        }

        .service-card h3 {
            margin-bottom: 12px;
            color: #1555df;
            font-size: 18px;
        }

        .service-card p {
            color: #71809a;
            font-size: 14px;
            line-height: 1.7;
        }

        footer {
            padding: 25px 20px;
            text-align: center;
            color: #71809a;
            background: white;
            font-size: 13px;
            border-top: 1px solid #e5edfa;
        }

        /* ===================== */
        /* RESPONSIVE            */
        /* ===================== */

        /* Tablet & layar sedang */
        @media (max-width: 992px) {
            .navbar {
                top: 14px;
                left: 3%;
                width: 94%;
                padding: 14px 22px;
            }

            .nav-menu {
                gap: 24px;
            }

            .nav-menu a {
                font-size: 13px;
            }

            .btn {
                padding: 11px 18px;
                font-size: 13px;
            }

            .hero {
                padding: 150px 6% 80px;
                min-height: 680px;
            }

            .section {
                padding: 70px 6%;
            }

            .service-grid {
                gap: 20px;
            }
        }

        /* Mobile landscape & tablet kecil */
        @media (max-width: 850px) {
            .navbar {
                padding: 14px 20px;
            }

            .nav-menu {
                display: none; /* sembunyikan menu di mobile */
            }

            .hero {
                min-height: auto;
                padding: 140px 6% 70px;
                background:
                    linear-gradient(
                        90deg,
                        rgba(241,247,255,.97),
                        rgba(241,247,255,.85)
                    ),
                    url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=85');
                background-size: cover;
                background-position: center;
            }

            .hero-content {
                max-width: 100%;
            }

            .service-grid {
                grid-template-columns: 1fr 1fr;
                max-width: 700px;
            }

            /* Card terakhir agar rata tengah jika jumlah ganjil */
            .service-grid .service-card:last-child:nth-child(odd) {
                grid-column: 1 / -1;
                max-width: 380px;
                margin: 0 auto;
            }
        }

        /* Mobile besar */
        @media (max-width: 600px) {
            html {
                scroll-padding-top: 95px;
            }

            .navbar {
                top: 10px;
                left: 4%;
                width: 92%;
                padding: 12px 16px;
                border-radius: 14px;
            }

            .logo {
                font-size: 21px;
            }

            .logo span {
                font-size: 9px;
            }

            .nav-buttons {
                gap: 8px;
            }

            .nav-buttons .btn {
                padding: 9px 14px;
                font-size: 12px;
                border-radius: 8px;
            }

            .hero {
                padding: 120px 6% 60px;
                background:
                    linear-gradient(
                        180deg,
                        rgba(241,247,255,.98) 0%,
                        rgba(241,247,255,.92) 60%,
                        rgba(241,247,255,.85) 100%
                    ),
                    url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=900&q=80');
                background-size: cover;
                background-position: center;
            }

            .badge {
                font-size: 12.5px;
                padding: 8px 16px;
                margin-bottom: 20px;
            }

            .hero h1 {
                letter-spacing: -1px;
                margin-bottom: 18px;
            }

            .hero p {
                font-size: 14.5px;
                line-height: 1.7;
                margin-bottom: 24px;
            }

            .features {
                gap: 16px 24px;
                margin: 22px 0;
            }

            .feature {
                font-size: 12.5px;
            }

            .feature strong {
                font-size: 18px;
                margin-bottom: 3px;
            }

            .hero-buttons {
                gap: 10px;
            }

            .hero-buttons .btn {
                padding: 13px 20px;
                font-size: 14px;
                flex: 1 1 auto;
            }

            .section {
                padding: 60px 6%;
            }

            .service-grid {
                grid-template-columns: 1fr;
                gap: 18px;
                max-width: 420px;
            }

            .service-grid .service-card:last-child:nth-child(odd) {
                grid-column: auto;
                max-width: none;
            }

            .service-card {
                padding: 28px 22px;
            }

            .service-card .icon {
                font-size: 30px;
                margin-bottom: 14px;
            }

            .service-card h3 {
                font-size: 17px;
            }

            .service-card p {
                font-size: 13.5px;
            }

            footer {
                font-size: 12px;
                padding: 20px 16px;
            }
        }

        /* Mobile sangat kecil */
        @media (max-width: 380px) {
            .navbar {
                padding: 10px 12px;
            }

            .logo {
                font-size: 18px;
            }

            .logo span {
                font-size: 8px;
                letter-spacing: .5px;
            }

            .nav-buttons .btn {
                padding: 8px 10px;
                font-size: 11.5px;
            }

            .hero {
                padding: 105px 5% 50px;
            }

            .badge {
                font-size: 11.5px;
                padding: 7px 14px;
            }

            .hero-buttons .btn {
                padding: 12px 16px;
                font-size: 13px;
                width: 100%;
            }

            .feature {
                font-size: 12px;
            }

            .service-card {
                padding: 24px 18px;
            }
        }

        /* Landscape mobile (layar pendek & lebar) */
        @media (max-height: 520px) and (orientation: landscape) {
            .navbar {
                top: 8px;
                padding: 10px 18px;
            }

            .hero {
                padding-top: 100px;
                padding-bottom: 50px;
                min-height: auto;
            }

            .hero h1 {
                font-size: 32px;
                margin-bottom: 14px;
            }

            .hero p {
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 18px;
            }

            .features {
                gap: 12px 22px;
                margin: 16px 0;
            }

            .feature strong {
                display: inline;
                font-size: 14px;
                margin-right: 6px;
            }

            .hero-buttons .btn {
                padding: 11px 18px;
                font-size: 13px;
            }

            .section {
                padding: 50px 6%;
            }

            .service-card {
                padding: 22px 18px;
            }
        }

        /* Desktop lebar */
        @media (min-width: 1400px) {
            .hero {
                padding-left: 8%;
                padding-right: 8%;
            }

            .hero-content {
                max-width: 780px;
            }

            .section {
                padding-left: 8%;
                padding-right: 8%;
            }

            .service-grid {
                max-width: 1280px;
            }
        }

        /* Prefer reduced motion */
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .btn,
            .service-card {
                transition: none;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="logo">
            PRINTAR
            <span>PRINT LEBIH MUDAH</span>
        </div>

        <nav class="nav-menu">
            <a href="/">Beranda</a>
            <a href="#layanan">Layanan</a>
            <a href="#cara-kerja">Cara Kerja</a>
        </nav>

        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">

            <div class="badge">
                ⚡ Solusi Cetak Online
            </div>

            <h1>
                Kebutuhan Cetak
                Jadi Lebih
                <span>Mudah dan Praktis</span>
            </h1>

            <p>
                Pesan berbagai layanan percetakan secara online,
                dengan kualitas terbaik, harga bersahabat,
                dan proses pemesanan yang lebih mudah.
            </p>

            <div class="features">
                <div class="feature">
                    <strong>✓</strong>
                    Proses Cepat
                </div>

                <div class="feature">
                    <strong>✓</strong>
                    Kualitas Terbaik
                </div>

                <div class="feature">
                    <strong>✓</strong>
                    Harga Bersahabat
                </div>

                <div class="feature">
                    <strong>✓</strong>
                    Customer Support
                </div>
            </div>

            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Mulai Sekarang →
                </a>

                <a href="#layanan" class="btn btn-outline">
                    Lihat Layanan
                </a>
            </div>

        </div>
    </section>

    <!-- LAYANAN -->
    <section class="section" id="layanan">
        <h2>Layanan Percetakan Kami</h2>

        <p>
            Berbagai kebutuhan cetak tersedia dalam satu platform.
        </p>

        <div class="service-grid">

            <div class="service-card">
                <div class="icon">📄</div>
                <h3>Cetak Dokumen</h3>
                <p>
                    Cetak tugas kuliah, makalah, laporan,
                    dan berbagai dokumen lainnya.
                </p>
            </div>

            <div class="service-card">
                <div class="icon">📚</div>
                <h3>Jilid dan Fotokopi</h3>
                <p>
                    Layanan jilid dan fotokopi untuk
                    kebutuhan akademik dan pekerjaan.
                </p>
            </div>

            <div class="service-card">
                <div class="icon">🎨</div>
                <h3>Cetak Desain</h3>
                <p>
                    Cetak poster, brosur, banner,
                    dan kebutuhan desain lainnya.
                </p>
            </div>

        </div>
    </section>

    <!-- CARA KERJA -->
    <section class="section" id="cara-kerja">
        <h2>Cara Kerja Printar</h2>

        <p>
            Pesan kebutuhan cetak dengan mudah melalui beberapa langkah.
        </p>

        <div class="service-grid">
            <div class="service-card">
                <div class="icon">🔎</div>
                <h3>1. Pilih Toko</h3>
                <p>Temukan toko percetakan yang sesuai dengan kebutuhanmu.</p>
            </div>

            <div class="service-card">
                <div class="icon">📤</div>
                <h3>2. Upload Dokumen</h3>
                <p>Pilih layanan dan unggah dokumen yang ingin dicetak.</p>
            </div>

            <div class="service-card">
                <div class="icon">🚚</div>
                <h3>3. Pesanan Selesai</h3>
                <p>Pantau pesanan dan pilih pengiriman atau ambil sendiri.</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        © {{ date('Y') }} PRINTAR. Semua Hak Dilindungi.
    </footer>

</body>
</html>
