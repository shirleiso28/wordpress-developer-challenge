var slideseries = new Swiper('.slide-series', {
    loop: true,
    slidesPerView: 2,
    spaceBetween: 30,

    breakpoints: {
        576: {
            slidesPerView: 3,
        },
        991: {
            slidesPerView: 7,
        },
    },

});