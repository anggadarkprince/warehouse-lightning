import {getNumeric, setNumeric} from "../numeric";

export default function () {
    const buttonAddGoods = document.getElementById('btn-add-goods');
    const modalFormGoods = initModal(document.getElementById('modal-form-goods'));

    const formGoods = modalFormGoods.querySelector('form');
    const selectGoods = formGoods.querySelector('#goods_id');
    const inputUnitQuantity = formGoods.querySelector('#goods_unit_quantity');
    const inputPackageQuantity = formGoods.querySelector('#goods_package_quantity');
    const inputWeight = formGoods.querySelector('#goods_weight');
    const inputGrossWeight = formGoods.querySelector('#goods_gross_weight');
    const inputDescription = formGoods.querySelector('#goods_description');

    const goodsWrapper = document.getElementById('goods-wrapper');
    const goodsRowTemplate = document.getElementById('goods-row-template').innerHTML;

    const MODE_CREATE = 'create';
    const MODE_EDIT = 'edit';

    /**
     * Add goods by open dialog form.
     */
    buttonAddGoods.addEventListener('click', function () {
        formGoods.dataset.mode = MODE_CREATE;
        formGoods.reset();

        modalFormGoods.querySelector('button[type="submit"]').innerHTML = 'Add Goods';
        modalFormGoods.open();
    });

    /**
     * Event handler when user submit the goods,
     * add new or update existing one.
     */
    formGoods.addEventListener('submit', function (e) {
        e.preventDefault();

        const goodsId = selectGoods.value;
        const itemName = selectGoods.options[selectGoods.selectedIndex].dataset.itemName;
        const itemNumber = selectGoods.options[selectGoods.selectedIndex].dataset.itemNumber;
        const itemUnitName = selectGoods.options[selectGoods.selectedIndex].dataset.unitName;
        const itemPackageName = selectGoods.options[selectGoods.selectedIndex].dataset.packageName;
        const unitQuantity = inputUnitQuantity.value || 0;
        const packageQuantity = inputPackageQuantity.value || 0;
        const weight = inputWeight.value || 0;
        const grossWeight = inputGrossWeight.value || 0;
        const description = inputDescription.value;

        const mode = formGoods.dataset.mode;

        if (mode === MODE_CREATE) {
            const rendered = Mustache.render(goodsRowTemplate, {
                unit_quantity_label: unitQuantity,
                package_quantity_label: packageQuantity,
                weight_label: weight,
                gross_weight_label: grossWeight,
                goods_id: goodsId,
                item_name: itemName,
                item_number: itemNumber,
                unit_name: itemUnitName,
                unit_quantity: getNumeric(unitQuantity),
                package_name: itemPackageName,
                package_quantity: getNumeric(packageQuantity),
                weight: getNumeric(weight),
                gross_weight: getNumeric(grossWeight),
                description: description,
            });
            goodsWrapper.insertAdjacentHTML('beforeend', rendered);
            goodsWrapper.querySelector('.goods-placeholder').classList.add('hidden');
        } else {
            const goodsItem = formGoods.editedRow;
            goodsItem.querySelector('.goods-item-name').innerHTML = itemName;
            goodsItem.querySelector('.goods-item-number').innerHTML = itemNumber;
            goodsItem.querySelector('.goods-unit-name').innerHTML = itemUnitName;
            goodsItem.querySelector('.goods-unit-quantity').innerHTML = unitQuantity;
            goodsItem.querySelector('.goods-package-name').innerHTML = itemPackageName;
            goodsItem.querySelector('.goods-package-quantity').innerHTML = packageQuantity;
            goodsItem.querySelector('.goods-weight').innerHTML = weight;
            goodsItem.querySelector('.goods-gross-weight').innerHTML = grossWeight;
            goodsItem.querySelector('.goods-description').innerHTML = description;

            goodsItem.querySelector('.input-goods-id').value = goodsId;
            goodsItem.querySelector('.input-goods-item-name').value = itemName;
            goodsItem.querySelector('.input-goods-item-number').value = itemNumber;
            goodsItem.querySelector('.input-goods-unit-name').value = itemUnitName;
            goodsItem.querySelector('.input-goods-unit-quantity').value = getNumeric(unitQuantity);
            goodsItem.querySelector('.input-goods-package-name').value = itemPackageName;
            goodsItem.querySelector('.input-goods-package-quantity').value = getNumeric(packageQuantity);
            goodsItem.querySelector('.input-goods-weight').value = getNumeric(weight);
            goodsItem.querySelector('.input-goods-gross-weight').value = getNumeric(grossWeight);
            goodsItem.querySelector('.input-goods-description').value = description;
        }
        orderInputGoods(goodsWrapper);
        modalFormGoods.close();
    });

    /**
     * Edit existing document open the same dialog as add document button,
     * but with filled inputs by existing input hidden data.
     */
    goodsWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('btn-edit') || target.parentElement.classList.contains('btn-edit')) {
            const goodsItem = target.closest('.goods-item');
            selectGoods.value = goodsItem.querySelector('.input-goods-id').value || '';
            inputUnitQuantity.value = setNumeric(goodsItem.querySelector('.input-goods-unit-quantity').value) || '';
            inputPackageQuantity.value = setNumeric(goodsItem.querySelector('.input-goods-package-quantity').value) || '';
            inputWeight.value = setNumeric(goodsItem.querySelector('.input-goods-weight').value) || '';
            inputGrossWeight.value = setNumeric(goodsItem.querySelector('.input-goods-gross-weight').value) || '';
            inputDescription.value = goodsItem.querySelector('.input-goods-description').value || '';

            formGoods.dataset.mode = MODE_EDIT;
            formGoods.editedRow = goodsItem;

            modalFormGoods.querySelector('button[type="submit"]').innerHTML = 'Update Goods';
            modalFormGoods.open();
        }
    });

    /**
     * Delete goods item list.
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
