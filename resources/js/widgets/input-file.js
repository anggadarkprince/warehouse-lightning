const inputFiles = document.querySelectorAll('.input-file');
inputFiles.forEach(inputFile => {
    inputFile.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const inputWrapper = inputFile.closest('.input-file-wrapper');
            if (inputWrapper) {
                const inputFileWrapper = inputWrapper.querySelector('.input-file-label');
                inputFileWrapper.value = this.files[0].name;
            }

            // set preview file (image)
            if (this.dataset.targetPreview) {
                const targetPreview = document.querySelector(this.dataset.targetPreview);
                if (targetPreview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        targetPreview.setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            }
        }
    });
})
