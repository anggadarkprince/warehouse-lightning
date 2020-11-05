import {getNumeric, setNumeric} from "../numeric";

export default function () {
    const buttonAddGoods = document.getElementById('btn-add-goods');
    const modalListGoods = initModal(document.getElementById('modal-list-goods'));

    const modalTakeGoods = initModal(document.getElementById('modal-take-goods'));
    const formTakeGoods = modalTakeGoods.querySelector('form');
    const inputItemName = formTakeGoods.querySelector('#goods_item_name');
    const inputUnitQuantity = formTakeGoods.querySelector('#goods_unit_quantity');
    const inputPackageQuantity = formTakeGoods.querySelector('#goods_package_quantity');
    const inputWeight = formTakeGoods.querySelector('#goods_weight');
    const inputGrossWeight = formTakeGoods.querySelector('#goods_gross_weight');
    const labelUnitName = formTakeGoods.querySelector('#goods_label_unit_name');
    const labelUnitPackage = formTakeGoods.querySelector('#goods_label_unit_package');

    const inputTakeUnitQuantity = formTakeGoods.querySelector('#goods_take_unit_quantity');
    const inputTakePackageQuantity = formTakeGoods.querySelector('#goods_take_package_quantity');
    const inputTakeWeight = formTakeGoods.querySelector('#goods_take_weight');
    const inputTakeGrossWeight = formTakeGoods.querySelector('#goods_take_gross_weight');

    const goodsListWrapper = modalListGoods.querySelector('#goods-wrapper');
    const goodsListPlaceholder = goodsListWrapper.querySelector('.goods-placeholder');
    const goodsListPlaceholderMessageWrapper = goodsListPlaceholder.querySelector('td');
    const buttonReload = modalListGoods.querySelector('.btn-reload');
    const goodsListRowTemplate = document.getElementById('goods-list-row-template').innerHTML;

    const goodsWrapper = document.getElementById('goods-wrapper');
    const goodsPlaceholder = goodsWrapper.querySelector('.goods-placeholder');
    const goodsRowTemplate = document.getElementById('goods-row-template').innerHTML;

    const modalInfo = initModalInfo(document.getElementById('modal-info'));
    let fetchedGoods = [];
    let selectedItem = null;
    let selectedListItem = null;

    const MODE_CREATE = 'create';
    const MODE_EDIT = 'edit';

    /**
     * Add goods by open dialog list item take from source.
     */
    buttonAddGoods.addEventListener('click', function () {
        buttonReload.dataset.sourceUrl = this.dataset.sourceUrl;
        getGoodsSourceList(this.dataset.sourceUrl);
        modalListGoods.open();
    });

    /**
     * Reload goods from source url.
     */
    buttonReload.addEventListener('click', function () {
        getGoodsSourceList(this.dataset.sourceUrl, true);
    });

    /**
     * Get goods data from source url.
     *
     * @param sourceUrl
     * @param forceReload
     */
    function getGoodsSourceList(sourceUrl, forceReload = false) {
        // Remove existing goods item
        const goodsListItems = goodsListWrapper.querySelectorAll('.goods-list-item');
        goodsListItems.forEach(goodsItem => {
            goodsItem.parentNode.removeChild(goodsItem);
        });

        // Prepare loading information about fetching
        buttonReload.classList.add('disabled');
        goodsListPlaceholder.classList.remove('hidden');
        goodsListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-loading mdi-spin mr-1"></i>Fetching source goods';

        // Build from existing goods list
        if (fetchedGoods && fetchedGoods.length && !forceReload) {
            goodsListPlaceholder.classList.add('hidden');
            buildGoodsList(fetchedGoods);
            return;
        }

        // Get goods data from the source
        axios.get(sourceUrl)
            .then(response => {
                fetchedGoods = response.data.goods;
                if (fetchedGoods.length) {
                    goodsListPlaceholder.classList.add('hidden');
                    buildGoodsList(fetchedGoods);
                } else {
                    goodsListPlaceholderMessageWrapper.innerHTML = 'No data available';
                    goodsListPlaceholder.classList.remove('hidden');
                }
            })
            .catch(function (error) {
                let message = 'Error get source container';
                if (error.response.status === 404) {
                    message = 'Source not found';
                }
                goodsListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-close mr-1"></i>' + message;
            })
            .then(function () {
                // Always executed success or error
                buttonReload.classList.remove('disabled');
            });
    }

    /**
     * build goods list from given data.
     *
     * @param goods
     */
    function buildGoodsList(goods = []) {
        // Exclude taken goods
        const takenGoodsIds = Array.from(goodsWrapper.querySelectorAll('.goods-item')).map(goodsItem => {
            // combine goods id with reference id to make unique row
            const goodsId = goodsItem.querySelector('.input-goods-id').value || '0';
            const referenceId = goodsItem.querySelector('.input-reference-id').value || goodsItem.querySelector('.input-id').value || '0';
            return goodsId + '-' + referenceId;
        });
        const filteredGoods = goods.filter(item => {
            const goodsId = _.get(item, 'goods.id', _.get(item, 'goods_id', ''));
            const id = _.get(item, 'reference_id', _.get(item, 'id', '0')) || '0';
            return !takenGoodsIds.includes(goodsId + '-' + id); // [1-23, 2-24, 2-25] includes 2-24
        });

        // Set placeholder if all item already taken
        if (filteredGoods.length === 0) {
            goodsListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-check-all mr-1"></i>All data already taken';
            goodsListPlaceholder.classList.remove('hidden');
        }

        // Map filtered array to goods item template
        const goodsList = filteredGoods.map((item, index) => {
            return Mustache.render(goodsListRowTemplate, {
                goods_order: index + 1,
                id: _.get(item, 'id', ''),
                reference_id: _.get(item, 'id', _.get(item, 'reference_id', '')),
                unit_quantity_label: setNumeric(_.get(item, 'unit_quantity', 0) || 0),
                package_quantity_label: setNumeric(_.get(item, 'package_quantity', 0) || 0),
                weight_label: setNumeric(_.get(item, 'weight', 0) || 0),
                gross_weight_label: setNumeric(_.get(item, 'gross_weight', 0) || 0),
                goods_id: _.get(item, 'goods.id', _.get(item, 'goods_id', '')),
                item_name: _.get(item, 'goods.item_name', _.get(item, 'item_name', '-')) || '-',
                item_number: _.get(item, 'goods.item_number', _.get(item, 'item_number', '-')) || '-',
                unit_name: _.get(item, 'goods.unit_name', _.get(item, 'unit_name', '-')) || '-',
                package_name: _.get(item, 'goods.package_name', _.get(item, 'package_name', '-')) || '-',
                description: _.get(item, 'description', '-') || '-',
            });
        });
        goodsListWrapper.insertAdjacentHTML('beforeend', goodsList.join(''));
    }

    /**
     * Take goods from list
     */
    modalListGoods.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-take')) {
            const goodsListItem = e.target.closest('.goods-list-item');
            const selectedGoodsId = goodsListItem.dataset.goodsId;
            const selectedId = goodsListItem.dataset.referenceId || goodsListItem.dataset.id;
            const item = fetchedGoods.find(item => {
                const goodsId = _.get(item, 'goods.id', _.get(item, 'goods_id', '0')) || '0';
                const id = _.get(item, 'reference_id', _.get(item, 'id', '0')) || '0';
                return (goodsId + '-' + id) === (selectedGoodsId + '-' + selectedId);
            });
            if (item) {
                selectedItem = item;
                selectedListItem = goodsListItem;

                formTakeGoods.dataset.mode = MODE_CREATE;
                formTakeGoods.reset();
                inputItemName.value = _.get(item, 'goods.item_name', _.get(item, 'item_name', '-')) || '-';
                inputUnitQuantity.value = setNumeric(_.get(item, 'unit_quantity', 0) || 0);
                inputPackageQuantity.value = setNumeric(_.get(item, 'package_quantity', 0) || 0);
                inputWeight.value = setNumeric(_.get(item, 'weight', 0) || 0);
                inputGrossWeight.value = setNumeric(_.get(item, 'gross_weight', 0) || 0);
                labelUnitName.textContent = _.get(item, 'goods.unit_name', _.get(item, 'unit_name', '-')) || 'UNIT';
                labelUnitPackage.textContent = _.get(item, 'goods.package_name', _.get(item, 'package_name', '-')) || 'UNIT';
                modalTakeGoods.querySelector('button[type="submit"]').innerHTML = 'Take';
                modalTakeGoods.open();
            } else {
                modalInfo.open(
                    `Selected goods not found in the source list`,
                    `Try to reload the stock or refresh the page to re-validate form state`,
                    'Goods Not Found'
                );
            }
        }
    });

    formTakeGoods.addEventListener('submit', function (e) {
        e.preventDefault();

        const unitQuantity = getNumeric(inputUnitQuantity.value);
        const packageQuantity = getNumeric(inputPackageQuantity.value);
        const weight = getNumeric(inputWeight.value);
        const grossWeight = getNumeric(inputGrossWeight.value);

        const takenUnitQuantity = getNumeric(inputTakeUnitQuantity.value);
        const takenPackageQuantity = getNumeric(inputTakePackageQuantity.value);
        const takenWeight = getNumeric(inputTakeWeight.value);
        const takenGrossWeight = getNumeric(inputTakeGrossWeight.value);

        if (takenUnitQuantity > unitQuantity) {
            modalInfo.open('Taken unit quantity must below or equal available item', '', 'Unit Quantity');
            return false;
        }
        if (takenPackageQuantity > packageQuantity) {
            modalInfo.open('Taken package quantity must below or equal available item', '', 'Package Quantity');
            return false;
        }
        if (takenWeight > weight) {
            modalInfo.open('Taken weight must below or equal available item', '', 'Gross Weight');
            return false;
        }
        if (takenGrossWeight > grossWeight) {
            modalInfo.open('Taken weight must below or equal available item', '', 'Weight');
            return false;
        }
        selectedItem.taken_unit_quantity = takenUnitQuantity;
        selectedItem.taken_package_quantity = takenPackageQuantity;
        selectedItem.taken_weight = takenWeight;
        selectedItem.taken_gross_weight = takenGrossWeight;

        const mode = formTakeGoods.dataset.mode;
        if (mode === MODE_CREATE) {
            takeItem(selectedItem);
        } else {
            updateItem(selectedItem);
        }
        modalTakeGoods.close();
    });

    /**
     * Take item and add to goods wrapper.
     *
     * @param item
     */
    function takeItem(item) {
        const rendered = Mustache.render(goodsRowTemplate, {
            reference_id: _.get(item, 'id', _.get(item, 'reference_id', '')) || '',
            unit_quantity_label: setNumeric(_.get(item, 'taken_unit_quantity', _.get(item, 'unit_quantity', 0)) || 0),
            package_quantity_label: setNumeric(_.get(item, 'taken_package_quantity', _.get(item, 'package_quantity', 0)) || 0),
            weight_label: setNumeric(_.get(item, 'taken_weight', _.get(item, 'weight', 0)) || 0),
            gross_weight_label: setNumeric(_.get(item, 'taken_gross_weight', _.get(item, 'gross_weight', 0)) || 0),
            goods_id: _.get(item, 'goods.id', _.get(item, 'goods_id', '')),
            item_name: _.get(item, 'goods.item_name', _.get(item, 'item_name', '-')) || '-',
            item_number: _.get(item, 'goods.item_number', _.get(item, 'item_number', '-')) || '-',
            unit_name: _.get(item, 'goods.unit_name', _.get(item, 'unit_name', '-')) || '-',
            unit_quantity: _.get(item, 'taken_unit_quantity', _.get(item, 'unit_quantity', 0)) || 0,
            package_name: _.get(item, 'goods.package_name', _.get(item, 'package_name', '-')) || '-',
            package_quantity: _.get(item, 'taken_package_quantity', _.get(item, 'package_quantity', 0)) || 0,
            weight: _.get(item, 'taken_weight', _.get(item, 'weight', 0)) || 0,
            gross_weight: _.get(item, 'taken_gross_weight', _.get(item, 'gross_weight', 0)) || 0,
            description: _.get(item, 'description', ''),

            unit_quantity_default: _.get(item, 'unit_quantity', 0) || 0,
            package_quantity_default: _.get(item, 'package_quantity', 0) || 0,
            weight_default: _.get(item, 'weight', 0) || 0,
            gross_weight_default: _.get(item, 'gross_weight', 0) || 0,
        });
        goodsWrapper.insertAdjacentHTML('beforeend', rendered);
        goodsPlaceholder.classList.add('hidden');
        selectedListItem.remove();
        if (goodsListWrapper.querySelectorAll('.goods-list-item').length === 0) {
            goodsListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-check-all mr-1"></i>All data already taken';
            goodsListPlaceholder.classList.remove('hidden');
        }

        orderInputGoods(goodsWrapper);
    }

    /**
     * Update existing item.
     *
     * @param item
     */
    function updateItem(item) {
        const goodsItem = formTakeGoods.editedRow;
        goodsItem.querySelector('.goods-unit-quantity').innerHTML = setNumeric(_.get(item, 'taken_unit_quantity', _.get(item, 'unit_quantity', 0)) || 0);
        goodsItem.querySelector('.goods-package-quantity').innerHTML = setNumeric(_.get(item, 'taken_package_quantity', _.get(item, 'package_quantity', 0)) || 0);
        goodsItem.querySelector('.goods-weight').innerHTML = setNumeric(_.get(item, 'taken_weight', _.get(item, 'weight', 0)) || 0);
        goodsItem.querySelector('.goods-gross-weight').innerHTML = setNumeric(_.get(item, 'taken_gross_weight', _.get(item, 'gross_weight', 0)) || 0);

        goodsItem.querySelector('.input-goods-unit-quantity').value = getNumeric(_.get(item, 'taken_unit_quantity', _.get(item, 'unit_quantity', 0)) || 0);
        goodsItem.querySelector('.input-goods-package-quantity').value = getNumeric(_.get(item, 'taken_package_quantity', _.get(item, 'package_quantity', 0)) || 0);
        goodsItem.querySelector('.input-goods-weight').value = getNumeric(_.get(item, 'taken_weight', _.get(item, 'weight', 0)) || 0);
        goodsItem.querySelector('.input-goods-gross-weight').value = getNumeric(_.get(item, 'taken_gross_weight', _.get(item, 'gross_weight', 0)) || 0);
    }

    /**
     * Edit existing goods data.
     */
    goodsWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-edit') || target.parentElement.classList.contains('btn-edit')) {
            const goodsItem = target.closest('.goods-item');
            formTakeGoods.dataset.mode = MODE_EDIT;
            formTakeGoods.editedRow = goodsItem;
            formTakeGoods.reset();

            inputItemName.value = goodsItem.querySelector('.input-goods-item-name').value;
            inputUnitQuantity.value = setNumeric(goodsItem.querySelector('.input-goods-unit-quantity').dataset.default || 0);
            inputPackageQuantity.value = setNumeric(goodsItem.querySelector('.input-goods-package-quantity').dataset.default || 0);
            inputWeight.value = setNumeric(goodsItem.querySelector('.input-goods-weight').dataset.default || 0);
            inputGrossWeight.value = setNumeric(goodsItem.querySelector('.input-goods-gross-weight').dataset.default || 0);
            labelUnitName.textContent = goodsItem.querySelector('.input-goods-unit-name').value || 'UNIT';
            labelUnitPackage.textContent = goodsItem.querySelector('.input-goods-package-name').value || 'UNIT';

            inputTakeUnitQuantity.value = setNumeric(goodsItem.querySelector('.input-goods-unit-quantity').value || 0);
            inputTakePackageQuantity.value = setNumeric(goodsItem.querySelector('.input-goods-package-quantity').value || 0);
            inputTakeWeight.value = setNumeric(goodsItem.querySelector('.input-goods-weight').value || 0);
            inputTakeGrossWeight.value = setNumeric(goodsItem.querySelector('.input-goods-gross-weight').value || 0);

            modalTakeGoods.querySelector('button[type="submit"]').innerHTML = 'Update';
            modalTakeGoods.open();
        }
    });

    /**
     * Delete goods from list.
     */
    goodsWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-delete') || target.parentElement.classList.contains('btn-delete')) {
            deleteItem(target.closest('.goods-item'));
        }
    });

    /**
     * Delete individual item of goods.
     *
     * @param goodsItem
     */
    function deleteItem(goodsItem) {
        const goodsWrapper = goodsItem.closest('#goods-wrapper');
        goodsItem.remove();
        if (goodsWrapper.querySelectorAll('.goods-item').length === 0) {
            goodsWrapper.querySelector('.goods-placeholder').classList.remove('hidden');
        } else {
            orderInputGoods(goodsWrapper);
        }
    }

    /**
     * Reorder input files by goods.
     *
     * @param wrapper
     */
    function orderInputGoods(wrapper) {
        wrapper.querySelectorAll('.goods-item').forEach(function (item, index) {
            item.querySelector('.goods-order').innerHTML = (index + 1).toString();
            item.querySelectorAll('input[name]').forEach(function (input) {
                const pattern = new RegExp("goods[([0-9]*\\)?]", "i");
                const attributeName = input.getAttribute('name').replace(pattern, 'goods[' + index + ']');
                input.setAttribute('name', attributeName);
            });
        });
    }

}
