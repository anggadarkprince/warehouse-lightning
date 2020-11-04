import Container from "../modules/stocks/container";
import Goods from "../modules/stocks/goods";
import variables from "../modules/variables";

const formDeliveryOrder = document.getElementById('form-delivery-order');

if (formDeliveryOrder) {
    const selectType = formDeliveryOrder.querySelector('select[name="type"]');
    const selectBooking = formDeliveryOrder.querySelector('select[name="booking_id"]');
    const btnAddContainer = formDeliveryOrder.querySelector('#btn-add-container');

    selectBooking.addEventListener('change', function () {
        btnAddContainer.dataset.bookingId = selectBooking.value;
        btnAddContainer.dataset.sourceUrl = `${variables.baseUrl}/bookings/${selectBooking.value}/containers`;
    });

    Container();
    Goods();
}
