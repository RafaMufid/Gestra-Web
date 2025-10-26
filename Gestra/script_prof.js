function dashboard() {
  window.location.href = "index.html";
}

function edit() {
  const nama = document.getElementById("name");
  const username = document.getElementById("username");
  const password = document.getElementById("password");
  const btn = document.getElementById("editbtn");
  const btnLogout = document.getElementById("logoutbtn");

  if (btn.innerText == "Edit Profile") {
    nama.disabled = false;
    username.disabled = false;
    password.disabled = false;
    password.type = "text";

    nama.focus();
    username.focus();
    password.focus();

    btn.innerText = "Save";
    btn.style.backgroundColor = "#28a745";
    btn.style.color = "black";
    btnLogout.style.display = "none";
  } else {
    nama.disabled = true;
    username.disabled = true;
    password.disabled = true;
    password.type = "password";

    btn.innerText = "Edit Profile";
    btn.style.backgroundColor = "white";
    btnLogout.style.display = "block";

    alert("Profil berhasil disimpan!");
  }
}
