const confirmSubmissions = document.querySelectorAll(".confirm-submission");
if (confirmSubmissions) {
    confirmSubmissions.forEach(confirmButton => {
        confirmButton.addEventListener("click", function (event) {
            event.preventDefault();
            const confirmModal = document.querySelector('#modal-confirm');
            if (confirmModal) {
                confirmModal.style.display = "block";
                document.body.classList.add('overflow-hidden');

                const label = this.dataset.label || 'Data';
                const action = this.dataset.action || 'Proceed';
                const href = this.dataset.href || this.getAttribute('href') || '#';
                const buttonYes = confirmModal.querySelector('.btn-yes');

                confirmModal.querySelector('.modal-confirm-message').innerHTML = action;
                confirmModal.querySelector('.modal-confirm-label').innerHTML = label;
                confirmModal.querySelector('.modal-confirm-title').innerHTML = `Confirm ${action}`;
                confirmModal.querySelector('form').action = href;
                if (href) {
                    buttonYes.setAttribute('type', 'submit');
                    buttonYes.classList.remove('dismiss-modal');
                    buttonYes.innerHTML = action.charAt(0).toUpperCase() + action.slice(1);
                } else {
                    buttonYes.setAttribute('type', 'button');
                    buttonYes.classList.add('dismiss-modal');
                }
            }
        });
    });
}
