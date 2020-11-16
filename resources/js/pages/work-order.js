import Goods from "../modules/stocks/goods";
import Container from "../modules/stocks/container";
import variables from "../modules/variables";
import Choices from "choices.js";

const formWorkOrder = document.getElementById('form-work-order');
if (formWorkOrder) {
    const selectBooking = formWorkOrder.querySelector('[name="booking_id"]');
    const selectJobType = formWorkOrder.querySelector('select[name="job_type"]');
    const selectUser = formWorkOrder.querySelector('select[name="user_id"]');
    const btnAddContainer = formWorkOrder.querySelector('#btn-add-container');
    const btnAddGoods = formWorkOrder.querySelector('#btn-add-goods');
    const containerWrapper = formWorkOrder.querySelector('#container-wrapper');
    const goodsWrapper = formWorkOrder.querySelector('#goods-wrapper');

    selectBooking.addEventListener('change', function () {
        const bookingType = selectBooking.options[selectBooking.selectedIndex].dataset.type;

        selectJobType.querySelectorAll('option').forEach(option => {
            option.classList.remove('hidden');
        });
        if (bookingType === 'OUTBOUND') {
            selectJobType.querySelectorAll('option:not([value="LOADING"])').forEach(option => {
                option.classList.add('hidden');
            });
            selectJobType.value = 'LOADING';
        }
        updateSourceUrl();
    });

    selectJobType.addEventListener('change', updateSourceUrl);

    function updateSourceUrl() {
        if (selectBooking.value && selectJobType.value) {
            btnAddContainer.dataset.bookingId = btnAddGoods.dataset.bookingId = selectBooking.value;
            if (["UNLOADING", "LOADING"].includes(selectJobType.value)) {
                btnAddContainer.dataset.sourceUrl = `${variables.baseUrl}/bookings/${selectBooking.value}/containers`;
                btnAddGoods.dataset.sourceUrl = `${variables.baseUrl}/bookings/${selectBooking.value}/goods`;
            } else {
                btnAddContainer.dataset.sourceUrl = `${variables.baseUrl}/stock/${selectBooking.value}/containers`;
                btnAddGoods.dataset.sourceUrl = `${variables.baseUrl}/stock/${selectBooking.value}/goods`;
            }
            containerWrapper.querySelector('.container-placeholder').classList.remove('hidden');
            goodsWrapper.querySelector('.goods-placeholder').classList.remove('hidden');
        }
    }

    const customTemplates = new Choices(selectUser, {
        shouldSort: false,
        itemSelectText: "",
        callbackOnCreateTemplates: function (strToEl) {
            const itemSelectText = this.config.itemSelectText;
            return {
                item: function (classNames, data) {
                    const customProperties = data.customProperties ? JSON.parse(data.customProperties) : null;
                    const classes = [
                        classNames.item,
                        data.highlighted ? classNames.highlightedState : classNames.itemSelectable,
                        'flex items-center'
                    ];
                    if (data.value === '') {
                        classes.push(classNames.placeholder);
                    }
                    if (customProperties) {
                        return strToEl(`
                            <div class="${classes.join(' ')}"
                                ${data.active ? 'aria-selected="true"' : ''}
                                ${data.disabled ? 'aria-disabled="true"' : ''}
                                data-item
                                data-id="${data.id}"
                                data-value="${data.value}">
                                <img src="${customProperties.avatar}" class="rounded-full object-cover h-4 w-4 mr-2" alt="${data.label}"/>
                                <p>${data.label}</p>
                            </div>
                        `);
                    } else {
                        return strToEl(`
                            <div class="${classes.join(' ')}"
                                ${data.active ? 'aria-selected="true"' : ''}
                                ${data.disabled ? 'aria-disabled="true"' : ''}
                                data-item
                                data-id="${data.id}"
                                data-value="${data.value}">
                                ${data.label}
                            </div>
                        `);
                    }
                },
                choice: function (classNames, data) {
                    const customProperties = data.customProperties ? JSON.parse(data.customProperties) : null;
                    const classes = [
                        String(classNames.item),
                        String(classNames.itemChoice),
                        String(data.disabled ? classNames.itemDisabled : classNames.itemSelectable),
                        'flex items-center'
                    ];
                    if (data.value === '') {
                        classes.push(classNames.placeholder);
                    }
                    if (customProperties) {
                        return strToEl(`
                            <div class="${classes.join(' ')}"
                                ${data.groupId > 0 ? 'role="treeitem"' : 'role="option"'}
                                ${data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable'}
                                data-choice
                                data-select-text="${itemSelectText}"
                                data-id="${data.id}"
                                data-value="${data.value}">
                                <img src="${customProperties.avatar}" class="rounded-full object-cover h-10 w-10 mr-3" alt="${data.label}"/>
                                <div>
                                    <p class="leading-none">${data.label}</p>
                                    <p class="text-gray-500 text-sm">${customProperties.email}</p>
                                </div>
                            </div>
                        `);
                    } else {
                        return strToEl(`
                            <div class="${classes.join(' ')}"
                                role="option"
                                data-choice-selectable
                                data-choice
                                data-select-text="${itemSelectText}"
                                data-id="${data.id}"
                                data-value="${data.value}">
                                ${data.label}
                            </div>
                        `);
                    }
                },
            };
        }
    });

    Container();
    Goods();
}
