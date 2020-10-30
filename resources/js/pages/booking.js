import variables from "../modules/variables";

const formBooking = document.getElementById('form-booking');

if (formBooking) {
    const buttonAddContainer = document.getElementById('btn-add-container');
    const modalFormContainer = initModal(document.getElementById('modal-form-container'));
    const modalInfo = initModalInfo(document.getElementById('modal-info'));
    const containerWrapper = document.getElementById('container-wrapper');
    const containerRowTemplate = document.getElementById('container-row-template').innerHTML;

    const formContainer = modalFormContainer.querySelector('form');
    const selectContainer = formContainer.querySelector('#container_id');
    const inputContainerSeal = formContainer.querySelector('#container_seal');
    const selectContainerIsEmpty = formContainer.querySelector('#container_is_empty');
    const inputContainerDescription = formContainer.querySelector('#container_description');

    const MODE_CREATE = 'create';
    const MODE_EDIT = 'edit';

    /**
     * Add container by open dialog form.
     */
    buttonAddContainer.addEventListener('click', function () {
        formContainer.dataset.mode = MODE_CREATE;
        formContainer.reset();

        modalFormContainer.querySelector('button[type="submit"]').innerHTML = 'Add Container';
        modalFormContainer.open();
    });

    /**
     * Event handler when user submit the container,
     * add new or update existing one.
     */
    formContainer.addEventListener('submit', function (e) {
        e.preventDefault();

        const containerId = selectContainer.value;
        const containerNumber = selectContainer.options[selectContainer.selectedIndex].dataset.containerNumber;
        const containerType = selectContainer.options[selectContainer.selectedIndex].dataset.containerType;
        const containerSize = selectContainer.options[selectContainer.selectedIndex].dataset.containerSize;
        const seal = inputContainerSeal.value;
        const isEmpty = selectContainerIsEmpty.value;
        const description = inputContainerDescription.value;

        const mode = formContainer.dataset.mode;

        if (mode === MODE_CREATE) {
            const rendered = Mustache.render(containerRowTemplate, {
                container_number: containerNumber,
                container_size: containerSize,
                container_type: containerType,
                is_empty_label: isEmpty === '1' ? 'Yes' : 'No',
                is_empty: isEmpty,
                seal: seal,
                description: description,
                container_id: containerId,
            });
            containerWrapper.insertAdjacentHTML('beforeend', rendered);
            containerWrapper.querySelector('.container-placeholder').classList.add('hidden');
        } else {
            const containerItem = formContainer.editedRow;
            containerItem.querySelector('.container-number').innerHTML = containerNumber;
            containerItem.querySelector('.container-size').innerHTML = containerSize;
            containerItem.querySelector('.container-type').innerHTML = containerType;
            containerItem.querySelector('.container-is-empty').innerHTML = isEmpty === '1' ? 'Yes' : 'No';
            containerItem.querySelector('.container-seal').innerHTML = seal;
            containerItem.querySelector('.container-description').innerHTML = description;

            containerItem.querySelector('.input-container-id').value = containerId;
            containerItem.querySelector('.input-container-number').value = containerNumber;
            containerItem.querySelector('.input-container-type').value = containerType;
            containerItem.querySelector('.input-container-size').value = containerSize;
            containerItem.querySelector('.input-container-is-empty').value = isEmpty;
            containerItem.querySelector('.input-container-seal').value = seal;
            containerItem.querySelector('.input-container-description').value = description;
        }
        orderInputContainers(containerWrapper);
        modalFormContainer.close();
    });

    /**
     * Edit existing document open the same dialog as add document button,
     * but with filled inputs by existing input hidden data.
     */
    containerWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-edit') || target.parentElement.classList.contains('btn-edit')) {
            const containerItem = target.closest('.container-item');
            selectContainer.value = containerItem.querySelector('.input-container-id').value || '';
            inputContainerSeal.value = containerItem.querySelector('.input-container-seal').value || '';
            selectContainerIsEmpty.value = containerItem.querySelector('.input-container-is-empty').value || '';
            inputContainerDescription.value = containerItem.querySelector('.input-container-description').value || '';

            formContainer.dataset.mode = MODE_EDIT;
            formContainer.editedRow = containerItem;

            modalFormContainer.querySelector('button[type="submit"]').innerHTML = 'Update Document';
            modalFormContainer.open();
        }
    });

    /**
     * Delete group of document files, this action will remove
     * entire uploaded files of the document.
     */
    containerWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-delete') || target.parentElement.classList.contains('btn-delete')) {
            deleteFile(target.closest('.container-item'));
        }
    });

    /**
     * Delete individual item of container.
     *
     * @param containerItem
     */
    function deleteFile(containerItem) {
        const containerWrapper = containerItem.closest('#container-wrapper');
        containerItem.remove();
        if (containerWrapper.querySelectorAll('.container-item').length === 0) {
            containerWrapper.querySelector('.container-placeholder').classList.remove('hidden');
        } else {
            orderInputContainers(containerWrapper);
        }
    }

    /**
     * Reorder input files by container.
     *
     * @param wrapper
     */
    function orderInputContainers(wrapper) {
        wrapper.querySelectorAll('.container-item').forEach(function (item, index) {
            item.querySelector('.container-order').innerHTML = (index + 1).toString();
            item.querySelectorAll('input[name]').forEach(function (input) {
                const pattern = new RegExp("containers[([0-9]*\\)?]", "i");
                const attributeName = input.getAttribute('name').replace(pattern, 'containers[' + index + ']');
                input.setAttribute('name', attributeName);
            });
        });
    }
}
