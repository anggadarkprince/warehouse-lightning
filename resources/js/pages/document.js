import variables from "../modules/variables";

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
                documentWrapper.querySelector('.document-placeholder').classList.add('hidden');

                // add drag and drop functionality
                const currentDocument = documentWrapper.lastElementChild;
                currentDocument.addEventListener('dragenter', onDragOverDocument);
                currentDocument.addEventListener('dragleave', onDragLeaveDocument);
                currentDocument.addEventListener('dragover', onDragOverDocument);
                currentDocument.addEventListener('drop', function(e) {
                    e.preventDefault();
                    onDragLeaveDocument(e);
                    uploadFiles(e.dataTransfer.files, currentDocument);
                });
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
     * When enter and over the wrapper.
     *
     * @param e
     */
    function onDragOverDocument(e) {
        e.preventDefault();
        e.currentTarget.classList.add('border');
        e.currentTarget.classList.add('border-green-500');
    }

    /**
     * When leave document wrapper.
     *
     * @param e
     */
    function onDragLeaveDocument(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('border');
        e.currentTarget.classList.remove('border-green-500');
    }

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
    });

    /**
     * Delete group of document files, this action will remove
     * entire uploaded files of the document.
     */
    documentWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-delete-document') || target.parentElement.classList.contains('btn-delete-document')) {
            target.closest('.document-item').remove();
            if (documentWrapper.querySelectorAll('.document-item').length === 0) {
                documentWrapper.querySelector('.document-placeholder').classList.remove('hidden');
            }
        }
    });

    const fileUploadTemplate = document.getElementById('file-upload-template').innerHTML;
    documentWrapper.addEventListener('change', function (e) {
        const target = e.target;
        if (target.classList.contains('input-file')) {
            const files = e.target.files;
            const documentItem = target.closest('.document-item');
            uploadFiles(files, documentItem);
        }
    });

    function uploadFiles(files, documentItem) {
        const fileWrapper = documentItem.querySelector('.file-wrapper');
        if (files && files.length > 0) {
            fileWrapper.querySelector('.file-placeholder').classList.add('hidden');

            // Loop through all selected files and add template file item into document
            Array.from(files).forEach((file, fileIndex) => {
                const documentTypeId = documentItem.querySelector('.input-document-type-id').value;
                const rendered = Mustache.render(fileUploadTemplate, {
                    file_name: file.name,
                    upload_percentage: '0%',
                    index: fileIndex,
                    document_type_id: documentTypeId,
                });
                fileWrapper.insertAdjacentHTML('beforeend', rendered);

                // Build form data
                let data = new FormData();
                data.append('file', file);
                data.append('_token', variables.csrfToken);

                // Build request and set header
                let request = new XMLHttpRequest();
                request.open('POST', `${variables.baseUrl}/uploads/file`);
                request.setRequestHeader('Accept', 'application/json');

                // Despite "infamous loop problem" resolved by anonymous function and passing last item to track
                // the current uploaded progress
                (function (fileItem, xmlRequest) {
                    const uploadPercentageLabel = fileItem.querySelector('.upload-percentage');
                    const uploadProgressLabel = fileItem.querySelector('.upload-progress');

                    request.upload.onprogress = function (e) {
                        // upload progress as percentage
                        let percentCompleted = Math.ceil((e.loaded / e.total) * 100);
                        uploadPercentageLabel.innerHTML = percentCompleted + '%';
                        uploadProgressLabel.style.width = percentCompleted + '%';
                    };

                    // Request finished event
                    let isLoaded = false;
                    request.addEventListener('load', function (e) {
                        // HTTP status message (200, 422 etc)
                        const status = request.status;

                        // request.response holds response from the server
                        const response = JSON.parse(request.response);

                        if (status === 200) {
                            uploadPercentageLabel.innerHTML = 'UPLOADED';
                            fileItem.querySelector('.input-file-src').value = response.data.path;
                            fileItem.querySelector('.input-file-name').value = response.data.original_name;
                        } else {
                            if (request.status === 422) {
                                uploadPercentageLabel.innerHTML = response.errors.file.shift() || response.message || 'Upload failed';
                            } else if (request.status === 404) {
                                uploadPercentageLabel.innerHTML = 'Not found';
                            } else {
                                uploadPercentageLabel.innerHTML = 'Upload failed';
                            }
                            uploadPercentageLabel.classList.add('text-red-500');
                        }

                        // Toggle button from cancel to delete
                        const buttonDelete = fileItem.querySelector('.btn-delete-file');
                        const buttonDeleteIcon = fileItem.querySelector('i');
                        buttonDeleteIcon.classList.remove('mdi-close');
                        buttonDeleteIcon.classList.add('mdi-trash-can-outline');
                        buttonDelete.classList.remove('button-light');
                        buttonDelete.classList.add('button-orange');
                        isLoaded = true;
                    });

                    // Request error event
                    request.addEventListener('error', function (e) {
                        uploadPercentageLabel.innerHTML = 'Upload failed';
                    });

                    // Request abort by user or delete if xml request is completed
                    fileItem.querySelector('.btn-delete-file').addEventListener('click', function () {
                        if (!isLoaded) {
                            xmlRequest.abort();
                        }
                        deleteFile(fileItem);
                    });

                }(fileWrapper.lastElementChild, request));

                // Send POST request to server
                request.send(data);
            });

            // Reorder input index
            orderInputFiles(documentItem);
        }
    }

    /**
     * Add listener existing button when initial load such as when Edit or Retry submission
     */
    documentWrapper.querySelectorAll('.btn-delete-file').forEach(existingBtnDelete => {
        existingBtnDelete.addEventListener('click', function () {
            const fileItem = existingBtnDelete.closest('.file-item');
            deleteFile(fileItem);
        });
    });

    /**
     * Delete individual item of document.
     *
     * @param fileItem
     */
    function deleteFile(fileItem) {
        const documentItem = fileItem.closest('.document-item');
        const fileWrapper = fileItem.closest('.file-wrapper');
        fileItem.remove();
        if (fileWrapper.querySelectorAll('.file-item').length === 0) {
            fileWrapper.querySelector('.file-placeholder').classList.remove('hidden');
        } else {
            orderInputFiles(documentItem);
        }
    }

    /**
     * Reorder input files by document.
     *
     * @param documentItem
     */
    function orderInputFiles(documentItem) {
        documentItem.querySelectorAll('.file-item').forEach(function (fileItem, index) {
            fileItem.querySelectorAll('input[name]').forEach(function (input) {
                const pattern = new RegExp("\\[files\\][([0-9]*\\)?]", "i");
                const attributeName = input.getAttribute('name').replace(pattern, '[files][' + index + ']');
                input.setAttribute('name', attributeName);
            });
        });
    }
}
