/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
const $ = require('jquery');
global.$ = global.jQuery = $;

import '@popperjs/core';
require('bootstrap');

import '../node_modules/flowbite/dist/flowbite.min.js';

const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);

let nbLoad=1;
let scrollPos = 0;
const mainNav = document.getElementById('mainNav');
const headerHeight = mainNav.clientHeight;

// Get the button
const mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button

const scrollFunction = () => {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.classList.remove("hidden");
    } else {
        mybutton.classList.add("hidden");
    }
};
const backToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
};

// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

window.addEventListener("scroll", scrollFunction);
$(function() {
    $('.img_nogallery').on('click', function() {
        $('#imagemodal').attr('src', $(this).attr('src'));
        $('#imagemodal').addClass('bg-opacity-25');
        $('.modal').addClass('d-block');
    });
    $('#my_modal').on('click',function(){
        $('#imagemodal').removeClass('bg-opacity-25');
        $('.modal').removeClass('d-block');
    })
});

window.addEventListener('scroll', function() {
    const currentTop = document.body.getBoundingClientRect().top * -1;
    if ( currentTop < scrollPos) {
        // Scrolling Up
        if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
            mainNav.classList.add('is-visible');
        } else {
            mainNav.classList.remove('is-visible', 'is-fixed');
        }
    } else {
        // Scrolling Down
        mainNav.classList.remove(['is-visible']);
        if (currentTop > headerHeight && !mainNav.classList.contains('is-fixed')) {
            mainNav.classList.add('is-fixed');
        }
    }
    scrollPos = currentTop;
});


