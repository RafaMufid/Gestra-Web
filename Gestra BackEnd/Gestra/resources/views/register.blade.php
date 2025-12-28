<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up | Gestra</title>
    <link rel="stylesheet" href="{{ asset('css/style_login_regis.css') }}">
</head>
<body class="auth-body">

    <div class="auth-container">
        <div class="auth-logo">
            <img src="{{ asset('assets/gestra.png') }}" alt="Logo Gestra">
            <h2>Buat Akun Baru</h2>
        </div>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('register.post') }}">
            @csrf

            <label for="name">Nama</label>
            <input type="text" id="username" name="username" placeholder="Masukkan nama" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <button type="submit" class="btn-primary">Sign-Up</button>

            <p class="switch">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </form>
    </div>

</body>
</html>
