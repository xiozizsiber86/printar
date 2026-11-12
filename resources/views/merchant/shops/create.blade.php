<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Toko - Printar</title>
</head>
<body>

    <h1>PRINTAR - MERCHANT</h1>

    <h2>Tambah Toko Percetakan</h2>

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

    <form method="POST" action="{{ route('merchant.shops.store') }}">
        @csrf

        <div>
            <label>Nama Toko</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <br>

        <div>
            <label>Deskripsi Toko</label><br>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <br>

        <div>
            <label>Alamat Toko</label><br>
            <textarea name="address" required>{{ old('address') }}</textarea>
        </div>

        <br>

        <div>
            <label>Nomor Telepon</label><br>
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </div>

        <br>

        <div>
            <label>Latitude (opsional)</label><br>
            <input type="number" step="any" name="latitude" value="{{ old('latitude') }}">
        </div>

        <br>

        <div>
            <label>Longitude (opsional)</label><br>
            <input type="number" step="any" name="longitude" value="{{ old('longitude') }}">
        </div>

        <br>

        <button type="submit">Simpan Toko</button>
    </form>

    <br>

    <a href="{{ route('merchant.shops.index') }}">Kembali ke Daftar Toko</a>

</body>
</html>
