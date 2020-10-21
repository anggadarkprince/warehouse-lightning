// Open modal
window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal-toggle')) {
        event.preventDefault();
        const targetModal = event.target.dataset.modal;
        const currentModal = document.querySelector(targetModal);
        if (currentModal) {
            currentModal.style.display = "block";
            document.body.classList.add('overflow-hidden');
        }
    }
});

// When the user clicks anywhere outside of the modal, close it
window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
        document.body.classList.remove('overflow-hidden');
    }
});


// Dismiss modal from button
window.addEventListener('click', function (event) {
    if (event.target.classList.contains('dismiss-modal')) {
        const modal = event.target.closest('.modal');
        if (modal) {
            modal.style.display = "none";
            document.body.classList.remove('overflow-hidden');
        }
    }
});
