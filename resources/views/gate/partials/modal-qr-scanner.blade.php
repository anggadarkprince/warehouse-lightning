<div id="modal-qr-scanner" class="modal">
    <div class="modal-content">
        <div class="border-b border-gray-200 pb-3">
            <span class="close dismiss-modal">&times;</span>
            <h3 class="text-xl">QR Scanner</h3>
        </div>
        <div class="text-center pt10" id="camera-wrapper">
            <div id="camera-message" class="border rounded my-6 py-8 px-4">
                <h1 class="mdi mdi-video-off-outline text-2xl"></h1>
                <p class="small mb-2">No cameras or insufficient permission.</p>
                <button class="button-light button-sm mb-2" id="btn-try-again">Refresh the Page</button>
            </div>
            <canvas id="camera-preview" class="mt-3 rounded" style="display:none; width: auto; height: auto"></canvas>
        </div>
    </div>
</div>
