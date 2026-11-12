<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Printar</title>
</head>
<body>

    <h1>Selamat Datang di Printar!</h1>

    <p>Halo, {{ auth()->user()->name }}</p>
    <p>Role: {{ auth()->user()->role }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>

