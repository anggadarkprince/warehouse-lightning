const formDocument = document.getElementById('form-document');

if (formDocument) {
    const buttonAddDocument = document.getElementById('btn-add-document');
    const modalFormDocument = initModal(document.getElementById('modal-form-document'));
    const modalInfo = initModalInfo(document.getElementById('modal-info'));
    const documentWrapper = document.getElementById('document-wrapper');
    const documentUploadTemplate = document.getElementById('document-upload-template').innerHTML;

    const formDocument = modalFormDocument.querySelector('form');
    const selectDocumentType = modalFormDocument.querySelector('#document_type_id');
    const inputDocumentDate = modalFormDocument.querySelector('#document_date');
    const inputDocumentNumber = modalFormDocument.querySelector('#document_number');
    const inputDocumentDescription = modalFormDocument.querySelector('#document_description');

    const MODE_CREATE = 'create';
    const MODE_EDIT = 'edit';

    /**
     * Add document by open dialog document form.
     */
    buttonAddDocument.addEventListener('click', function () {
        formDocument.dataset.mode = MODE_CREATE;
        formDocument.dataset.currentDocumentId = '';

        selectDocumentType.removeAttribute('disabled');
        inputDocumentDate.parentElement.querySelector('.clear-document-date').dispatchEvent(new Event('click'));
        formDocument.reset();

        modalFormDocument.querySelector('button[type="submit"]').innerHTML = 'Add Document';
        modalFormDocument.open();
    });

    /**
     * Event handler when user submit the document,
     * add new or update existing one.
     */
    formDocument.addEventListener('submit', function (e) {
        e.preventDefault();

        const documentTypeId = selectDocumentType.value;
        const documentName = selectDocumentType.options[selectDocumentType.selectedIndex].text;
        const documentDescription = inputDocumentDescription.value;
        const documentNumber = inputDocumentNumber.value;
        const documentDate = inputDocumentDate.value;

        const mode = formDocument.dataset.mode;
        const currentDocumentId = formDocument.dataset.currentDocumentId;
        const inputDocumentTypeIds = documentWrapper.querySelectorAll('.input-document-type-id');

        if (isDocumentAlreadyAdded(inputDocumentTypeIds, documentTypeId, currentDocumentId)) {
            modalInfo.open(
                `Document ${documentName} already added into document list`,
                `If you intended to update document ${documentName}, click add or remove existing button`,
                'Document Exist'
            );
        } else {
            if (mode === MODE_CREATE) {
                const rendered = Mustache.render(documentUploadTemplate, {
                    document_name: documentName,
                    document_description: documentDescription,
                    document_number: documentNumber,
                    document_date: documentDate,
                    document_type_id: documentTypeId,
                });
                documentWrapper.insertAdjacentHTML('beforeend', rendered);
            } else {
                const documentItem = documentWrapper.querySelector(`#document-item-${currentDocumentId}`);
                documentItem.querySelector('.document-description').innerHTML = inputDocumentDescription.value;
                documentItem.querySelector('.document-number').innerHTML = inputDocumentNumber.value;
                documentItem.querySelector('.document-date').innerHTML = inputDocumentDate.value;

                documentItem.querySelector('.input-document-description').value = inputDocumentDescription.value;
                documentItem.querySelector('.input-document-number').value = inputDocumentNumber.value;
                documentItem.querySelector('.input-document-date').value = inputDocumentDate.value;
            }

            modalFormDocument.close();
        }
    });

    /**
     * Check if list input has value of document,
     * because the upload only allow to have one type of document.
     *
     * @param inputElements
     * @param value
     * @param exceptValue
     * @returns {boolean}
     */
    function isDocumentAlreadyAdded(inputElements, value, exceptValue) {
        let isFound = false;

        if (inputElements) {
            inputElements.forEach(input => {
                const isSameDocument = input.value.toString() === value.toString();
                const isNotException = input.value.toString() !== exceptValue.toString();
                if (isSameDocument && isNotException) {
                    isFound = true;
                }
            });
        }

        return isFound;
    }

    /**
     * Edit existing document open the same dialog as add document button,
     * but with filled inputs by existing input hidden data.
     */
    documentWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-edit-document') || target.parentElement.classList.contains('btn-edit-document')) {
            const documentItem = target.closest('.document-item');
            selectDocumentType.value = documentItem.querySelector('.input-document-type-id').value || '';
            inputDocumentDescription.value = documentItem.querySelector('.input-document-description').value || '';
            inputDocumentNumber.value = documentItem.querySelector('.input-document-number').value || '';
            inputDocumentDate.value = documentItem.querySelector('.input-document-date').value || '';

            formDocument.dataset.mode = MODE_EDIT;
            formDocument.dataset.currentDocumentId = selectDocumentType.value;

            selectDocumentType.setAttribute('disabled', 'true');
            modalFormDocument.querySelector('button[type="submit"]').innerHTML = 'Update Document';
            modalFormDocument.open();
        }
    }, false);

    /**
     * Delete group of document files, this action will remove
     * entire uploaded files of the document.
     */
    documentWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-delete-document') || target.parentElement.classList.contains('btn-delete-document')) {
            target.closest('.document-item').remove();
        }
    }, true);
}
