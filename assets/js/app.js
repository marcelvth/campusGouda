// create global $ and jQuery variables
const $ = require('jquery');
//import bootstrap
require('bootstrap');
//import tiny-slider from node modules
import {tns} from "tiny-slider/src/tiny-slider";
//import animation lib
import AOS from 'aos';
import 'aos/dist/aos.css';
//import own custom scss
import '../scss/main.scss';
import '../css/app.css';

(function ($) {
    "use strict"; // Start of use strict

    // Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            let target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: (target.offset().top - 99)
                }, 1000, "easeInOutExpo");
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
        offset: 99
    });

    // Collapse Navbar
    const navbarCollapse = function () {
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

    AOS.init();
    AOS.refreshHard();  //optional

    const slider = tns({
        container: 'ul.slider',
        items: 17,
        gutter: 20,
        autoWidth: true,
        autoplay: true,
        edgePadding: 40,
        lazyload: true,
        speed: 800,
        height: 'auto',
        controlsPosition: 'bottom',
        arrowKeys: true,
        autoplayButtonOutput: false,

        responsive: {
            640: {
                edgePadding: 20,
                gutter: 20,
                items: 2
            },
            700: {
                gutter: 30
            },
            900: {
                items:4
            }
        }
    });


})(jQuery); // End of use strict








