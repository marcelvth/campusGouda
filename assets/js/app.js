// create global $ and jQuery variables
global.$ = global.jQuery = $;

// any CSS you import will output into a single css file (app.css in this case)
import  '../css/bootstrap.min.css'
import '../css/aos.css'
import '../css/tiny-slider.css'
import '../css/app.css';
import './aos.js';
import './tiny-slider.js';
import './bootstrap.min.js';
import './popper.min.js';
import './jquery.easing.compatibility.js';
import './jquery.easing.min.js';

(function ($) {
    "use strict"; // Start of use strict

    // Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: (target.offset().top - 54)
                }, 500, "easeInOutExpo");
                return false;
            }
        }
    });

    // Closes responsive menu when a scroll trigger link is clicked
    $('.js-scroll-trigger').click(function () {
        $('.navbar-collapse').collapse('hide');
    });

    // Activate scrollspy to add active class to navbar items on scroll
    $('body').scrollspy({
        target: '#mainNav',
        offset: 94
    });

    // Collapse Navbar
    var navbarCollapse = function () {
        if ($("#mainNav").offset().top > 100) {
            $("#mainNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
        }
    };

    // Collapse now if page is not at top
    navbarCollapse();
    // Collapse the navbar when page is scrolled
    $(window).scroll(navbarCollapse);

    // init tiny slider
    slider = tns({
        container: '.slider',
        items: 1,
        loop: false,
        axis: 'vertical',
        gutter: 50
    });

    // init animations
    AOS.init();
    AOS.refreshHard();  //optional

})(jQuery); // End of use strict