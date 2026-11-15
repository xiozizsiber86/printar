<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->name }} - Printar</title>
</head>
<body>

    <h1>PRINTAR</h1>
    <h2>{{ $shop->name }}</h2>

    <p>{{ $shop->description ?: 'Belum ada deskripsi toko.' }}</p>

    <p><strong>Alamat:</strong> {{ $shop->address }}</p>
    <p><strong>Telepon:</strong> {{ $shop->phone ?: '-' }}</p>

    <hr>

    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p style="color: red;">
            {{ session('error') }}
        </p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h3>Layanan Percetakan</h3>

    @forelse($shop->services as $service)
        <div>
            <h4>{{ $service->name }}</h4>

            <p>
                Kategori:
                {{ $service->category->name ?? '-' }}
            </p>

            <p>
                {{ $service->description ?: 'Tidak ada deskripsi layanan.' }}
            </p>

            <p>
                Harga:
                Rp{{ number_format((float) $service->price, 0, ',', '.') }}
                / {{ $service->unit }}
            </p>

            @if ($service->is_active && $shop->is_active)
                <form action="{{ route('customer.cart.add', $service->id) }}"
                      method="POST">
                    @csrf

                    <label for="quantity-{{ $service->id }}">
                        Jumlah:
                    </label>

                    <input
                        type="number"
                        id="quantity-{{ $service->id }}"
                        name="quantity"
                        value="1"
                        min="1"
                        max="99999"
                        required
                    >

                    <button type="submit">
                        Tambah ke Keranjang
                    </button>
                </form>
            @else
                <p style="color: red;">
                    Layanan tidak tersedia.
                </p>
            @endif
        </div>

        <hr>
    @empty
        <p>Belum ada layanan di toko ini.</p>
    @endforelse

    <p>
        <a href="{{ route('customer.cart.index') }}">
            Lihat Keranjang Belanja
        </a>
    </p>

    <p>
        <a href="{{ route('customer.shops.index') }}">
            Kembali ke Daftar Toko
        </a>
    </p>

</body>
</html>
