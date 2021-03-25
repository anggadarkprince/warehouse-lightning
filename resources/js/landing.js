const landingHeader = document.getElementById("landing-header");
if (landingHeader) {
    let lastScrollTop = 0;
    window.onscroll = function () {
        /* sticky header on scroll to down > 200px
        if (window.pageYOffset > 300) {
            landingHeader.classList.add(...["fixed", "shadow"]);
            landingHeader.style.top = '0';
        } else {
            landingHeader.classList.remove(...["fixed", "shadow"]);
            landingHeader.style.top = '-80px';
        }
        */

        // sticky header when scroll up > 200
        const st = window.pageYOffset || document.documentElement.scrollTop;
        if (st > lastScrollTop || window.pageYOffset < 200) {
            // down scroll
            landingHeader.classList.remove(...["fixed", "shadow"]);
            landingHeader.style.top = '-80px';
            document.body.style.paddingTop = '0';
        } else {
            // up scroll
            landingHeader.classList.add(...["fixed", "shadow"]);
            landingHeader.style.top = '0';
            document.body.style.paddingTop = '72px'; // height of header
        }
        lastScrollTop = st <= 0 ? 0 : st;
    };
}
