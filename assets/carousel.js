import './styles/carousel.scss';
import Swiper from 'swiper';
import { Navigation, Pagination, Lazy, FreeMode } from 'swiper/modules';

Swiper.use([Navigation, Pagination, FreeMode, Lazy]);

console.log('swiper loaded')
new Swiper('.swiper', {
    // Optional parameters
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    freeMode: true,
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    loop: true,
    // Enable lazy loading
    lazy: {
        loadPrevNext: true,
        loadPrevNextAmount:3
    },

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
});