function dashboard() {
    window.location.href = "index.html";
}

document.addEventListener("DOMContentLoaded", () => {
    
    const startButton = document.getElementById("startBtn");
    const stopButton = document.getElementById("stopBtn");
    const cameraPlaceholder = document.getElementById("cameraPlaceholder");
    const videoFeed = document.getElementById("videoFeed");
    const cameraFeed = document.getElementById("cameraFeed");
    const resultScreen = document.getElementById("resultScreen");
    
    let localStream = null;

    // btnStart function
    startButton.addEventListener("click", async () => {
        startButton.disabled = true;
        stopButton.disabled = false;

        try{
            localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            videoFeed.srcObject = localStream;
            videoFeed.style.display = "block";
            cameraPlaceholder.style.display = "none";
            resultScreen.innerHTML = '<p>Kamera aktif. Mulai deteksi...</p>';
        } catch (error) {
            console.error("Error accessing camera: ", error);
            resultScreen.innerHTML = '<p class="placeholder" style="color: red;">Gagal mengakses kamera. Silakan periksa izin kamera Anda.</p>';
            
            startButton.disabled = false;
            stopButton.disabled = true;
        }
    });

    // btnStop function
    stopButton.addEventListener("click", () => {
        if (localStream) {
            localStream.getTracks().forEach(track => {
                track.stop();
            });
        }
        videoFeed.srcObject = null;
        localStream = null;
        videoFeed.style.display = "none";
        cameraPlaceholder.style.display = "block";

        stopButton.disabled = true;
        startButton.disabled = false;
        resultScreen.innerHTML = '<p class="placeholder">Deteksi dihentikan.</p>'; 
    });
    stopButton.disabled = true;
});