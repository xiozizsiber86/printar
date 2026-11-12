<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Printar</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 440px;
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 5px 25px rgba(0,0,0,.08);
        }

        h1 {
            color: #2563eb;
            text-align: center;
            margin-bottom: 8px;
        }

        p {
            text-align: center;
            color: #64748b;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h1>PRINTAR</h1>
    <p>Buat akun customer Printar</p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <label for="name">Nama lengkap</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Masukkan nama lengkap"
            required
        >

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Masukkan email"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Minimal 8 karakter"
            required
        >

        <label for="password_confirmation">Konfirmasi password</label>
        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Ulangi password"
            required
        >

        <button type="submit">Daftar Sekarang</button>
    </form>

    <div class="login-link">
        Sudah punya akun?
        <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</div>

</body>
</html>
