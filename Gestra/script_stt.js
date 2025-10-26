const ttsBtn = document.getElementById("tts-btn");
const popup = document.getElementById("stt-popup");
const closePopup = document.getElementById("close-popup");
const startBtn = document.getElementById("start-btn");
const stopBtn = document.getElementById("stop-btn");
const output = document.getElementById("output");
const statusText = document.getElementById("stt-status");

ttsBtn.addEventListener("click", () => {
    popup.style.display = "flex";
});

closePopup.addEventListener("click", () => {
    popup.style.display = "none";
    if (recognition) recognition.stop();
    output.textContent = "";
    startBtn.disabled = false;
    stopBtn.disabled = true;
});
