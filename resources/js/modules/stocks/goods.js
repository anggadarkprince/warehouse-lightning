import {setNumeric} from "../numeric";

export default function () {
    const buttonAddGoods = document.getElementById('btn-add-goods');
    const modalListGoods = initModal(document.getElementById('modal-list-goods'));

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
                goodsListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-close mr-1"></i>Error get source goods';
                console.log(error);
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
        const takenContainerIds = Array.from(goodsWrapper.querySelectorAll('.goods-item')).map(goodsItem => {
            return goodsItem.querySelector('.input-goods-id').value;
        });
        const filteredGoods = goods.filter(item => {
            const containerId = _.get(item, 'goods.id', _.get(item, 'goods_id', ''));
            return !takenContainerIds.includes(containerId.toString());
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
            const item = fetchedGoods.find(item => {
                const goodsId = _.get(item, 'goods.id', _.get(item, 'goods_id', ''));
                return goodsId.toString() === selectedGoodsId;
            });
            if (item) {
                const rendered = Mustache.render(goodsRowTemplate, {
                    unit_quantity_label: setNumeric(_.get(item, 'unit_quantity', 0) || 0),
                    package_quantity_label: setNumeric(_.get(item, 'package_quantity', 0) || 0),
                    weight_label: setNumeric(_.get(item, 'weight', 0) || 0),
                    gross_weight_label: setNumeric(_.get(item, 'gross_weight', 0) || 0),
                    goods_id: _.get(item, 'goods.id', _.get(item, 'goods_id', '')),
                    item_name: _.get(item, 'goods.item_name', _.get(item, 'item_name', '-')) || '-',
                    item_number: _.get(item, 'goods.item_number', _.get(item, 'item_number', '-')) || '-',
                    unit_name: _.get(item, 'goods.unit_name', _.get(item, 'unit_name', '-')) || '-',
                    unit_quantity: _.get(item, 'unit_quantity', 0) || 0,
                    package_name: _.get(item, 'goods.package_name', _.get(item, 'package_name', '-')) || '-',
                    package_quantity: _.get(item, 'package_quantity', 0) || 0,
                    weight: _.get(item, 'weight', 0) || 0,
                    gross_weight: _.get(item, 'gross_weight', 0) || 0,
                    description: _.get(item, 'description', ''),
                });
                goodsWrapper.insertAdjacentHTML('beforeend', rendered);
                goodsPlaceholder.classList.add('hidden');
                goodsListItem.remove();
                orderInputGoods(goodsWrapper);
                if (goodsListWrapper.querySelectorAll('.goods-list-item').length === 0) {
                    goodsListPlaceholderMessageWrapper.innerHTML = '<i class="mdi mdi-check-all mr-1"></i>All data already taken';
                    goodsListPlaceholder.classList.remove('hidden');
                }
            } else {
                modalInfo.open(
                    `Selected goods not found in the source list`,
                    `Try to reload the stock or refresh the page to re-validate form state`,
                    'Goods Not Found'
                );
            }
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
