import jsQR from "jsqr";

export default function () {

    const modalScanner = initModal(document.getElementById('modal-qr-scanner'));
    const btnTryScannerAgain = modalScanner.querySelector('#btn-try-again');
    const btnOpenScanner = document.getElementById('btn-scanner');
    const inputResultScanner = document.querySelector(btnOpenScanner.dataset.targetScanner);
    const formScanner = inputResultScanner.closest('form');
    const scannerMessage = modalScanner.querySelector('#camera-message');

    const video = document.createElement("video");
    const cameraPreview = modalScanner.querySelector('#camera-preview');
    const cameraWrapper = modalScanner.querySelector('#camera-wrapper');
    const canvas = cameraPreview.getContext("2d");

    btnTryScannerAgain.addEventListener('click', function () {
        location.reload();
    });

    btnOpenScanner.addEventListener('click', function (e) {
        e.preventDefault();
        if (inputResultScanner.value) {
            inputResultScanner.value = '';
        }
        modalScanner.open();
        initializeMedia();
    });

    modalScanner.onClosed = function() {
        if (video.srcObject) {
            video.srcObject.getVideoTracks().forEach(function (track) {
                track.stop();
            });
        }
    }

    function initializeMedia() {
        if (!('mediaDevices' in navigator)) {
            navigator.mediaDevices = {};
        }
        if (!('getUserMedia' in navigator.mediaDevices)) {
            navigator.mediaDevices.getUserMedia = function (constraints) {
                let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
                if (!getUserMedia) {
                    return Promise.reject(new Error('getUserMedia is not implemented!'));
                }
                return new Promise(function (resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }

        navigator.mediaDevices.getUserMedia({video: {facingMode: "environment"}})
            .then(function (stream) {
                scannerMessage.style.display = 'none';
                cameraPreview.style.display = 'block';

                video.srcObject = stream;
                video.setAttribute("playsinline", true);
                video.play();
                requestAnimationFrame(tick);
            })
            .catch(function () {
                cameraPreview.style.display = 'none';
                scannerMessage.style.display = 'block';
            });
    }

    function drawMarkerLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 4;
        canvas.strokeStyle = color;
        canvas.stroke();
    }

    function tick() {
        scannerMessage.hidden = false;
        scannerMessage.innerText = "⌛ Loading camera...";

        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            scannerMessage.hidden = true;
            cameraPreview.hidden = false;

            const videoHeight = video.videoHeight;
            const videoWidth = video.videoWidth;
            const wrapperWidth = cameraWrapper.offsetWidth;

            cameraPreview.height = videoHeight * wrapperWidth / videoWidth;
            cameraPreview.width = wrapperWidth;

            canvas.drawImage(video, 0, 0, cameraPreview.width || 1, cameraPreview.height || 1);
            const imageData = canvas.getImageData(0, 0, cameraPreview.width || 1, cameraPreview.height || 1);
            const code = jsQR(imageData.data, imageData.width, imageData.height);
            if (code) {
                video.pause();
                drawMarkerLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                drawMarkerLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                drawMarkerLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                drawMarkerLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                if (code.data.trim()) {
                    inputResultScanner.value = code.data;
                    formScanner.submit();
                    setTimeout(function () {
                        modalScanner.close();
                    }, 300);
                }
            }
        }
        requestAnimationFrame(tick);
    }
};
