<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | Gestra</title>
  <link rel="stylesheet" href="{{ asset('css/style_login_regis.css') }}">
</head>
<body class="auth-body">

<div class="auth-container">
  <div class="auth-logo">
    <img src="{{ asset('assets/gestra.png') }}">
    <h2>Selamat Datang Kembali</h2>
    <p>Masuk ke akun Gestra kamu</p>
  </div>

  <form method="POST" action="{{ route('login.process') }}" class="auth-form">
    @csrf

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Masukkan email" required>

    <label for="password">Password</label>
    <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        <span class="toggle-password" onclick="togglePassword()"></span>
    </div>

    <button type="submit" class="btn-primary">Login</button>

    <p class="switch">Belum punya akun? <a href="{{ route('register') }}">Sign-Up</a></p>
</form>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>


</body>
</html>
