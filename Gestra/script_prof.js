function dashboard() {
  window.location.href = "index.html";
}

function login() {
  window.location.href = "login.html";
}

function edit() {
  const nama = document.getElementById("name");
  const username = document.getElementById("username");
  const password = document.getElementById("password");
  const btn = document.getElementById("editbtn");
  const btnLogout = document.getElementById("logoutbtn");
  const overlay = document.getElementById("changePhotoOverlay");

  if (btn.innerText == "Edit Profile") {
    nama.disabled = false;
    username.disabled = false;
    password.disabled = false;
    password.type = "text";

    overlay.style.display = "flex";
    nama.focus();
    
    btn.innerText = "Save";
    btn.style.backgroundColor = "#28a745";
    btn.style.color = "black";
    btnLogout.style.display = "none";
  } else {
    nama.disabled = true;
    username.disabled = true;
    password.disabled = true;
    password.type = "password";
    
    overlay.style.display = "none";
    btn.innerText = "Edit Profile";
    btn.style.backgroundColor = "white";
    btn.style.color = "#14279B";
    btnLogout.style.display = "block";

    alert("Profil berhasil disimpan!");
  }
}
