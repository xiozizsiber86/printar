<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan - Printar</title>
</head>
<body>
    <h1>PRINTAR - MERCHANT</h1>
    <h2>Daftar Layanan Percetakan</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <hr>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('merchant.services.create') }}">
        + Tambah Layanan
    </a>

    <hr>

    @forelse ($shops as $shop)
        <h3>{{ $shop->name }}</h3>

        @forelse ($shop->services as $service)
            <div>
                <h4>{{ $service->name }}</h4>

                <p>Kategori: {{ $service->category->name }}</p>

                <p>Deskripsi: {{ $service->description }}</p>

                <p>Harga: Rp{{ number_format($service->price, 0, ',', '.') }}</p>

                <p>Satuan: {{ $service->unit }}</p>

                <p>Status: {{ $service->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>

                <a href="{{ route('merchant.services.edit', $service->id) }}">
                    Edit
                </a>

                <form method="POST"
                    action="{{ route('merchant.services.destroy', $service->id) }}"
                    onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit">Hapus</button>
                </form>
            </div>

            <hr>
        @empty
            <p>Belum ada layanan untuk toko ini.</p>
        @endforelse

    @empty
        <p>Belum ada toko yang terdaftar.</p>
    @endforelse

    <a href="{{ route('merchant.dashboard') }}">
        Kembali ke Dashboard
    </a>
</body>
</html>
