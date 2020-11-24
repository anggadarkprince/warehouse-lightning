import variables from "./modules/variables";

const sidebarToggle = document.querySelector('.sidebar-toggle');
const sidebarWrapper = document.getElementById('sidebar-wrapper');

let lastWidth = window.innerWidth;
window.addEventListener('resize', function (event) {
    // resize from small to wide
    if (lastWidth < 768 && window.innerWidth > lastWidth) {
        if (sidebarWrapper.classList.contains('toggled')) {
            sidebarWrapper.classList.remove('toggled');
        }
    }
    // resize from wide to small
    if (lastWidth >= 768 && window.innerWidth < lastWidth) {
        if (sidebarWrapper.classList.contains('toggled')) {
            sidebarWrapper.classList.remove('toggled');
        }
    }
    lastWidth = window.innerWidth;
});

if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
        sidebarWrapper.classList.toggle('toggled');
    });
}

if (sidebarWrapper) {
    sidebarWrapper.addEventListener('click', event => {
        const currentMenu = event.target;
        if (currentMenu.classList.contains('menu-toggle')) {
            event.stopPropagation();
            event.preventDefault();
            const hrefTarget = currentMenu.getAttribute('href');
            const submenuTarget = document.querySelector(hrefTarget);

            // toggle height
            if (submenuTarget.clientHeight > 0) {
                submenuTarget.style.height = '0';
            } else {
                const wrapper = submenuTarget.querySelector('ul');
                submenuTarget.style.height = wrapper.clientHeight + "px";
            }

            // toggle menu state
            currentMenu.classList.toggle('collapsed');
        }
    });
}

// calculate element height that currently open (css transition can read initial height)
const openSubmenus = document.querySelectorAll('.sidebar-submenu:not(.submenu-hide)');
if (openSubmenus) {
    openSubmenus.forEach(submenuTarget => {
        const wrapper = submenuTarget.querySelector('ul');
        submenuTarget.style.height = wrapper.clientHeight + "px";
    })
}

const searchPlaceholder = document.getElementById('search-placeholder');
const inputNavbarSearch = document.getElementById('input-navbar-search');
const searchNavbarResult = document.getElementById('search-navbar-result');
const searchNavbarLoading = document.getElementById('search-navbar-loading');
if (searchPlaceholder) {
    searchPlaceholder.addEventListener('click', function () {
        this.classList.add('hidden');
        inputNavbarSearch.classList.remove('hidden');
        setTimeout(function () {
            inputNavbarSearch.classList.add('max-w-md');
            inputNavbarSearch.classList.add('opacity-100');
        });
        inputNavbarSearch.focus();
    });
}

