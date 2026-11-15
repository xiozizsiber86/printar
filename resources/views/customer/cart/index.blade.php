<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Printar</title>
</head>
<body>

    <h1>PRINTAR</h1>
    <h2>Keranjang Belanja</h2>

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

    @if (!$cart || $cart->items->isEmpty())

        <p>Keranjang belanja masih kosong.</p>

        <a href="{{ route('customer.shops.index') }}">
            Cari Toko Percetakan
        </a>

    @else

        <h3>{{ $cart->shop?->name ?? 'Toko tidak tersedia' }}</h3>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cart->items as $item)
                    <tr>
                        <td>
                            {{ $item->service?->name ?? 'Layanan tidak tersedia' }}
                        </td>

                        <td>
                            Rp{{ number_format((float) $item->price, 0, ',', '.') }}
                            / {{ $item->unit }}
                        </td>

                        <td>
                            <form action="{{ route('customer.cart.update', $item->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $item->quantity }}"
                                    min="1"
                                    max="99999"
                                    required
                                >

                                <button type="submit">
                                    Perbarui
                                </button>
                            </form>
                        </td>

                        <td>
                            Rp{{ number_format((float) $item->subtotal, 0, ',', '.') }}
                        </td>

                        <td>
                            <form action="{{ route('customer.cart.remove', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus layanan ini dari keranjang?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>
            Total:
            Rp{{ number_format((float) $cart->items->sum('subtotal'), 0, ',', '.') }}
        </h3>

        <p>
            <a href="{{ route('customer.checkout.index') }}">
                <button type="button">
                    Lanjut ke Checkout
                </button>
            </a>
        </p>

        <form action="{{ route('customer.cart.clear') }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin mengosongkan seluruh keranjang?')">
            @csrf
            @method('DELETE')

            <button type="submit">
                Kosongkan Keranjang
            </button>
        </form>

    @endif

    <hr>

    <p>
        <a href="{{ route('customer.shops.index') }}">
            Kembali ke Daftar Toko
        </a>
    </p>

</body>
</html>
