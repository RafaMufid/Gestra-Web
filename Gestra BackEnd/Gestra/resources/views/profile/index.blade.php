<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Gestra</title>

    <link rel="stylesheet" href="{{ asset('css/style_prof.css') }}">
    <link rel="icon" href="{{ asset('assets/Logo atas/favicon.ico') }}" type="image/x-icon">
</head>
<body>

<div class="nav">
    <div class="logo">
        <a href="{{ route('user.home') }}">
            <img src="{{ asset('assets/gestra.png') }}" alt="Gestra">
        </a>
    </div>

    <div class="list_profile">
        <a href="{{ route('user.home') }}">
            <button>Home</button>
        </a>
    </div>
</div>

<div class="main">
    <div class="profile_section">

        <div class="profile_title">Profile</div>

        <div class="profile_img">
    <img id="profilePreview" src="{{ $photoUrl }}" alt="Profile Photo">

    <div class="overlay hidden" id="photoOverlay">
        Ubah Foto Profil
    </div>

    <input 
        type="file" 
        id="photoInput" 
        accept="image/*" 
        hidden
    >
</div>


        <form class="profile_info" id="profileForm">
    @csrf

    <label>Username</label>
    <input type="text" name="username" value="{{ $user['username'] }}" disabled>

    <label>Email</label>
    <input type="text" name="email" value="{{ $user['email'] }}" disabled>

    <div class="password_field hidden">
        <label>Password</label>
        <input type="text" name="password" placeholder="Masukkan password baru">
    </div>
</form>


        <div class="profile_actions">
    <button type="button" class="btnedit" id="editBtn">Edit Profile</button>

    <button type="button" class="btnedit hidden" id="saveBtn">
        Save
    </button>

    <a href="{{ route('logout') }}">
        <button type="button" class="btnlogout" id="logoutBtn">Logout</button>
    </a>
</div>

    </div>
</div>


<div class="kontak">
    <div class="footer-content">
        <p>© 2025 Gestra. All rights reserved.</p>
        <div class="social-links">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>
    </div>
</div>

</body>

<script>
const editBtn = document.getElementById('editBtn');
const saveBtn = document.getElementById('saveBtn');
const logoutBtn = document.getElementById('logoutBtn');

const inputs = document.querySelectorAll('.profile_info input');
const passwordField = document.querySelector('.password_field');

const overlay = document.getElementById('photoOverlay');
const photoInput = document.getElementById('photoInput');
const photoPreview = document.getElementById('profilePreview');

const form = document.getElementById('profileForm');

let isEdit = false;
let photoChanged = false;

editBtn.addEventListener('click', () => {
    isEdit = true;

    inputs.forEach(input => {
        if (input.name !== 'password') {
            input.disabled = false;
        }
    });

    passwordField.classList.remove('hidden');
    overlay.classList.remove('hidden');

    editBtn.classList.add('hidden');
    saveBtn.classList.remove('hidden');
    logoutBtn.classList.add('hidden');
});

saveBtn.addEventListener('click', async () => {
    inputs.forEach(input => input.disabled = false);
    const formData = new FormData(form);

    if (!formData.get('password')) {
        formData.delete('password');
    }

    if (photoChanged) {
        formData.append('photo', photoInput.files[0]);
    }

    try {
        const response = await fetch("{{ route('profile.update') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: formData
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Update gagal');
        }

        if (photoChanged) {
            const baseUrl = "{{ rtrim(config('filesystems.disks.azure.url'), '/') }}";
            photoPreview.src = baseUrl + '/' + result.user.profile_photo_path;
        }

        isEdit = false;
        inputs.forEach(input => input.disabled = true);
        passwordField.classList.add('hidden');
        overlay.classList.add('hidden');
        saveBtn.classList.add('hidden');
        editBtn.classList.remove('hidden');
        logoutBtn.classList.remove('hidden');
        photoChanged = false;

        alert('Profile berhasil diperbarui');
    } catch (err) {
        alert(err.message);
    }
});


overlay.addEventListener('click', () => {
    if (!isEdit) return;
    photoInput.click();
});

photoInput.addEventListener('change', () => {
    const file = photoInput.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar');
        return;
    }

    const reader = new FileReader();
    reader.onload = e => photoPreview.src = e.target.result;
    reader.readAsDataURL(file);

    photoChanged = true;
});
</script>


</html>
