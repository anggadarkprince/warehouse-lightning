import Goods from "../modules/stocks/goods";
import Container from "../modules/stocks/container";
import variables from "../modules/variables";

const formWorkOrder = document.getElementById('form-work-order');
if (formWorkOrder) {
    const selectBooking = formWorkOrder.querySelector('[name="booking_id"]');
    const selectJobType = formWorkOrder.querySelector('select[name="job_type"]');
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

    Container();
    Goods();
}
