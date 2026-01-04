<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestra - Deteksi Gerakan</title>
    <link rel="stylesheet" href="{{ asset('css/style-gestur.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-tflite/dist/tf-tflite.min.js"></script>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <img src="{{ asset('assets/gestra.png') }}" alt="Gestra Logo">
        </div>
        <div class="list_profile">
            <button onclick="window.location.href='{{ route('user.home') }}'">Home</button>
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
                    <video id="videoFeed" playsinline muted
                        style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                    </video>
                    <canvas id="detectionCanvas"
                        style="width: 100%; height: 100%; border-radius: 10px; display: none; background-color: #000;">
                    </canvas>
                </div>
                <div class="controls">
                    <button id="startBtn" class="btn_control start">Mulai Deteksi</button>
                    <button id="stopBtn" class="btn_control stop">Hentikan</button>
                </div>
            </div>

            <div class="result_display">
                <h2>Hasil Terjemahan: </h2>

                <div class="result_screen" id="resultScreen" style="min-height: 100px; display: flex; border: 1px solid #ccc; border-radius: 4px; padding: 10px;">
                    <p class="placeholder" id="textResult" style="font-size: 2rem; word-wrap: break-word; width: 100%;">...</p>
                </div>

                <p id="confidenceScore" style="text-align: center; color: green; margin-top: 5px;">-</p>

                <div style="display: flex; gap: 10px; justify-content: center; margin-top: 15px;">
                    <button id="spaceBtn" class="btn btn-spasi">Spasi</button>
                    <button id="delBtn" class="btn btn-hapus">Hapus</button>
                    <button id="clearBtn" class="btn btn-reset">Reset</button>
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