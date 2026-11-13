<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alamat - Printar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .button {
            display: inline-block;
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #64748b;
            color: white;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .hint {
            color: #64748b;
            font-size: 13px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Tambah Alamat</h1>
    <p>Masukkan informasi alamat penerima pesanan Anda.</p>

    <form action="{{ route('customer.addresses.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="label">Label Alamat</label>
            <input
                type="text"
                id="label"
                name="label"
                value="{{ old('label') }}"
                placeholder="Contoh: Rumah, Kantor"
                maxlength="50"
                required
            >
            @error('label')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="recipient_name">Nama Penerima</label>
            <input
                type="text"
                id="recipient_name"
                name="recipient_name"
                value="{{ old('recipient_name') }}"
                placeholder="Nama lengkap penerima"
                required
            >
            @error('recipient_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Contoh: 081234567890"
                maxlength="20"
                required
            >
            @error('phone')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Alamat Lengkap</label>
            <textarea
                id="address"
                name="address"
                placeholder="Nama jalan, nomor rumah, kelurahan, kecamatan, kota..."
                required
            >{{ old('address') }}</textarea>
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="latitude">Latitude (Opsional)</label>
            <input
                type="number"
                step="any"
                id="latitude"
                name="latitude"
                value="{{ old('latitude') }}"
                placeholder="Contoh: -8.5833"
            >
            @error('latitude')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="longitude">Longitude (Opsional)</label>
            <input
                type="number"
                step="any"
                id="longitude"
                name="longitude"
                value="{{ old('longitude') }}"
                placeholder="Contoh: 116.1167"
            >
            @error('longitude')
                <div class="error">{{ $message }}</div>
            @enderror
            <p class="hint">Koordinat dapat diisi nanti jika belum tersedia.</p>
        </div>

        <div class="actions">
            <button type="submit" class="button primary">
                Simpan Alamat
            </button>

            <a href="{{ route('customer.addresses.index') }}"
               class="button secondary">
                Batal
            </a>
        </div>
    </form>

</div>

</body>
</html>
