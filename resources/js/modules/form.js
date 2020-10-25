const forms = document.querySelectorAll('form:not(.static-form)');
forms.forEach(form => {
    form.addEventListener('submit', function () {
        if ((form.valid && form.valid()) || !form.valid) {
            setTimeout(function () {
                const fieldset = form.querySelector('fieldset');
                if (fieldset) {
                    fieldset.setAttribute('disabled', 'true');
                } else {
                    const inputs = form.querySelectorAll('input, select, textarea, button') || [];
                    inputs.forEach(input => {
                        input.setAttribute('disabled', 'true');
                    });
                }
            }, 100);
        }
    });
});
