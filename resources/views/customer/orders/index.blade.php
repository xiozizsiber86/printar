<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Printar</title>
</head>
<body>

    <h1>PRINTAR</h1>
    <h2>Riwayat Pesanan Saya</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <p>
        <a href="{{ route('customer.dashboard') }}">Kembali ke Dashboard</a>
    </p>

    <hr>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @forelse ($orders as $order)

        <div>
            <h3>{{ $order->order_number }}</h3>

            <p>
                Toko:
                {{ $order->shop->name ?? 'Toko tidak tersedia' }}
            </p>

            <p>
                Tanggal:
                {{ $order->created_at->format('d-m-Y H:i') }}
            </p>

            <p>
                Total:
                Rp{{ number_format($order->total_price, 0, ',', '.') }}
            </p>

            <p>
                Status:
                <strong>{{ ucfirst($order->status) }}</strong>
            </p>

            <p>
                Pembayaran:
                {{ $order->payment
                    ? ucfirst(str_replace('_', ' ', $order->payment->status))
                    : 'Belum tersedia' }}
            </p>

            <a href="{{ route('customer.orders.show', $order->id) }}">
                Lihat Detail dan Lacak Pesanan
            </a>
        </div>

        <hr>

    @empty

        <p>Belum ada riwayat pesanan.</p>

    @endforelse

    {{ $orders->links() }}

</body>
</html>
