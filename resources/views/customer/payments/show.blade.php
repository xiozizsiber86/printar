<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Printar</title>
</head>
<body>

    <h1>PRINTAR</h1>
    <h2>Pembayaran Pesanan</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>

    <h3>Detail Pesanan</h3>

    <p>
        Nomor Pesanan:
        <strong>{{ $order->order_number }}</strong>
    </p>

    <p>
        Total Pembayaran:
        <strong>
            Rp{{ number_format($order->total_price, 0, ',', '.') }}
        </strong>
    </p>

    <hr>

    <h3>Transfer Manual</h3>

    <p>Silakan transfer sesuai nominal tagihan ke rekening resmi Printar.</p>

    <p>
        <strong>Informasi rekening tujuan belum dikonfigurasi.</strong>
    </p>

    <p>
        Jangan melakukan transfer sebelum informasi rekening resmi Printar
        tersedia dan telah dikonfirmasi oleh Admin.
    </p>

    <hr>

    <h3>Status Pembayaran</h3>

    @if($order->payment)
        <p>
            Status:
            <strong>
                {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}
            </strong>
        </p>

        <p>
            Metode:
            {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}
        </p>

        @if($order->payment->proof_file)
            <p>Bukti transfer sudah diunggah.</p>
        @else
            <p>Bukti transfer belum diunggah.</p>
        @endif

        @if(in_array($order->payment->status, ['pending', 'rejected']))
            <h3>Upload Bukti Transfer</h3>

            <form
                action="{{ route('customer.payments.proof', $order->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <label for="proof_file">Pilih Bukti Transfer:</label>
                <br>

                <input
                    type="file"
                    name="proof_file"
                    id="proof_file"
                    accept=".jpg,.jpeg,.png,.pdf"
                    required
                >

                <p>
                    Format: JPG, JPEG, PNG, PDF.
                    Maksimal ukuran 10 MB.
                </p>

                <button type="submit">
                    Upload Bukti Transfer
                </button>
            </form>
        @elseif($order->payment->status === 'waiting_verification')
            <p style="color: orange;">
                Bukti transfer sedang menunggu verifikasi Admin.
            </p>
        @elseif($order->payment->status === 'paid')
            <p style="color: green;">
                Pembayaran sudah berhasil diverifikasi.
            </p>
        @elseif($order->payment->status === 'rejected')
            <p style="color: red;">
                Pembayaran ditolak. Silakan unggah ulang bukti transfer.
            </p>
        @endif
    @else
        <p>Data pembayaran belum tersedia.</p>
    @endif

    <hr>

    <a href="{{ route('customer.orders.show', $order->id) }}">
        Kembali ke Detail Pesanan
    </a>

</body>
</html>
