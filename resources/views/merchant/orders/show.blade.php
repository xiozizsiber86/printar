<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Printar</title>
</head>
<body>

    <h1>PRINTAR - MERCHANT</h1>
    <h2>Detail Pesanan</h2>

    <hr>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <h3>Informasi Pesanan</h3>

    <p>Nomor Pesanan: {{ $order->order_number }}</p>
    <p>Status: {{ ucfirst($order->status) }}</p>
    <p>Tanggal Pesanan: {{ $order->created_at->format('d-m-Y H:i') }}</p>
    <p>Catatan: {{ $order->notes ?? '-' }}</p>

    <hr>

    <h3>Tindakan Pesanan</h3>

    @if ($order->status === 'pending')

        <form method="POST" action="{{ route('merchant.orders.accept', $order->id) }}">
            @csrf
            <button type="submit"
                onclick="return confirm('Apakah kamu yakin ingin menerima pesanan ini?')">
                Terima Pesanan
            </button>
        </form>

        <br>

        <form method="POST" action="{{ route('merchant.orders.reject', $order->id) }}">
            @csrf
            <button type="submit"
                onclick="return confirm('Apakah kamu yakin ingin menolak pesanan ini?')">
                Tolak Pesanan
            </button>
        </form>

    @elseif ($order->status === 'confirmed')

        <p>Pesanan sudah diterima dan menunggu pengerjaan.</p>

        <form method="POST" action="{{ route('merchant.orders.process', $order->id) }}">
            @csrf
            <button type="submit"
                onclick="return confirm('Mulai kerjakan pesanan ini?')">
                Mulai Proses
            </button>
        </form>

    @elseif ($order->status === 'processing')

        <p>Pesanan sedang dikerjakan.</p>

        <form method="POST" action="{{ route('merchant.orders.ready', $order->id) }}">
            @csrf
            <button type="submit"
                onclick="return confirm('Tandai pesanan sudah siap?')">
                Tandai Pesanan Siap
            </button>
        </form>

    @elseif ($order->status === 'ready')

        <p>Pesanan sudah siap diambil atau dikirim.</p>

        @if ($order->delivery && $order->delivery->delivery_method === 'delivery')

            @if (!$order->delivery->shipped_at)

                <form method="POST" action="{{ route('merchant.orders.shipped', $order->id) }}">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Apakah pesanan sudah diserahkan kepada kurir?')">
                        Tandai Sudah Dikirim
                    </button>
                </form>

            @else

                <p>Waktu pengiriman: {{ $order->delivery->shipped_at->format('d-m-Y H:i') }}</p>

                <form method="POST" action="{{ route('merchant.orders.complete', $order->id) }}">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Apakah pesanan sudah diterima pelanggan?')">
                        Selesaikan Pesanan
                    </button>
                </form>

            @endif

        @elseif ($order->delivery && $order->delivery->delivery_method === 'pickup')

            <p>Pesanan menunggu diambil pelanggan.</p>

            <form method="POST" action="{{ route('merchant.orders.complete', $order->id) }}">
                @csrf
                <button type="submit"
                    onclick="return confirm('Apakah pelanggan sudah mengambil pesanan?')">
                    Selesaikan Pesanan
                </button>
            </form>

        @else

            <p>Data pengiriman belum tersedia.</p>

        @endif

    @elseif ($order->status === 'completed')

        <p>Pesanan sudah selesai.</p>

        @elseif ($order->status === 'rejected')

        <p>Pesanan telah ditolak.</p>

    @else

        <p>Tidak ada tindakan yang tersedia untuk status pesanan ini.</p>

    @endif

    <hr>

    <h3>Informasi Pelanggan</h3>

    <p>Nama: {{ $order->user->name }}</p>
    <p>Email: {{ $order->user->email }}</p>

    @if ($order->address)
        <p>Penerima: {{ $order->address->recipient_name }}</p>
        <p>Telepon: {{ $order->address->phone }}</p>
        <p>Alamat: {{ $order->address->address }}</p>
    @else
        <p>Alamat pengiriman: Tidak tersedia</p>
    @endif

    <hr>

    <h3>Daftar Layanan</h3>

    @forelse ($order->items as $item)

        <div>
            <h4>{{ $item->service_name }}</h4>
            <p>Harga: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
            <p>Jumlah: {{ $item->quantity }} {{ $item->unit }}</p>
            <p>Subtotal: Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>

            <h5>File Cetak</h5>

            @forelse ($item->files as $file)
                <p>
                    {{ $file->original_name }}
                    ({{ $file->mime_type ?? 'Tipe tidak diketahui' }})
                </p>
            @empty
                <p>Tidak ada file yang diunggah.</p>
            @endforelse
        </div>

        <hr>

    @empty
        <p>Tidak ada item pesanan.</p>
    @endforelse

    <h3>Ringkasan Pembayaran</h3>

    <p>Subtotal: Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
    <p>Biaya Pengiriman: Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</p>
    <p>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>

    @if ($order->payment)
        <p>Metode Pembayaran: {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</p>
        <p>Status Pembayaran: {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}</p>
    @else
        <p>Belum ada informasi pembayaran.</p>
    @endif

    <hr>

    <h3>Informasi Pengiriman</h3>

    @if ($order->delivery)
        <p>Metode: {{ ucfirst($order->delivery->delivery_method) }}</p>
        <p>Kurir: {{ $order->delivery->courier_name ?? '-' }}</p>
        <p>Telepon Kurir: {{ $order->delivery->courier_phone ?? '-' }}</p>
        <p>Waktu Dikirim:
            {{ $order->delivery->shipped_at?->format('d-m-Y H:i') ?? '-' }}
        </p>
        <p>Waktu Diterima:
            {{ $order->delivery->received_at?->format('d-m-Y H:i') ?? '-' }}
        </p>
    @else
        <p>Belum ada informasi pengiriman.</p>
    @endif

    <hr>

    <a href="{{ route('merchant.orders.index') }}">
        Kembali ke Daftar Pesanan
    </a>

</body>
</html>
