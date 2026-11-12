<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Toko Percetakan - Printar</title>
</head>
<body>

    <h1>PRINTAR</h1>
    <h2>Cari Toko Percetakan Terdekat</h2>

    <p>Temukan toko percetakan berdasarkan lokasi GPS Anda.</p>

    <p>
        <a href="{{ route('customer.dashboard') }}">Kembali ke Dashboard</a>
    </p>

    <hr>

    <h3>Lokasi Anda</h3>

    <p id="location-status">
        Anda belum menggunakan lokasi GPS.
    </p>

    <button type="button" id="gps-button">
        Gunakan Lokasi Saya
    </button>

    <form
        id="gps-form"
        action="{{ route('customer.shops.index') }}"
        method="GET"
        style="display: none;"
    >
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
    </form>

    @if($hasLocation)
        <p>Menampilkan toko berdasarkan jarak terdekat dari lokasi Anda.</p>
    @endif

    <hr>

    <h3>Cari Berdasarkan Nama atau Alamat</h3>

    <form action="{{ route('customer.shops.index') }}" method="GET">

        @if($hasLocation)
            <input type="hidden" name="latitude" value="{{ request('latitude') }}">
            <input type="hidden" name="longitude" value="{{ request('longitude') }}">
        @endif

        <input
            type="text"
            name="search"
            placeholder="Cari nama atau alamat toko..."
            value="{{ request('search') }}"
        >

        <button type="submit">Cari Toko</button>

        <a href="{{ route('customer.shops.index') }}">Reset</a>
    </form>

    <hr>

    <h3>Daftar Toko Percetakan</h3>

    @forelse($shops as $shop)

        <div>
            <h3>{{ $shop->name }}</h3>

            <p>{{ $shop->description ?: 'Belum ada deskripsi toko.' }}</p>

            <p>Alamat: {{ $shop->address }}</p>

            <p>Telepon: {{ $shop->phone ?: '-' }}</p>

            <p>Jumlah layanan tersedia: {{ $shop->services->count() }}</p>

            @if($hasLocation && isset($shop->distance_km))
                <p>
                    <strong>
                        Jarak:
                        {{ number_format($shop->distance_km, 2, ',', '.') }}
                        km
                    </strong>
                </p>
            @endif

            <a href="{{ route('customer.shops.show', $shop->id) }}">
                Lihat Toko dan Harga Layanan
            </a>
        </div>

        <hr>

    @empty
        <p>Belum ada toko percetakan yang ditemukan.</p>
    @endforelse

    {{ $shops->links() }}

    <script>
        document.getElementById('gps-button').addEventListener('click', function () {
            const status = document.getElementById('location-status');
            const button = this;

            if (!window.isSecureContext) {
                status.textContent = 'Halaman belum menggunakan koneksi HTTPS yang aman.';
                return;
            }

            if (!navigator.geolocation) {
                status.textContent = 'Browser tidak mendukung fitur lokasi.';
                return;
            }

            button.disabled = true;
            status.textContent = 'Sedang mencari lokasi Anda. Mohon tunggu hingga 60 detik...';

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    status.textContent =
                        'Lokasi ditemukan: ' + latitude + ', ' + longitude +
                        '. Sedang mencari toko terdekat...';

                    document.getElementById('gps-form').submit();
                },
                function (error) {
                    button.disabled = false;

                    if (error.code === 1) {
                        status.textContent =
                            'Akses lokasi ditolak. Periksa izin lokasi Samsung Internet.';
                    } else if (error.code === 2) {
                        status.textContent =
                            'Posisi tidak tersedia. Aktifkan akurasi lokasi Google, Wi-Fi, dan data seluler.';
                    } else if (error.code === 3) {
                        status.textContent =
                            'GPS membutuhkan waktu lebih lama dari 60 detik. Coba lagi di tempat terbuka.';
                    } else {
                        status.textContent =
                            'Kesalahan lokasi: ' + error.message;
                    }
                },
                {
                    enableHighAccuracy: false,
                    timeout: 60000,
                    maximumAge: 60000
                }
            );
        });
    </script>

</body>
</html>
