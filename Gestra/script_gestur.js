// Fungsi untuk kembali ke Home (diambil dari script_prof.js)
function dashboard() {
    window.location.href = "index.html";
}

// Menambahkan event listener setelah dokumen dimuat
document.addEventListener("DOMContentLoaded", () => {
    
    const startButton = document.getElementById("startBtn");
    const stopButton = document.getElementById("stopBtn");
    const cameraFeed = document.getElementById("cameraFeed");
    const resultScreen = document.getElementById("resultScreen");

    // Fungsi saat tombol "Mulai Deteksi" diklik
    startButton.addEventListener("click", () => {
        // 1. Ubah tampilan tombol
        startButton.disabled = true;
        stopButton.disabled = false;

        // 2. Ubah tampilan "Kamera Feed"
        cameraFeed.innerHTML = "<h3>Kamera Aktif</h3><p>Mendeteksi gerakan...</p>";
        cameraFeed.style.borderColor = "rgba(40, 167, 69, 1)"; // Ubah border jadi hijau

        // 3. Bersihkan hasil sebelumnya dan tampilkan status
        resultScreen.innerHTML = '<p class="placeholder">Mulai mendeteksi...</p>';
    });

    // Fungsi saat tombol "Hentikan" diklik
    stopButton.addEventListener("click", () => {
        // 1. Ubah tampilan tombol
        startButton.disabled = false;
        stopButton.disabled = true;

        // 2. Ubah tampilan "Kamera Feed"
        cameraFeed.innerHTML = "<h3>Kamera Tidak Aktif</h3><p>Tekan 'Mulai' untuk mengaktifkan kamera</p>";
        cameraFeed.style.borderColor = "#1E40AF"; // Kembalikan warna border

        // 3. Tampilkan status di layar hasil
        resultScreen.innerHTML = '<p class="placeholder">Deteksi dihentikan.</p>';
    });

    // Kondisi awal saat halaman dimuat
    stopButton.disabled = true;
});