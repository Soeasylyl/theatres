const swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,
    autoplay: {
        delay: 300000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

const swiperPoster = new Swiper(".mySwiper-posters", {
    spaceBetween: 40,
    centeredSlides: true,
    loop: true,
    slidesPerView: "auto",
    slidesOffsetBefore: 30, // Сдвиг первой карточки
    slidesOffsetAfter: 30,
    // autoplay: {
    //     delay: 3000,
    //     disableOnInteraction: false,
    // },
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true,
    // },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
