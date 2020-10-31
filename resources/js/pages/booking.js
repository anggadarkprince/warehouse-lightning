import Container from "../modules/editors/container";
import Goods from "../modules/editors/goods";

const formBooking = document.getElementById('form-booking');

if (formBooking) {
    const selectUpload = formBooking.querySelector('select[name="upload_id"]');
    const selectType = formBooking.querySelector('select[name="type"]');
    const selectBookingType = formBooking.querySelector('select[name="booking_type_id"]');
    const selectCustomer = formBooking.querySelector('select[name="customer_id"]');

    selectUpload.addEventListener('change', function () {
        if (selectUpload.value) {
            const type = selectUpload.options[selectUpload.selectedIndex].dataset.type;
            const bookingTypeId = selectUpload.options[selectUpload.selectedIndex].dataset.bookingTypeId;
            const customerId = selectUpload.options[selectUpload.selectedIndex].dataset.customerId;

            selectType.value = type;
            selectBookingType.value = bookingTypeId;
            selectCustomer.value = customerId;

            selectType.classList.add('pointer-events-none');
            selectBookingType.classList.add('pointer-events-none');
            selectCustomer.classList.add('pointer-events-none');
        } else {
            selectType.value = '';
            selectBookingType.value = '';
            selectCustomer.value = '';

            selectType.classList.remove('pointer-events-none');
            selectBookingType.classList.remove('pointer-events-none');
            selectCustomer.classList.remove('pointer-events-none');
        }
    });

    selectType.addEventListener('change', function () {
        const options = selectBookingType.querySelectorAll(`option`);
        options.forEach(function (option) {
            if (option.getAttribute('value')) {
                if (option.dataset.type === selectType.value) {
                    option.classList.remove('hidden');
                } else {
                    option.classList.add('hidden');
                }
            }
        });
        selectBookingType.value = '';
    });

    Container();
    Goods();
}
