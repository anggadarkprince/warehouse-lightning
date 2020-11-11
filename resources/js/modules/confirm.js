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
                const actionRefuse = this.dataset.actionRefuse || 'No';
                const submitRefuse = this.dataset.actionRefuse || 0;
                const inputMessage = this.dataset.inputMessage || 0;
                const subMessage = this.dataset.subMessage || '';
                const href = this.dataset.href || this.getAttribute('href') || '#';
                const buttonYes = confirmModal.querySelector('.btn-yes');
                const buttonNo = confirmModal.querySelector('.btn-no');
                const textAreaMessage = confirmModal.querySelector('#confirm-message');

                confirmModal.querySelector('.modal-confirm-message').innerHTML = action.toLowerCase();
                confirmModal.querySelector('.modal-confirm-sub-message').innerHTML = subMessage;
                confirmModal.querySelector('.modal-confirm-label').innerHTML = label;
                confirmModal.querySelector('.modal-confirm-title').innerHTML = `Confirm ${action}`;
                confirmModal.querySelector('form').action = href;

                if (inputMessage) {
                    textAreaMessage.classList.remove('hidden');
                    textAreaMessage.focus();
                } else {
                    textAreaMessage.classList.add('hidden');
                }

                if (href) {
                    buttonYes.setAttribute('type', 'submit');
                    buttonYes.classList.remove('dismiss-modal');
                    buttonYes.innerHTML = action.charAt(0).toUpperCase() + action.slice(1);
                    buttonNo.innerHTML = actionRefuse.charAt(0).toUpperCase() + actionRefuse.slice(1);
                    if (submitRefuse) {
                        buttonNo.setAttribute('type', 'submit');
                        buttonNo.setAttribute('value', '1');
                        buttonNo.setAttribute('name', 'refuse');
                        buttonNo.classList.remove('dismiss-modal');
                        buttonNo.classList.remove('button-light');
                        buttonNo.classList.add('button-red');
                    } else {
                        buttonNo.classList.add('dismiss-modal');
                        buttonNo.classList.add('button-light');
                        buttonNo.classList.remove('button-red');
                    }
                } else {
                    buttonYes.setAttribute('type', 'button');
                    buttonNo.setAttribute('type', 'button');
                    buttonYes.classList.add('dismiss-modal');
                    buttonNo.classList.add('dismiss-modal');
                }
            }
        });
    });
}
