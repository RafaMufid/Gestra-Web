document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("stt-popup");
    const closePopup = document.getElementById("close-popup");
    const startBtn = document.getElementById("start-btn");
    const stopBtn = document.getElementById("stop-btn");
    const output = document.getElementById("output");
    const statusText = document.getElementById("stt-status");

    window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
 
    if (!window.SpeechRecognition) {
        alert("Browser tidak mendukung Speech to Text");
        return;
    }
 
    const recognition = new SpeechRecognition();
    recognition.lang = "id-ID";
    recognition.interimResults = true;
    recognition.continuous = true;
    let finalTranscript = "";

    startBtn.addEventListener("click", () => {
        recognition.start();
        statusText.textContent = "🎙️ Mendengarkan";
        startBtn.disabled = true;
        stopBtn.disabled = false;
    });

    stopBtn.addEventListener("click", () => {
        recognition.stop();
        statusText.textContent = "⏹️ Dihentikan";
        startBtn.disabled = false;
        stopBtn.disabled = true;
    });

    recognition.onresult = (event) => {
        let interimTranscript = "";

    for (let i = event.resultIndex; i < event.results.length; i++) {
        const text = event.results[i][0].transcript;

        if (event.results[i].isFinal) {
            finalTranscript += text + " "; 
        } else {
            interimTranscript += text;
        }
    }

    output.textContent = finalTranscript + interimTranscript;
    };

    closePopup.addEventListener("click", () => {
        recognition.stop();
        finalTranscript = "";
        startBtn.disabled = false;
        stopBtn.disabled = true;
        window.location.href = HOME_URL;
    });
});
