<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to text</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style_stt.css')); ?>">
    <link rel="icon" href="<?php echo e(asset('assets/Logo atas/favicon.ico')); ?>" type="image/x-icon">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <img src="<?php echo e(asset('assets/gestra.png')); ?>" alt="">
        </div>
        <div class="list">
            <ul>
                <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div> 
    <div class="main">
        <div id="stt-popup" class="popup" style="display: flex;">
            <div class="popup-content">
                <h2>Speech to Text</h2>
                <p id="stt-status">Tekan tombol di bawah dan mulai bicara</p>

                <div class="stt-controls">
                    <button id="start-btn">Start</button>
                    <button id="stop-btn" disabled>Stop</button>
                </div>

                <div class="result-box">
                    <p id="output">Hasil konversi suara</p>
                </div>
                                
                <button id="close-popup" >Tutup</button>
            </div>
        </div>
    </div>       
    <script> const HOME_URL = "<?php echo e(url('/')); ?>"; </script>
    <script src="<?php echo e(asset('js/script_stt.js')); ?>"></script>
</body>
</html><?php /**PATH D:\Kuliah\Semester 5\Perancangan dan Pemrograman WEB\Tubes_GestraWEB\Gestra-Web\Gestra BackEnd\Gestra\resources\views/speech-to-text.blade.php ENDPATH**/ ?>