<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - Printar</title>
</head>
<body>

    <h1>PRINTAR - CUSTOMER</h1>

    <h2>Dashboard Pelanggan</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <hr>

    <h3>Menu Customer</h3>

    <ul>
        <li>
            <a href="{{ route('customer.shops.index') }}">
                Cari Toko Percetakan
            </a>
        </li>

        <li>
            <a href="{{ route('customer.shops.index') }}">
                Lihat Layanan dan Harga
            </a>
        </li>

        <li>
            <a href="{{ route('customer.orders.index') }}">
                Riwayat Pesanan
            </a>
        </li>

        <li>
            <a href="{{ route('customer.orders.index') }}">
                Lacak Status Pesanan
            </a>
        </li>

        <li>
            <a href="{{ route('customer.shops.index') }}">
                Buat Pesanan
            </a>
        </li>

        <li>
            <a href="{{ route('customer.orders.index') }}">
                Upload File Cetak
            </a>
        </li>

        <li>
            <a href="{{ route('customer.addresses.index') }}">
                Kelola Alamat
            </a>
        </li>
    </ul>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>
