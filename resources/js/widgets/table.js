const setTableViewport = function () {
    // screen.width
    if (window.innerWidth > 768) {
        Array.prototype.forEach.call(document.querySelectorAll('.table-responsive .responsive-label') || [], function(label) {
            label.parentNode.removeChild(label);
        });
        Array.prototype.forEach.call(document.querySelectorAll('.table-responsive .dropdown') || [], function(dropdown) {
            dropdown.style.display = '';
        });
        Array.prototype.forEach.call(document.querySelector('.table-responsive td[data-colspan]') || [], function(td) {
            td.setAttribute('colspan', td.dataset.colspan);
            td.removeAttribute('data-colspan');
        });
    }
    else {
        Array.from(document.querySelectorAll('.table-responsive')).forEach(function (table) {
            let head = [];
            Array.from(table.querySelectorAll(':scope >thead th')).forEach(function (th) {
                head.push(th.innerText);
            });
            Array.from(table.querySelectorAll(':scope >tbody > tr:not(.row-no-header)')).forEach(function (tr) {
                if (tr.querySelectorAll(':scope >td .responsive-label').length === 0) {
                    const cells = tr.querySelectorAll(':scope >td');

                    Array.from(cells).forEach(function (td, i) {
                        if (cells.length === head.length) {
                            td.insertAdjacentHTML('afterbegin', `<span class="responsive-label">${head[i] || ''}</span>`);
                        } else {
                            td.insertAdjacentHTML('afterbegin', `<span class="responsive-label">${td.dataset.headerTitle || ''}</span>`);
                        }
                        td.style.maxWidth = '';
                        if (td.getAttribute('colspan')) {
                            td.setAttribute('data-colspan', td.getAttribute('colspan'));
                            td.removeAttribute('colspan');
                        }
                    });
                    Array.from(tr.querySelectorAll('.dropdown')).forEach(dropdown => {
                        dropdown.style.display = 'inline-block';
                    });
                }
            });
        });
    }
};

setTableViewport();

window.onresize = function () {
    setTableViewport();
};

export default setTableViewport;
