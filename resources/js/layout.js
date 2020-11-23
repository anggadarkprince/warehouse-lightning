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
    inputNavbarSearch.addEventListener('focusout', function () {
        if (!inputNavbarSearch.value) {
            this.classList.add('hidden');
            this.classList.remove('max-w-md');
            this.classList.remove('opacity-100');
            searchPlaceholder.classList.remove('hidden');
        }
    });
}
