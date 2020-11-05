export default function () {
    const buttonAddContainer = document.getElementById('btn-add-container');
    const modalListContainer = initModal(document.getElementById('modal-list-container'));

    const containerListWrapper = modalListContainer.querySelector('#container-wrapper');
    const containerListPlaceholder = containerListWrapper.querySelector('.container-placeholder');
    const containerListPlaceholderMessageWrapper = containerListPlaceholder.querySelector('td');
    const buttonReload = modalListContainer.querySelector('.btn-reload');
    const containerListRowTemplate = document.getElementById('container-list-row-template').innerHTML;

    const containerWrapper = document.getElementById('container-wrapper');
    const containerPlaceholder = containerWrapper.querySelector('.container-placeholder');
    const containerRowTemplate = document.getElementById('container-row-template').innerHTML;

    const modalInfo = initModalInfo(document.getElementById('modal-info'));
    let fetchedContainers = [];

    /**
     * Add container by open dialog list container take from source.
     */
    buttonAddContainer.addEventListener('click', function () {
        buttonReload.dataset.sourceUrl = this.dataset.sourceUrl;
        getContainerSourceList(this.dataset.sourceUrl);
        modalListContainer.open();
    });

    buttonReload.addEventListener('click', function () {
        getContainerSourceList(this.dataset.sourceUrl, true);
    });

    /**
     * Get container data from source url.
     *
     * @param sourceUrl
     * @param forceReload
     */
    function getContainerSourceList(sourceUrl, forceReload = false) {
        // Remove existing container item
        const containerListItems = containerListWrapper.querySelectorAll('.container-list-item');
        containerListItems.forEach(containerItem => {
            containerItem.parentNode.removeChild(containerItem);
        });

        // Prepare loading information about fetching
        buttonReload.classList.add('disabled');
        containerListPlaceholder.classList.remove('hidden');
        containerListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-loading mdi-spin mr-1"></i>Fetching source container';

        // Build from existing container list
        if (fetchedContainers && fetchedContainers.length && !forceReload) {
            containerListPlaceholder.classList.add('hidden');
            buildContainerList(fetchedContainers);
            return;
        }

        // Get container data from the source
        axios.get(sourceUrl)
            .then(response => {
                fetchedContainers = response.data.containers;
                if (fetchedContainers.length) {
                    containerListPlaceholder.classList.add('hidden');
                    buildContainerList(fetchedContainers);
                } else {
                    containerListPlaceholderMessageWrapper.innerHTML = 'No data available';
                    containerListPlaceholder.classList.remove('hidden');
                }
            })
            .catch(function (error) {
                let message = 'Error get source container';
                if (error.response.status === 404) {
                    message = 'Source not found';
                }
                containerListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-close mr-1"></i>' + message;
            })
            .then(function () {
                // Always executed success or error
                buttonReload.classList.remove('disabled');
            });
    }

    /**
     * build container list from given data.
     *
     * @param containers
     */
    function buildContainerList(containers = []) {
        // Exclude taken container
        const takenContainerIds = Array.from(containerWrapper.querySelectorAll('.container-item')).map(containerItem => {
            return containerItem.querySelector('.input-container-id').value;
        });
        const filteredContainers = containers.filter(container => {
            const containerId = _.get(container, 'container.id', _.get(container, 'container_id', ''));
            return !takenContainerIds.includes(containerId.toString());
        });

        // Set placeholder if all item already taken
        if (filteredContainers.length === 0) {
            containerListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-check-all mr-1"></i>All data already taken';
            containerListPlaceholder.classList.remove('hidden');
        }

        // Map filtered array to container item template
        const containerList = filteredContainers.map((container, index) => {
            return Mustache.render(containerListRowTemplate, {
                container_order: index + 1,
                id: _.get(container, 'id', ''),
                container_id: _.get(container, 'container.id', _.get(container, 'container_id', '')),
                container_number: _.get(container, 'container.container_number', _.get(container, 'container_number', '-')),
                container_size: _.get(container, 'container.container_size', _.get(container, 'container_size', '-')),
                container_type: _.get(container, 'container.container_type', _.get(container, 'container_type', '-')),
                is_empty_label: _.get(container, 'is_empty', '0') ? 'Yes' : 'No',
                seal: _.get(container, 'seal', '') || '-',
                description: _.get(container, 'description', '') || '-',
            });
        });
        containerListWrapper.insertAdjacentHTML('beforeend', containerList.join(''));
    }

    /**
     * Take container from list
     */
    modalListContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-take')) {
            const containerListItem = e.target.closest('.container-list-item');
            const selectedContainerId = containerListItem.dataset.containerId;
            const container = fetchedContainers.find(container => {
                const containerId = _.get(container, 'container.id', _.get(container, 'container_id', ''));
                return containerId.toString() === selectedContainerId;
            });
            if (container) {
                const rendered = Mustache.render(containerRowTemplate, {
                    container_id: _.get(container, 'container.id', _.get(container, 'container_id', '')),
                    container_number: _.get(container, 'container.container_number', _.get(container, 'container_number', '-')),
                    container_size: _.get(container, 'container.container_size', _.get(container, 'container_size', '-')),
                    container_type: _.get(container, 'container.container_type', _.get(container, 'container_type', '-')),
                    is_empty_label: _.get(container, 'is_empty', '0') ? 'Yes' : 'No',
                    is_empty: _.get(container, 'is_empty', '0'),
                    seal: _.get(container, 'seal', ''),
                    description: _.get(container, 'description', ''),
                });
                containerWrapper.insertAdjacentHTML('beforeend', rendered);
                containerPlaceholder.classList.add('hidden');
                containerListItem.remove();
                orderInputContainers(containerWrapper);
                if (containerListWrapper.querySelectorAll('.container-list-item').length === 0) {
                    containerListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-check-all mr-1"></i>All data already taken';
                    containerListPlaceholder.classList.remove('hidden');
                }
            } else {
                modalInfo.open(
                    `Selected container not found in the source list`,
                    `Try to reload the stock or refresh the page to revalidate form state`,
                    'Container Not Found'
                );
            }
        }
    });

    /**
     * Delete container from list.
     */
    containerWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-delete') || target.parentElement.classList.contains('btn-delete')) {
            deleteContainer(target.closest('.container-item'));
        }
    });

    /**
     * Delete individual item of container.
     *
     * @param containerItem
     */
    function deleteContainer(containerItem) {
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
