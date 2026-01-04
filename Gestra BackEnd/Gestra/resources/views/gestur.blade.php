<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestra - Deteksi Gerakan</title>
    <link rel="stylesheet" href="{{ asset('css/style-gestur.css') }}">
</head>

<body>
    <div class="nav">
        <div class="logo">
            <img src="{{ asset('assets/gestra.png') }}" alt="Gestra Logo">
        </div>
        <div class="list_profile">
            <button onclick="window.location.href='{{ url('/') }}'">Home</button>
        </div>
    </div>

    <div class="container">
        <h1 class="gestur_title">Deteksi Gerakan Tangan (SIBI)</h1>

        <div class="gestur_container">
            <div class="video_wrapper">
                <div class="camera_feed" id="cameraFeed">
                    <div id="cameraPlaceholder">
                        <h3>Camera Tidak Aktif</h3>
                        <p>Tekan "Mulai Deteksi" untuk mengaktifkan kamera</p>
                    </div>
                    <video id="videoFeed" playsinline autoplay muted
                        style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                    </video>
                </div>
                <div class="controls">
                    <button id="startBtn" class="btn_control start">Mulai Deteksi</button>
                    <button id="stopBtn" class="btn_control stop">Hentikan</button>
                </div>
            </div>

            <div class="result_display">
                <h2>Hasil Terjemahan: </h2>
                <div class="result_screen" id="resultScreen">
                    <p class="placeholder">Hasil terjemahan akan muncul disini...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="kontak">
        <div class="footer_content">
            <p>© {{ date('Y') }} Gestra. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script_gestur.js') }}"></script>
</body>

</html>