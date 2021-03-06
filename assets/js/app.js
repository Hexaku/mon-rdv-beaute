/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import bsCustomFileInput from 'bs-custom-file-input';

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Need jQuery? Install it with 'yarn add jquery', then uncomment to require it.
const $ = require('jquery');
require('bootstrap');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

$(document).ready(() => {
    bsCustomFileInput.init();
});
/* ANIMATION ICON BURGER */
const burgerElt = document.getElementById('burger');
const topbarMenuElt = document.getElementById('topbar-menu-mobile');

burgerElt.addEventListener('click', (e) => {
    topbarMenuElt.classList.toggle('no-show');
    burgerElt.classList.toggle('change');
});

/* STYLE CONNEXION */
const connexionElt = document.getElementById('connexion');
const topbarConnexionElt = document.getElementById('topbar-connexion-mobile');

connexionElt.addEventListener('click', (e) => {
    topbarConnexionElt.classList.toggle('no-show');
});
