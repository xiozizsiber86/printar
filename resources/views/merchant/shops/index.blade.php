<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Toko - Printar</title>
</head>
<body>

    <h1>PRINTAR - MERCHANT</h1>

    <h2>Daftar Toko Saya</h2>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <hr>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('merchant.shops.create') }}">
        + Tambah Toko
    </a>

    <hr>

    <h3>Toko Saya</h3>

    @forelse ($shops as $shop)
        <div>
            <h4>{{ $shop->name }}</h4>

            <p>{{ $shop->description }}</p>
            <p>Alamat: {{ $shop->address }}</p>
            <p>Telepon: {{ $shop->phone }}</p>

            <p>
                Status:
                {{ $shop->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </p>
            <a href="{{ route('merchant.shops.edit', $shop->id) }}">
    Edit Toko
</a>
           <form method="POST"
    action="{{ route('merchant.shops.destroy', $shop->id) }}"
    onsubmit="return confirm('Yakin ingin menghapus toko ini?')">

    @csrf
    @method('DELETE')

    <button type="submit">Hapus Toko</button>
</form>
        </div>

        <hr>
    @empty
        <p>Belum ada toko yang terdaftar.</p>
    @endforelse

    <a href="{{ route('merchant.dashboard') }}">Kembali ke Dashboard</a>

</body>
</html>
