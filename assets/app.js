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

const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);

let nbLoad=1;
let scrollPos = 0;
const mainNav = document.getElementById('mainNav');
const headerHeight = mainNav.clientHeight;

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


$('#btn-load').click(loadArticle);

$('#selector-type').change(load)

let explicitData = {}
let reload=false;

function load(){
    if($('#selector-type option:checked') !== 'all'){
        explicitData.type=$('#selector-type option:checked').val()
    }
    else{
        explicitData = {}
    }
    nbLoad=0
    reload=true
    loadArticle()
}


function loadArticle() {
    explicitData.offset = nbLoad
    $.ajax({
        url: Routing.generate('ajax_article'),
        type: 'POST',
        async: true,
        data: explicitData,
        success: function (dataReturned, status) {
            if (reload) {
                $('#containerArticle').html(dataReturned);
                reload=false;
            } else {
                $('#containerArticle').append(dataReturned);
            }
            nbLoad++;
        },
        error: function (xhr, textStatus, errorThrown) {
            console.error('Erreur de chargement...');
        }
    });
}


