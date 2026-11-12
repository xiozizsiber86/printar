<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan - Printar</title>
</head>
<body>
    <h1>PRINTAR - MERCHANT</h1>
    <h2>Tambah Layanan Percetakan</h2>

    @if ($errors->any())
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($shops->isEmpty())
        <p>Belum ada toko aktif. Layanan hanya bisa ditambahkan pada toko yang sudah aktif.</p>
        <a href="{{ route('merchant.shops.index') }}">Kembali ke Daftar Toko</a>
    @else
        <form method="POST" action="{{ route('merchant.services.store') }}">
            @csrf

            <div>
                <label>Pilih Toko</label><br>
                <select name="shop_id" required>
                    <option value="">-- Pilih Toko --</option>
                    @foreach ($shops as $shop)
                        <option value="{{ $shop->id }}"
                            {{ old('shop_id') == $shop->id ? 'selected' : '' }}>
                            {{ $shop->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>

            <div>
                <label>Kategori Layanan</label><br>
                <select name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>

            <div>
                <label>Nama Layanan</label><br>
                <input type="text" name="name"
                    value="{{ old('name') }}" required>
            </div>
            <br>

            <div>
                <label>Deskripsi</label><br>
                <textarea name="description">{{ old('description') }}</textarea>
            </div>
            <br>

            <div>
                <label>Harga (Rp)</label><br>
                <input type="number" name="price" min="0" step="0.01"
                    value="{{ old('price') }}" required>
            </div>
            <br>

            <div>
                <label>Satuan</label><br>
                <select name="unit" required>
                    <option value="">-- Pilih Satuan --</option>
                    @foreach (['lembar', 'meter', 'buah', 'paket', 'lusin', 'rim', 'set'] as $unit)
                        <option value="{{ $unit }}"
                            {{ old('unit') == $unit ? 'selected' : '' }}>
                            {{ ucfirst($unit) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>

            <button type="submit">Simpan Layanan</button>
        </form>
    @endif

    <br>
    <a href="{{ route('merchant.services.index') }}">Kembali ke Daftar Layanan</a>
</body>
</html>