if (inputNavbarSearch) {
    inputNavbarSearch.addEventListener('focusin', function () {
        if (inputNavbarSearch.value) {
            searchNavbarResult.classList.remove('hidden');
            if (!searchNavbarResult.returnResult) {
                search();
            }
        }
    });

    inputNavbarSearch.addEventListener('focusout', function () {
        if (!inputNavbarSearch.value) {
            this.classList.add('hidden');
            this.classList.remove('max-w-md');
            this.classList.remove('opacity-100');
            searchPlaceholder.classList.remove('hidden');
        }
    });

    window.addEventListener('click', function (e) {
        if (!document.getElementById('search-navbar-form').contains(e.target)) {
            searchNavbarResult.classList.add('hidden');
        }
    });

    inputNavbarSearch.addEventListener('keyup', _.debounce(search, 500));

    const algoliasearch = require("algoliasearch");
    const client = algoliasearch("QM5NXIEWE3", "ae2829b9df0c653ad10ff070badd8402");
    const indexBookings = client.initIndex("bookings");
    const indexWorkOrders = client.initIndex("work_orders");
    const indexDeliveryOrders = client.initIndex("delivery_orders");

    const searchBookingTitle = document.getElementById('search-booking-title');
    const searchBookingWrapper = document.getElementById('search-booking-wrapper');
    const searchJobTitle = document.getElementById('search-job-title');
    const searchJobWrapper = document.getElementById('search-job-wrapper');
    const searchDeliveryTitle = document.getElementById('search-delivery-title');
    const searchDeliveryWrapper = document.getElementById('search-delivery-wrapper');
    const searchResultTemplate = document.getElementById('search-result-template').innerHTML;

    function search() {
        if (inputNavbarSearch.value) {
            searchNavbarLoading.classList.remove('hidden');
            searchNavbarResult.classList.remove('hidden');

            searchBookingTitle.classList.add('hidden');
            searchJobTitle.classList.add('hidden');
            searchDeliveryTitle.classList.add('hidden');

            while (searchBookingWrapper.firstChild) {
                searchBookingWrapper.removeChild(searchBookingWrapper.lastChild);
            }
            while (searchJobWrapper.firstChild) {
                searchJobWrapper.removeChild(searchJobWrapper.lastChild);
            }
            while (searchDeliveryWrapper.firstChild) {
                searchDeliveryWrapper.removeChild(searchDeliveryWrapper.lastChild);
            }

            const searchBooking = indexBookings.search(inputNavbarSearch.value, {length: 3, hitsPerPage: 3});
            const searchWorkOrder = indexWorkOrders.search(inputNavbarSearch.value, {length: 3, hitsPerPage: 3});
            const searchDeliveryOrder = indexDeliveryOrders.search(inputNavbarSearch.value, {
                length: 3,
                hitsPerPage: 3
            });

            Promise.all([searchBooking, searchWorkOrder, searchDeliveryOrder])
                .then(results => {
                    searchNavbarResult.returnResult = true;

                    const bookings = results[0];
                    const workOrders = results[1];
                    const deliveryOrders = results[2];

                    searchNavbarLoading.classList.add('hidden');

                    if (bookings.hits.length) {
                        searchBookingTitle.classList.remove('hidden');
                        bookings.hits.forEach(result => {
                            const rendered = Mustache.render(searchResultTemplate, {
                                url: `${variables.baseUrl}/bookings/${result.id}`,
                                title: result.booking_number,
                                subtitle: result.reference_number,
                                description: result.customer_name,
                                label: result.type,
                                label_color: result.type === 'INBOUND' ? 'text-green-400' : 'text-red-400',
                            });
                            searchBookingWrapper.insertAdjacentHTML('beforeend', rendered);
                        })
                    }

                    if (workOrders.hits.length) {
                        searchJobTitle.classList.remove('hidden');
                        workOrders.hits.forEach(result => {
                            const rendered = Mustache.render(searchResultTemplate, {
                                url: `${variables.baseUrl}/warehouse/work-orders/${result.id}`,
                                title: result.job_type,
                                subtitle: result.job_number,
                                description: result.assigned_to,
                            });
                            searchJobWrapper.insertAdjacentHTML('beforeend', rendered);
                        })
                    }

                    if (deliveryOrders.hits.length) {
                        searchDeliveryTitle.classList.remove('hidden');
                        deliveryOrders.hits.forEach(result => {
                            const rendered = Mustache.render(searchResultTemplate, {
                                url: `${variables.baseUrl}/delivery-orders/${result.id}`,
                                title: result.delivery_number,
                                subtitle: result.destination_address || result.destination,
                            });
                            searchDeliveryWrapper.insertAdjacentHTML('beforeend', rendered);
                        })
                    }

                    if (bookings.hits.length === 0 && workOrders.hits.length === 0 && deliveryOrders.hits.length === 0) {
                        searchBookingWrapper.insertAdjacentHTML('beforeend', '<p class="text-gray-400 px-4">No result data available.</p>');
                    }
                })
                .catch(err => {
                    searchNavbarResult.returnResult = false;
                    searchNavbarLoading.classList.add('hidden');
                    console.log(err);
                });
        } else {
            searchNavbarResult.classList.add('hidden');
        }
    }
}
