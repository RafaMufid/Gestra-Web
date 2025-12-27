// Login 
document.getElementById("loginForm")?.addEventListener("submit", function (e) {
  e.preventDefault();
  alert("Login berhasil!");
  window.location.href = "index.html";
});

// Register
document.getElementById("registerForm")?.addEventListener("submit", function (e) {
  e.preventDefault();
  alert("Akun berhasil dibuat!");
  window.location.href = "login.html";
});
