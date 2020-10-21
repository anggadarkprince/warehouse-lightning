const confirmDeletes = document.querySelectorAll(".confirm-delete");
if(confirmDeletes) {
    confirmDeletes.forEach(confirmButton => {
        confirmButton.addEventListener("click", function(event){
            event.preventDefault();
            const deleteModal = document.querySelector('#modal-delete');
            if (deleteModal) {
                deleteModal.style.display = "block";
                document.body.classList.add('overflow-hidden');

                const label = this.dataset.label || 'Data';
                const title = this.dataset.title || '';
                const href = this.dataset.href || this.getAttribute('href') || '#';

                deleteModal.querySelector('.delete-label').innerHTML = label;
                deleteModal.querySelector('.delete-title').innerHTML = `Delete ${title}`;
                deleteModal.querySelector('form').action = href;
            }
        });
    });
}
