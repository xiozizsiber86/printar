<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Layanan - Printar</title>
</head>
<body>

    <h1>PRINTAR - MERCHANT</h1>
    <h2>Edit Layanan Percetakan</h2>

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

    <form method="POST" action="{{ route('merchant.services.update', $service->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Kategori Layanan</label><br>
            <select name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>

        <div>
            <label>Nama Layanan</label><br>
            <input type="text" name="name"
                value="{{ old('name', $service->name) }}" required>
        </div>
        <br>

        <div>
            <label>Deskripsi</label><br>
            <textarea name="description">{{ old('description', $service->description) }}</textarea>
        </div>
        <br>

        <div>
            <label>Harga (Rp)</label><br>
            <input type="number" name="price" min="0" step="0.01"
                value="{{ old('price', $service->price) }}" required>
        </div>
        <br>

        <div>
            <label>Satuan</label><br>
            <select name="unit" required>
                @foreach (['lembar', 'meter', 'buah', 'paket', 'lusin', 'rim', 'set'] as $unit)
                    <option value="{{ $unit }}"
                        {{ old('unit', $service->unit) == $unit ? 'selected' : '' }}>
                        {{ ucfirst($unit) }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <br>

    <a href="{{ route('merchant.services.index') }}">
        Kembali ke Daftar Layanan
    </a>

</body>
</html>
