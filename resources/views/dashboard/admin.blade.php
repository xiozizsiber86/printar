<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Printar</title>
</head>
<body>

    <h1>PRINTAR - ADMIN</h1>

    <h2>Dashboard Administrator</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <hr>

    <h3>Menu Admin</h3>

    <ul>
        <li>Kelola Pengguna</li>
        <li>Kelola Merchant</li>
        <li>Verifikasi Merchant</li>
        <li>Verifikasi Pembayaran</li>
        <li>Kelola Kategori</li>
        <li>Laporan Transaksi</li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
