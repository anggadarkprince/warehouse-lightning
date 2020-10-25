import Litepicker from 'litepicker';

const datePickers = document.querySelectorAll('.datepicker:not([readonly])');

window.disableLitepickerStyles = true;
if (datePickers) {
    const simpleDateFormat = 'YYYY-MM-DD';
    const fullDateFormat = 'DD MMMM YYYY';
    datePickers.forEach(datePicker => {
        const options = {
            element: datePicker,
            singleMode: true,
            numberOfMonths: 1,
            numberOfColumns: 1,
            format: fullDateFormat,
            onSelect: () => {
                if (datePicker.dataset.clearButton) {
                    const clearButton = document.querySelector(datePicker.dataset.clearButton);
                    if (clearButton) {
                        clearButton.style.display = 'block';
                    }
                }
            }
        };
        if (datePicker.dataset.minDate) {
            options.minDate = datePicker.dataset.minDate;
        }
        if (datePicker.dataset.maxDate) {
            options.maxDate = datePicker.dataset.maxDate;
        }
        if (datePicker.dataset.parentEl) {
            options.parentEl = datePicker.dataset.parentEl;
        }
        if (datePicker.dataset.startDate) {
            options.startDate = datePicker.dataset.startDate;
        }
        if (datePicker.dataset.endDate) {
            options.endDate = datePicker.dataset.endDate;
        }
        const picker = new Litepicker(options);

        if (datePicker.dataset.clearButton) {
            picker.clearButton = document.querySelector(datePicker.dataset.clearButton);
            if (picker.clearButton) {
                picker.clearButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    picker.clearSelection();
                    picker.clearButton.style.display = 'none';
                });
                if (datePicker.value) {
                    picker.clearButton.style.display = 'block';
                } else {
                    picker.clearButton.style.display = 'none';
                }
            }
        }

        datePicker.addEventListener('keydown', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    });
}
