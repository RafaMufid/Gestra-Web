const video = document.getElementById('videoFeed');
const canvas = document.getElementById('detectionCanvas');
const ctx = canvas.getContext('2d');

// UI Elements
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');
const placeholder = document.getElementById('cameraPlaceholder');
const textResult = document.getElementById('textResult'); // INI SEKARANG JADI KALIMAT
const confidenceScore = document.getElementById('confidenceScore');

// Tombol Kontrol
const spaceBtn = document.getElementById('spaceBtn');
const delBtn = document.getElementById('delBtn');
const clearBtn = document.getElementById('clearBtn');

let tfliteModel;
let isDetecting = false;
let isInferencing = false;
let renderId;

// Variabel Logika
let currentSentence = "";     
let detectedChar = "-";       
let stableChar = "";          
let startTime = 0;            
const HOLD_DURATION = 2000;   
let lastScore = 0;

// Label
const classNames = [
    "A", "B", "C", "D", "E", "F", "G", "H", "I", 
    "K", "L", "M", "N", "O", "P", "Q", "R", "S", 
    "T", "U", "V", "W", "X", "Y"
];

// --- 1. SETUP KONTROL KALIMAT ---
// Update tampilan kalimat
function renderSentence() {
    // Tampilkan kalimat + kursor berkedip '|'
    textResult.innerText = currentSentence + (isDetecting ? "|" : "");
    
    // Ubah warna jadi hitam (normal)
    textResult.style.color = "#333";
    textResult.classList.remove('placeholder');
}

spaceBtn.addEventListener('click', () => {
    currentSentence += " ";
    renderSentence();
});

delBtn.addEventListener('click', () => {
    currentSentence = currentSentence.slice(0, -1);
    renderSentence();
});

clearBtn.addEventListener('click', () => {
    currentSentence = "";
    renderSentence();
});

// --- 2. LOAD MODEL ---
startBtn.disabled = true;
async function loadModel() {
    try {
        textResult.innerText = "Memuat AI...";
        tfliteModel = await tflite.loadTFLiteModel('/models/model_sibi.tflite');
        console.log("Model Loaded!");
        textResult.innerText = "Siap. Tekan Mulai.";
        startBtn.disabled = false;
    } catch (error) {
        console.error(error);
        textResult.innerText = "Error Memuat Model";
    }
}
loadModel();

// --- 3. START/STOP ---
startBtn.addEventListener('click', async () => {
    try {
        startBtn.disabled = true;
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'user', width: 640, height: 480 },
            audio: false
        });

        video.srcObject = stream;
        video.onloadeddata = () => {
            video.play();
            placeholder.style.display = 'none';
            canvas.style.display = 'block';
            
            startBtn.innerText = "Mulai Deteksi";
            startBtn.disabled = true;
            stopBtn.disabled = false;
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            isDetecting = true;
            renderSentence(); // Tampilkan kursor
            renderLoop();
            inferenceLoop();
        };
    } catch (err) {
        alert("Gagal akses kamera.");
        startBtn.disabled = false;
    }
});

stopBtn.addEventListener('click', () => {
    isDetecting = false;
    cancelAnimationFrame(renderId);
    if (video.srcObject) video.srcObject.getTracks().forEach(t => t.stop());
    video.srcObject = null;
    
    canvas.style.display = 'none';
    placeholder.style.display = 'flex';
    startBtn.disabled = false;
    stopBtn.disabled = true;
    
    textResult.innerText = currentSentence; // Hilangkan kursor saat stop
    confidenceScore.innerText = "-";
});

// --- 4. RENDER LOOP ---
function renderLoop() {
    if (!isDetecting) return;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    drawOverlay(); // Gambar kotak hijau di video
    renderId = requestAnimationFrame(renderLoop);
}

// --- 5. INFERENCE LOOP ---
async function inferenceLoop() {
    if (!isDetecting) return;
    if (isInferencing) { setTimeout(inferenceLoop, 100); return; }

    isInferencing = true;
    if (tfliteModel) await runInference();
    isInferencing = false;
    
    if (isDetecting) requestAnimationFrame(inferenceLoop);
}

// --- 6. LOGIKA AI ---
async function runInference() {
    const inputTensor = tf.tidy(() => {
        const raw = tf.browser.fromPixels(video);
        const resized = tf.image.resizeNearestNeighbor(raw, [224, 224]);
        const casted = tf.cast(resized, 'float32');
        return casted.div(tf.scalar(255.0)).expandDims();
    });

    try {
        let outputTensor = tfliteModel.predict(inputTensor);
        const outputData = await outputTensor.data();
        
        let maxScore = 0;
        let maxIndex = -1;
        for (let i = 0; i < outputData.length; i++) {
            if (outputData[i] > maxScore) {
                maxScore = outputData[i];
                maxIndex = i;
            }
        }

        lastScore = maxScore;

        if (maxScore > 0.4) { 
            const char = classNames[maxIndex];
            detectedChar = char;

            // Logika Timer
            if (char === stableChar) {
                const timePassed = Date.now() - startTime;
                if (timePassed > HOLD_DURATION) {
                    // --- BERHASIL TERKUNCI ---
                    currentSentence += char; // Tambah ke kalimat utama
                    renderSentence();        // Update layar utama
                    
                    // Efek Reset
                    startTime = Date.now(); 
                    stableChar = ""; 
                    
                    // Opsional: Getar jika di HP
                    if (navigator.vibrate) navigator.vibrate(200);
                }
            } else {
                stableChar = char;
                startTime = Date.now();
            }
        } else {
            detectedChar = "?";
            stableChar = ""; 
        }
        
    } catch (e) {
        console.error(e);
    } finally {
        inputTensor.dispose();
    }
}

// --- 7. OVERLAY VIDEO (PREVIEW) ---
function drawOverlay() {
    // 1. Tampilkan Akurasi Real-time
    if (lastScore > 0.4 && detectedChar !== "?") {
        confidenceScore.innerText = `Terdeteksi: ${detectedChar} (${(lastScore * 100).toFixed(0)}%)`;

        // Kotak Background
        ctx.fillStyle = "rgba(0, 0, 0, 0.5)";
        ctx.fillRect(10, 10, 220, 120);

        // Huruf Preview (Besar di Video)
        ctx.fillStyle = "#00FF00";
        ctx.font = "bold 60px Arial";
        ctx.fillText(detectedChar, 30, 80);

        // Progress Bar
        if (stableChar === detectedChar) {
            const timePassed = Date.now() - startTime;
            const progress = Math.min(timePassed / HOLD_DURATION, 1);
            
            // Bar Background
            ctx.fillStyle = "#fff";
            ctx.fillRect(20, 95, 200, 10);
            
            // Bar Isi (Loading)
            ctx.fillStyle = "#00FF00";
            ctx.fillRect(20, 95, 200 * progress, 10);
            
            // Teks Info
            ctx.fillStyle = "#fff";
            ctx.font = "16px Arial";
            ctx.fillText("Tahan posisi...", 20, 125);
        }

    } else {
        confidenceScore.innerText = "Mencari tangan...";
    }
}