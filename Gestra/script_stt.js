document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("stt-popup");
    const closePopup = document.getElementById("close-popup");
    const startBtn = document.getElementById("start-btn");
    const stopBtn = document.getElementById("stop-btn");
    const output = document.getElementById("output");
    const statusText = document.getElementById("stt-status");

    closePopup.addEventListener("click", () => {
        popup.style.display = "none";
        output.textContent = "";
        startBtn.disabled = false;
        stopBtn.disabled = true;
        window.location.href = "index.html";
    });
});
