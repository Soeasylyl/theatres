class homePage {
    constructor() {
        this.nowInCinemaSlider = document.querySelector('.now-in-cinema-slider');
        this.comingSoonSlider = document.querySelector('.coming-soon-slider');
        this.menuItems = document.querySelectorAll('.posters__menu-item');

        this.init();
    }

    init() {
        this.replaceSlider();
    }

    replaceSlider() {
        this.menuItems.forEach(item => {
            item.addEventListener('click', () => {
                if (!item.classList.contains('posters__menu-active')) {
                    this.menuItems.forEach(otherItem => {
                        otherItem.classList.remove('posters__menu-active');
                    });
                    item.classList.add('posters__menu-active');
                }

                if (!this.nowInCinemaSlider.classList.contains('swiper-hidden')) {
                    this.nowInCinemaSlider.classList.add('swiper-hidden');
                } else {
                    this.nowInCinemaSlider.classList.remove('swiper-hidden');
                }

                if (!this.comingSoonSlider.classList.contains('swiper-hidden')) {
                    this.comingSoonSlider.classList.add('swiper-hidden');
                } else {
                    this.comingSoonSlider.classList.remove('swiper-hidden');
                }
            });
        });
    }
}

new homePage();
