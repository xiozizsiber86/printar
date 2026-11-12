<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Printar</title>
</head>
<body>

    <h1>PRINTAR</h1>
    <h2>Detail dan Pelacakan Pesanan</h2>

    <p>
        <a href="{{ route('customer.orders.index') }}">
            Kembali ke Riwayat Pesanan
        </a>
    </p>

    <hr>

    <h3>Informasi Pesanan</h3>

    <p>Nomor Pesanan: {{ $order->order_number }}</p>
    <p>Tanggal: {{ $order->created_at->format('d-m-Y H:i') }}</p>
    <p>Nama Toko: {{ $order->shop->name ?? '-' }}</p>
    <p>Status Saat Ini: <strong>{{ ucfirst($order->status) }}</strong></p>
    <p>Catatan: {{ $order->notes ?? '-' }}</p>

    <hr>

    <h3>Perjalanan Pesanan</h3>

    @php
        $statusLabels = [
            'pending' => 'Menunggu Konfirmasi Merchant',
            'confirmed' => 'Pesanan Diterima',
            'processing' => 'Sedang Dicetak',
            'ready' => 'Pesanan Siap',
            'completed' => 'Pesanan Selesai',
            'rejected' => 'Pesanan Ditolak',
            'cancelled' => 'Pesanan Dibatalkan',
        ];
    @endphp

    @forelse ($order->statusHistories->sortBy('created_at') as $history)

        <div>
            <h4>
                {{ $statusLabels[$history->status] ?? ucfirst($history->status) }}
            </h4>

            <p>
                Waktu:
                {{ $history->created_at->format('d-m-Y H:i:s') }}
            </p>

            <p>
                Oleh:
                {{ $history->changedBy->name ?? 'Sistem' }}
            </p>

            <p>
                Catatan:
                {{ $history->notes ?? '-' }}
            </p>
        </div>

        <hr>

    @empty

        <p>Belum ada riwayat perubahan status.</p>

    @endforelse

    @if ($order->delivery)

        <h3>Informasi Pengiriman</h3>

        <p>
            Metode:
            {{ ucfirst($order->delivery->delivery_method) }}
        </p>

        <p>
            Kurir:
            {{ $order->delivery->courier_name ?? '-' }}
        </p>

        <p>
            Telepon Kurir:
            {{ $order->delivery->courier_phone ?? '-' }}
        </p>

        <p>
            Alamat Pengiriman:
            {{ $order->delivery->delivery_address ?? '-' }}
        </p>

        <p>
            Waktu Dikirim:
            {{ $order->delivery->shipped_at?->format('d-m-Y H:i:s') ?? 'Belum dikirim' }}
        </p>

        <p>
            Waktu Diterima:
            {{ $order->delivery->received_at?->format('d-m-Y H:i:s') ?? 'Belum diterima' }}
        </p>

    @endif

    <hr>

    <h3>Daftar Layanan</h3>

    @forelse ($order->items as $item)

        <div>
            <h4>{{ $item->service_name }}</h4>

            <p>
                Harga:
                Rp{{ number_format($item->price, 0, ',', '.') }}
            </p>

            <p>
                Jumlah:
                {{ $item->quantity }} {{ $item->unit }}
            </p>

            <p>
                Subtotal:
                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
            </p>

            <h5>File Cetak</h5>

            @forelse ($item->files as $file)

                <p>{{ $file->original_name }}</p>

            @empty

                <p>Tidak ada file cetak.</p>

            @endforelse
        </div>

        <hr>

    @empty

        <p>Tidak ada layanan dalam pesanan ini.</p>

    @endforelse

    <h3>Ringkasan Pembayaran</h3>

    <p>
        Subtotal:
        Rp{{ number_format($order->subtotal, 0, ',', '.') }}
    </p>

    <p>
        Biaya Pengiriman:
        Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}
    </p>

    <p>
        Total:
        Rp{{ number_format($order->total_price, 0, ',', '.') }}
    </p>

    @if ($order->payment)

        <p>
            Metode Pembayaran:
            {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}
        </p>

        <p>
            Status Pembayaran:
            {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}
        </p>

    @else

        <p>Informasi pembayaran belum tersedia.</p>

    @endif

    <hr>

    <a href="{{ route('customer.orders.index') }}">
        Kembali ke Riwayat Pesanan
    </a>

</body>
</html>
