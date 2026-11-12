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
        </div>

        <hr>
    @empty
        <p>Belum ada layanan aktif di toko ini.</p>
    @endforelse

    <p>
        <a href="{{ route('customer.shops.index') }}">
            Kembali ke Daftar Toko
        </a>
    </p>

</body>
</html>

