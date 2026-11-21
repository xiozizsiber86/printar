<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Printar</title>
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 50%, #0f172a 100%);
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            min-height: 100dvh; /* fix untuk mobile browser address bar */
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .35);
            animation: fadeUp .5s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .4);
        }

        h1 {
            color: #1e293b;
            text-align: center;
            margin: 12px 0 6px;
            font-size: 26px;
            letter-spacing: 2px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 28px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #334155;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group input {
            width: 100%;
            padding: 13px 44px 13px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .input-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .15);
        }

        .input-group.no-toggle input {
            padding-right: 14px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: color .2s;
            -webkit-tap-highlight-color: transparent;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        .toggle-password svg {
            width: 22px;
            height: 22px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: .5px;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 6px 18px rgba(37, 99, 235, .35);
            -webkit-tap-highlight-color: transparent;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 9px 22px rgba(37, 99, 235, .45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error {
            color: #dc2626;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            margin-bottom: 18px;
            word-wrap: break-word;
        }

        .register-link {
            margin-top: 22px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .register-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* ============================= */
        /* RESPONSIVE BREAKPOINTS        */
        /* ============================= */

        /* Tablet & layar sedang */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .login-container {
                max-width: 460px;
                padding: 36px 30px;
            }
        }

        /* Mobile besar */
        @media (max-width: 480px) {
            body {
                padding: 12px;
                align-items: flex-start; /* konten mulai dari atas saat layar pendek */
                padding-top: 30px;
                padding-bottom: 30px;
            }

            .login-container {
                max-width: 100%;
                padding: 28px 22px;
                border-radius: 16px;
            }

            .logo-circle {
                width: 52px;
                height: 52px;
                font-size: 24px;
                border-radius: 14px;
            }

            h1 {
                font-size: 22px;
                letter-spacing: 1.5px;
            }

            .subtitle {
                font-size: 13px;
                margin-bottom: 22px;
            }

            label {
                font-size: 13.5px;
            }

            .input-group input {
                padding: 12px 42px 12px 12px;
                font-size: 16px; /* cegah zoom otomatis di iOS */
                border-radius: 9px;
            }

            .toggle-password {
                right: 10px;
            }

            .toggle-password svg {
                width: 20px;
                height: 20px;
            }

            .btn-submit {
                padding: 13px;
                font-size: 15px;
            }

            .error {
                font-size: 13px;
                padding: 9px 11px;
            }

            .register-link {
                font-size: 13px;
                margin-top: 18px;
            }
        }

        /* Mobile sangat kecil */
        @media (max-width: 360px) {
            body {
                padding: 8px;
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .login-container {
                padding: 22px 16px;
                border-radius: 14px;
            }

            h1 {
                font-size: 20px;
            }

            .subtitle {
                font-size: 12.5px;
            }
        }

        /* Landscape mobile (layar pendek & lebar) */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                align-items: flex-start;
                padding-top: 16px;
                padding-bottom: 16px;
            }

            .login-container {
                padding: 24px 28px;
                max-width: 520px;
            }

            .logo-circle {
                width: 46px;
                height: 46px;
                font-size: 22px;
            }

            h1 {
                font-size: 20px;
                margin: 8px 0 4px;
            }

            .subtitle {
                margin-bottom: 16px;
                font-size: 13px;
            }

            .input-group {
                margin-bottom: 14px;
            }

            .btn-submit {
                padding: 12px;
            }
        }

        /* Layar besar / desktop lebar */
        @media (min-width: 1200px) {
            .login-container {
                max-width: 440px;
                padding: 46px 40px;
            }
        }

        /* Prefer reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .login-container {
                animation: none;
            }

            .btn-submit {
                transition: none;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo">
        <div class="logo-circle">P</div>
    </div>
    <h1>PRINTAR</h1>
    <p class="subtitle">Masuk ke akun Printar Anda</p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <label for="email">Email</label>
        <div class="input-group no-toggle">
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
                autofocus
                autocomplete="email"
            >
        </div>

        <label for="password">Password</label>
        <div class="input-group">
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
            >
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L9.88 9.88" />
                </svg>
                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
        </div>

        <button type="submit" class="btn-submit">Masuk</button>
    </form>

    <div class="register-link">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('password');
    const eyeOpen        = document.getElementById('eyeOpen');
    const eyeClosed      = document.getElementById('eyeClosed');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        eyeOpen.style.display   = isPassword ? 'block' : 'none';
        eyeClosed.style.display = isPassword ? 'none'  : 'block';

        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });
</script>

</body>
</html>
