<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Printar Admin</title>
</head>
<body>

    <h1>PRINTAR - ADMIN</h1>
    <h2>Edit Kategori Layanan</h2>

    <p>
        <a href="{{ route('admin.categories.index') }}">Kembali ke Daftar Kategori</a>
    </p>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Kategori</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                maxlength="100"
                required
            >
        </div>

        <br>

        <div>
            <label for="description">Deskripsi</label><br>
            <textarea
                id="description"
                name="description"
                rows="4"
                cols="40"
            >{{ old('description', $category->description) }}</textarea>
        </div>

        <br>

        <div>
            <label>
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                >
                Aktifkan kategori
            </label>
        </div>

        <br>

        <button type="submit">Simpan Perubahan</button>
    </form>

</body>
</html>
