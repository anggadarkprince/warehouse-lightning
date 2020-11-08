import Container from "../modules/stocks/container";
import Goods from "../modules/stocks/goods";
import variables from "../modules/variables";

const formDeliveryOrder = document.getElementById('form-delivery-order');

if (formDeliveryOrder) {
    const selectType = formDeliveryOrder.querySelector('select[name="type"]');
    const selectBooking = formDeliveryOrder.querySelector('select[name="booking_id"]');
    const btnAddContainer = formDeliveryOrder.querySelector('#btn-add-container');
    const btnAddGoods = formDeliveryOrder.querySelector('#btn-add-goods');
    const containerWrapper = formDeliveryOrder.querySelector('#container-wrapper');
    const goodsWrapper = formDeliveryOrder.querySelector('#goods-wrapper');

    selectType.addEventListener('change', function() {
        const options = selectBooking.querySelectorAll(`option`);
        options.forEach(function (option) {
            if (option.getAttribute('value')) {
                if (option.dataset.type === selectType.value) {
                    option.classList.remove('hidden');
                } else {
                    option.classList.add('hidden');
                }
            }
        });
        selectBooking.value = '';
    });

    selectBooking.addEventListener('change', function () {
        btnAddContainer.dataset.bookingId = btnAddGoods.dataset.bookingId = selectBooking.value;
        btnAddContainer.dataset.sourceUrl = `${variables.baseUrl}/bookings/${selectBooking.value}/containers`;
        btnAddGoods.dataset.sourceUrl = `${variables.baseUrl}/bookings/${selectBooking.value}/goods`;

        containerWrapper.querySelectorAll('.container-item').forEach((container) => container.remove());
        goodsWrapper.querySelectorAll('.goods-item').forEach((item) => item.remove());
    });

    Container();
    Goods();
}
