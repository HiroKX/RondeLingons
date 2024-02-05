import './styles/carousel.scss';
import Swiper from 'swiper';
import { Navigation, Pagination, Lazy, EffectCoverflow } from 'swiper/modules';

Swiper.use([Navigation, Pagination, Lazy, EffectCoverflow]);

console.log('swiper loaded')
new Swiper('.swiper', {
    // Optional parameters
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    loop: true,
    preloadImages: false,
    // Enable lazy loading
    lazy: {
        loadPrevNext: true,
    },

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
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

