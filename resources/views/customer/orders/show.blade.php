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

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

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

        $canManageFiles = in_array($order->status, ['pending', 'confirmed']);
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

        <p>Metode: {{ ucfirst($order->delivery->delivery_method) }}</p>
        <p>Kurir: {{ $order->delivery->courier_name ?? '-' }}</p>
        <p>Telepon Kurir: {{ $order->delivery->courier_phone ?? '-' }}</p>
        <p>Alamat Pengiriman: {{ $order->delivery->delivery_address ?? '-' }}</p>

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

    <h3>Daftar Layanan dan File Cetak</h3>

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

            <h5>File Cetak yang Diunggah</h5>

            @forelse ($item->files as $file)
                <div>
                    <p>Nama file: {{ $file->original_name }}</p>
                    <p>Ukuran: {{ number_format($file->file_size / 1024, 2) }} KB</p>

                    @if ($canManageFiles)
                        <form
                            action="{{ route('customer.orders.files.destroy', [$order->id, $file->id]) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus file ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit">Hapus File</button>
                        </form>
                    @endif
                </div>
                <hr>
            @empty
                <p>Belum ada file cetak.</p>
            @endforelse

            @if ($canManageFiles)
                <h5>Upload File Cetak</h5>

                <form
                    action="{{ route('customer.orders.files.store', [$order->id, $item->id]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <input
                        type="file"
                        name="files[]"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        multiple
                        required
                    >

                    <p>
                        Format: PDF, DOC, DOCX, JPG, JPEG, PNG.
                        Maksimal 10 MB per file dan 10 file sekali upload.
                    </p>

                    <button type="submit">Upload File</button>
                </form>
            @else
                <p>
                    Upload dan penghapusan file sudah ditutup karena
                    pesanan tidak lagi menunggu konfirmasi.
                </p>
            @endif
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
        <strong>
            Rp{{ number_format($order->total_price, 0, ',', '.') }}
        </strong>
    </p>

    @if ($order->payment)
        <p>
            Metode Pembayaran:
            {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}
        </p>

        <p>
            Status Pembayaran:
            <strong>
                {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}
            </strong>
        </p>

        @if (in_array($order->payment->status, ['pending', 'rejected']))
            <p>
                <a href="{{ route('customer.payments.show', $order->id) }}">
                    <button type="button">Bayar Sekarang</button>
                </a>
            </p>
        @else
            <p>
                <a href="{{ route('customer.payments.show', $order->id) }}">
                    Lihat Detail Pembayaran
                </a>
            </p>
        @endif
    @else
        <p>Informasi pembayaran belum tersedia.</p>
    @endif

    <hr>

    <a href="{{ route('customer.orders.index') }}">
        Kembali ke Riwayat Pesanan
    </a>

</body>
</html>
