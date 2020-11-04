import numericFormat from "../modules/numeric";

document.addEventListener('keyup', function (event) {
    if (event.target.classList.contains('input-numeric')) {
        const value = event.target.value;
        event.target.value = value === '' ? '' : numericFormat(value || 0);
    }
});
