import numericFormat from "../modules/numeric";

document.addEventListener('keyup', function (event) {
    if (event.target.classList.contains('input-numeric')) {
        const value = event.target.value || 0;
        event.target.value = numericFormat(value);
    }
});
