function dashboard() {
    window.location.href = "index.html";
}

document.addEventListener("DOMContentLoaded", () => {
    
    const startButton = document.getElementById("startBtn");
    const stopButton = document.getElementById("stopBtn");
    const cameraFeed = document.getElementById("cameraFeed");
    const resultScreen = document.getElementById("resultScreen");
    
    // btnStart function
    startButton.addEventListener("click", () => {
        startButton.disabled = true;
        stopButton.disabled = false;

        cameraFeed.innerHTML = "<h3>Kamera Aktif</h3><p>Mendeteksi gerakan...</p>";
        cameraFeed.style.borderColor = "#28a745ff";

        resultScreen.innerHTML = '<p>contoh hasil translate disini</p>';
    });

    // btnStop function
    stopButton.addEventListener("click", () => {
        startButton.disabled = false;
        stopButton.disabled = true;

        cameraFeed.innerHTML = "<h3>Kamera Tidak Aktif</h3><p>Tekan 'Mulai' untuk mengaktifkan kamera</p>";
        cameraFeed.style.borderColor = "#1E40AF";

        resultScreen.innerHTML = '<p class="placeholder">Deteksi dihentikan.</p>';
    });
    stopButton.disabled = true;
});