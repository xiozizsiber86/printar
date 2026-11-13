<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Saya - Printar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
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

        .danger {
            background: #dc2626;
            color: white;
        }

        .success {
            background: #16a34a;
            color: white;
        }

        .address-card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }

        .address-card h3 {
            margin-top: 0;
        }

        .badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .actions form {
            margin: 0;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Alamat Saya</h1>
            <p>Kelola alamat pengiriman pesanan percetakan Anda.</p>
        </div>

        <a href="{{ route('customer.addresses.create') }}" class="button primary">
            + Tambah Alamat
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @forelse ($addresses as $address)
        <div class="address-card">

            <h3>
                {{ $address->label }}

                @if ($address->is_default)
                    <span class="badge">Alamat Utama</span>
                @endif
            </h3>

            <p><strong>Penerima:</strong> {{ $address->recipient_name }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $address->phone }}</p>
            <p><strong>Alamat:</strong> {{ $address->address }}</p>

            @if ($address->latitude && $address->longitude)
                <p>
                    <strong>Koordinat:</strong>
                    {{ $address->latitude }}, {{ $address->longitude }}
                </p>
            @endif

            <div class="actions">

                <a href="{{ route('customer.addresses.edit', $address->id) }}"
                   class="button secondary">
                    Edit
                </a>

                @unless ($address->is_default)
                    <form action="{{ route('customer.addresses.default', $address->id) }}"
                          method="POST">
                        @csrf
                        <button type="submit" class="button success">
                            Jadikan Alamat Utama
                        </button>
                    </form>
                @endunless

                <form action="{{ route('customer.addresses.destroy', $address->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus alamat ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="button danger">
                        Hapus
                    </button>
                </form>

            </div>
        </div>
    @empty
        <div class="empty">
            <h3>Belum Ada Alamat</h3>
            <p>Silakan tambahkan alamat terlebih dahulu.</p>

            <a href="{{ route('customer.addresses.create') }}"
               class="button primary">
                Tambah Alamat
            </a>
        </div>
    @endforelse

    {{ $addresses->links() }}

    <p>
        <a href="{{ route('customer.dashboard') }}">Kembali ke Dashboard</a>
    </p>

</div>

</body>
</html>
