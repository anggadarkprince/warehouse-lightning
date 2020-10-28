function setNumericValue(value, prefix = '', ths = '.', dec = ',', thsTarget = '.', decTarget = ',') {
    const signed = value.toString().match(/-/);
    const pattern = new RegExp("[^" + dec + "\\\d]", 'g');
    let number_string = value.toString().replace(pattern, '').toString(),
        splitDecimal = number_string.split(dec),
        groupThousand = splitDecimal[0].length % 3,
        currency = splitDecimal[0].substr(0, groupThousand),
        thousands = splitDecimal[0].substr(groupThousand).match(/\d{3}/gi);
    if (thousands) {
        let separator = groupThousand ? thsTarget : '';
        currency += separator + thousands.join(thsTarget);
    }
    currency = splitDecimal[1] !== undefined ? currency + decTarget + splitDecimal[1] : currency;

    if (currency === '0') {
        return '';
    }

    return prefix + (signed ? '-' : '') + currency;
}

document.addEventListener('keyup', function (event) {
    if (event.target.classList.contains('input-numeric')) {
        const value = event.target.value || 0;
        console.log(setNumericValue(value));
        event.target.value = setNumericValue(value);
    }
});
