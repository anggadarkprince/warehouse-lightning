// Dropdown event
window.addEventListener('click', function (event) {
    const currentDropdown = event.target;
    if (currentDropdown.classList.contains('dropdown-toggle')) {
        event.stopPropagation();
        event.preventDefault();

        // get dropdown menu
        const currentDropdownMenu = currentDropdown
            .closest('.dropdown')
            .querySelector('.dropdown-menu');

        // close other open dropdowns
        const openDropdownMenu = document.querySelector('.dropdown-menu.show');
        if (openDropdownMenu && openDropdownMenu !== currentDropdownMenu) {
            openDropdownMenu.classList.remove('show');
        }

        // open current
        currentDropdown
            .closest('.dropdown')
            .querySelector('.dropdown-menu')
            .classList.toggle("show");
    }
});

// Close the dropdown menu if the user clicks outside of it
window.addEventListener('click', function(event) {
    if (!event.target.matches('.dropdown-toggle')) {
        const dropdowns = document.querySelectorAll(".dropdown-menu");
        dropdowns.forEach(openDropdown => {
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        });
    }
});
