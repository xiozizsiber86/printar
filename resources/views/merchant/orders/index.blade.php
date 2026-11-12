<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - Printar</title>
</head>
<body>

    <h1>PRINTAR - MERCHANT</h1>
    <h2>Daftar Pesanan Masuk</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <hr>

    @forelse ($shops as $shop)
        <h3>Toko: {{ $shop->name }}</h3>

        @forelse ($shop->orders as $order)
            <div>
                <h4>Nomor Pesanan: {{ $order->order_number }}</h4>

                <p>Pelanggan: {{ $order->user->name }}</p>

                <p>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>

                <p>Status Pesanan: {{ ucfirst($order->status) }}</p>

                <p>
                    Status Pembayaran:
                    {{ $order->payment ? ucfirst($order->payment->status) : 'Belum ada pembayaran' }}
                </p>

                <a href="{{ route('merchant.orders.show', $order->id) }}">
                    Lihat Detail Pesanan
                </a>
            </div>

            <hr>
        @empty
            <p>Belum ada pesanan untuk toko ini.</p>
        @endforelse

    @empty
        <p>Belum ada toko yang terdaftar.</p>
    @endforelse

    <a href="{{ route('merchant.dashboard') }}">
        Kembali ke Dashboard
    </a>

</body>
</html>
