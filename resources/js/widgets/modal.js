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
    if (event.target.classList.contains('modal') && event.target.classList.contains('dismiss-outside')) {
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
            if (modal.onClosed) {
                modal.onClosed()
            }
        }
    }
});

window.initModal = function(modal) {
    modal.open = function() {
        modal.style.display = "block";
        document.body.classList.add('overflow-hidden');
    };

    modal.close = function() {
        modal.style.display = "none";
        document.body.classList.remove('overflow-hidden');
    };

    return modal;
};

window.initModalInfo = function(modal, modalMessage = '', modalSubMessage = '', modalTitle = 'Info') {
    initModal(modal);

    modal.open = function(message = modalMessage, subMessage = modalSubMessage, title = modalTitle) {
        modal.querySelector('.modal-info-title').innerHTML = title;
        modal.querySelector('.modal-info-message').innerHTML = message;
        modal.querySelector('.modal-info-sub-message').innerHTML = subMessage;

        modal.style.display = "block";
        document.body.classList.add('overflow-hidden');
    };

    return modal;
};
