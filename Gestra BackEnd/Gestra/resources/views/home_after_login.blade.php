<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestra</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/Logo atas/favicon.ico') }}" type="image/x-icon">
</head>
<body>

<div class="nav">
    <div class="logo">
        <img src="{{ asset('assets/gestra.png') }}" alt="">
    </div>
    <div class="list">
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>
    <div class="akun">
        @php
            $user = session('user');
        @endphp
        <img class="avatar" src="{{ asset($user['profile_photo_path'] ?? 'assets/default.png') }}" alt="Profile">
    </div>
</div>

<div class="main">
    <div class="intro">
        <div class="intro-teks">
            <h1>Selamat Datang🖐️, di website Gestra</h1>
            <h3>
                Gestra adalah aplikasi berbasis mobile yang berfungsi menjadi <br>
                jembatan komunikasi untuk tunarungu dan tunawicara
            </h3>
        </div>
        <div class="intro-img">
            <img src="{{ asset('assets/Mascot.png') }}" height="500px" alt="Mascot">
        </div>
    </div>

    <div class="konten">
        <h1>Berikut adalah beberapa fitur yang tersedia :</h1>
        <div class="item">
            <div class="gesture">
                <img src="{{ asset('assets/Sibi.png') }}" alt="">
                <h2>
                    Gesture detection menggunakan bahasa isyarat SIBI <br>
                    <a href="#"><button>Coba</button></a>
                </h2>
            </div>

            <div class="tts">
                <img src="{{ asset('assets/STT.png') }}" alt="">
                <h2>
                    Speech to text untuk memudahkan komunikasi <br>
                    <a href="{{ route('stt') }}"><button>Coba</button></a>
                </h2>
            </div>

            <div class="forum">
                <img src="{{ asset('assets/Forum.png') }}" alt="">
                <h2>
                    Forum diskusi untuk mencari komunitas dan mendapat info pertemuan <br>
                    <a href="#"><button>Coba</button></a>
                </h2>
            </div>
        </div>
    </div>

    <div class="profil">
        <h1 style="justify-self: center; margin-top: 50px;">Meet Our Team😁</h1>

        <div id="image-track">
            <div class="card">
                <img class="image" src="{{ asset('assets/Member/Rafa.jpg') }}" draggable="false">
                <h2>Rafa Mufid ‘Aqila</h2>
                <h3>Motto:<br>"Apa adanya dan adanya apa"</h3>
            </div>

            <div class="card">
                <img class="image" src="{{ asset('assets/Member/bella.jpg') }}" draggable="false">
                <h2>Riyanda Wiesya Bella</h2>
                <h3>Motto:<br>"Hidup seperti larry~"</h3>
            </div>

            <div class="card">
                <img class="image" src="{{ asset('assets/Member/Aulya.jpg') }}" draggable="false">
                <h2>Shinta Alya Aulya Ningrum</h2>
                 <h3>Motto : <br> "Kalau gagal, coba lagi kalau gagal lagi, salahin zodiak"</h3>
            </div>

            <div class="card">
                <img class="image" src="{{ asset('assets/Member/Array.jpeg') }}" draggable="false">
                <h2>Muhammad Arrayan Fikri</h2>
                <h3>Motto:<br>"Rock and Stone!"</h3>
            </div>

            <div class="card">
                <img class="image" src="{{ asset('assets/Member/Yopi.jpg') }}" draggable="false">
                <h2>Yappier Albertus Febriandi Krisna Putra</h2>
                <h3>Motto:<br>"Selagi ada jalan, jalanin"</h3>
            </div>

            <div class="card">
                <img class="image" src="{{ asset('assets/Member/Alya.jpg') }}" draggable="false">
                <h2>Alya Rahmadayani Supriadi</h2>
            </div>
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
</html>
