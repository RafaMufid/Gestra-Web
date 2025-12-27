<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Gestra</title>

  <link rel="stylesheet" href="{{ asset('css/style_login_regis.css') }}">
</head>
<body class="auth-body">

  <div class="auth-container">
    <div class="auth-logo">
      <img src="{{ asset('assets/gestra.png') }}" alt="Logo Gestra">
      <h2>Selamat Datang Kembali</h2>
      <p>Masuk ke akun Gestra kamu</p>
    </div>

    <form class="auth-form" method="POST" action="{{ route('login.process') }}">
      @csrf

      <label>Email</label>
      <input type="email" name="email" placeholder="Masukkan email" required>

      <label>Password</label>
      <div class="password-wrapper">
        <input
          type="password"
          name="password"
          id="password"
          placeholder="Masukkan password"
          required
        >
        <span class="toggle-password" onclick="togglePassword()">👁</span>
      </div>

      <div class="auth-extra">
        <a href="#">Lupa password?</a>
      </div>

      <button type="submit" class="btn-primary">Login</button>

      <p class="switch">
        Belum punya akun?
        <a href="{{ url('/register') }}">Sign-Up</a>
      </p>
    </form>
  </div>

  <script>
    function togglePassword() {
      const password = document.getElementById('password');
      password.type = password.type === 'password' ? 'text' : 'password';
    }
  </script>

</body>
</html>
