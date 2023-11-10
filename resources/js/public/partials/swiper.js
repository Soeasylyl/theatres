class homeSwiper {
    constructor() {
        this.init();
    }

    init() {
        this.swiperHero();
        this.swiperNowInCinema();
        this.swiperComingSoonCinema();
    }

    //Hero swiper
    swiperHero() {
        const swiper = new Swiper(".mySwiper", {
            spaceBetween: 0,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 3000,
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

    }

    //Posters swiper
    swiperNowInCinema() {
        const swiperPoster = new Swiper(".mySwiper-nowInCinema", {
            spaceBetween: 40,
            loop: true,

            effect: "coverflow",
            coverflowEffect: {
                rotate: 5,
                depth: 10,
                slideShadows: false,
            },
            slidesPerView: 1,
            breakpoints: {
                620: {
                    slidesPerView: 2,
                },
                800: {
                    slidesPerView: 3,
                },
                1000: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 5,
                },
                1600: {
                    slidesPerView: 6,
                },
                1900: {
                    slidesPerView: 7,
                },
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });


    }

    swiperComingSoonCinema() {
        const swiperPoster = new Swiper(".mySwiper-ComingSoon", {
            spaceBetween: 40,
            loop: true,

            effect: "coverflow",
            coverflowEffect: {
                rotate: 5,
                depth: 10,
                slideShadows: false,
            },
            slidesPerView: 1,
            breakpoints: {
                620: {
                    slidesPerView: 2,
                },
                800: {
                    slidesPerView: 3,
                },
                1000: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 5,
                },
                1600: {
                    slidesPerView: 6,
                },
                1900: {
                    slidesPerView: 7,
                },
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });


    }
}
new homeSwiper();
