<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Merchant - Printar</title>
</head>
<body>

    <h1>PRINTAR - MERCHANT</h1>

    <h2>Dashboard Pemilik Toko</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <hr>

    <h3>Menu Merchant</h3>

    <ul>
        <li>
            <a href="{{ route('merchant.shops.index') }}">
                Kelola Toko
            </a>
        </li>

        <li>
            <a href="{{ route('merchant.services.index') }}">
                Kelola Layanan Percetakan
            </a>
        </li>

        <li>Kelola Harga Layanan</li>

        <li>
            <a href="{{ route('merchant.orders.index') }}">
                Kelola Pesanan Masuk
            </a>
        </li>

        <li>Kelola Pengiriman</li>
        <li>Riwayat Transaksi</li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
