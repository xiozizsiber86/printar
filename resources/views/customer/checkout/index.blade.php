<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Printar</title>
</head>
<body>
    <h1>PRINTAR</h1>
    <h2>Checkout Pesanan</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h3>Toko: {{ $cart->shop->name ?? '-' }}</h3>

    <h3>Daftar Layanan</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->items as $item)
                <tr>
                    <td>{{ $item->service->name ?? 'Layanan tidak tersedia' }}</td>
                    <td>
                        Rp{{ number_format((float) ($item->service->price ?? $item->price), 0, ',', '.') }}
                        / {{ $item->service->unit ?? $item->unit }}
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        Rp{{ number_format((float) ($item->service->price ?? $item->price) * $item->quantity, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('customer.checkout.store') }}" method="POST">
        @csrf

        <h3>Metode Pesanan</h3>

        <label>
            <input
                type="radio"
                name="delivery_method"
                value="pickup"
                {{ old('delivery_method', 'delivery') === 'pickup' ? 'checked' : '' }}
                required
            >
            Ambil di Toko
        </label>

        <br>

        <label>
            <input
                type="radio"
                name="delivery_method"
                value="delivery"
                {{ old('delivery_method', 'delivery') === 'delivery' ? 'checked' : '' }}
                required
            >
            Diantar ke Alamat
        </label>

        <h3>Alamat Customer</h3>

        @foreach($addresses as $address)
            <div style="margin-bottom: 15px;">
                <label>
                    <input
                        type="radio"
                        name="address_id"
                        value="{{ $address->id }}"
                        {{ old('address_id', $addresses->firstWhere('is_default', true)?->id ?? $addresses->first()->id) == $address->id ? 'checked' : '' }}
                        required
                    >

                    <strong>{{ $address->label }}</strong>

                    @if($address->is_default)
                        (Alamat Utama)
                    @endif

                    <br>
                    {{ $address->recipient_name }} - {{ $address->phone }}
                    <br>
                    {{ $address->address }}
                </label>
            </div>
        @endforeach

        <p>
            <a href="{{ route('customer.addresses.index') }}">
                Kelola Alamat
            </a>
        </p>

        <h3>Catatan Pesanan</h3>

        <textarea
            name="notes"
            rows="4"
            cols="50"
            maxlength="2000"
            placeholder="Tambahkan catatan untuk toko (opsional)"
        >{{ old('notes') }}</textarea>

        @php
            $subtotal = $cart->items->sum(function ($item) {
                return (float) ($item->service->price ?? $item->price) * $item->quantity;
            });
        @endphp

        <h3>Ringkasan Biaya</h3>

        <p>
            Subtotal:
            Rp{{ number_format($subtotal, 0, ',', '.') }}
        </p>

        <p>Ongkos kirim: Rp0</p>

        <h3>
            Total:
            Rp{{ number_format($subtotal, 0, ',', '.') }}
        </h3>

        <button type="submit">
            Buat Pesanan
        </button>
    </form>

    <p>
        <a href="{{ route('customer.cart.index') }}">
            Kembali ke Keranjang
        </a>
    </p>
</body>
</html>
