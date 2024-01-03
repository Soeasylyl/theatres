class PublicMovie {
    constructor() {
        this.movieSelectHeaderForTheatre = document.querySelector('#movieSelectHeaderForTheatre');
        this.movieSelectBodyForTheatre = document.querySelector('#movieSelectBodyForTheatre');
        this.movieSvgArrowForTheatre = document.querySelector('#svgIconRoundArrow');
        this.movieTheatreName = document.querySelector('.movie__select-theatre-name');

        this.init();
    }

    init() {
        this.openCloseTheatresSelect();
        this.selectTheatreOption();
        this.closeSelectMenuOnOutsideClick();
    }

    openCloseTheatresSelect() {
        this.movieSelectHeaderForTheatre?.addEventListener('click', () => {
            this.movieSelectBodyForTheatre?.classList.toggle('movie__hidden');
            this.movieSvgArrowForTheatre?.classList.toggle('movie__svg-rotate');
        });
    }


    selectTheatreOption() {
        const theatreOptions = document.querySelectorAll('.movie__select-theatre-options');

        theatreOptions?.forEach((option) => {
            option.addEventListener('click', (event) => {
                theatreOptions?.forEach((opt) => opt.classList.remove('movie__theatre-selected'));
                option?.classList.add('movie__theatre-selected');

                const theatreNameElement = option.querySelector('.movie__select-theatre-options-name');
                this.movieTheatreName.textContent = theatreNameElement ? theatreNameElement.textContent.trim() : '';
            });
        });
    }

    closeSelectMenuOnOutsideClick() {
        document.addEventListener('click', (event) => {
            const isClickInsideSelect = this.movieSelectHeaderForTheatre?.contains(event.target) || this.movieSelectBodyForTheatre?.contains(event.target);

            if (!isClickInsideSelect) {
                this.movieSelectBodyForTheatre?.classList.add('movie__hidden');
                this.movieSvgArrowForTheatre?.classList.remove('movie__svg-rotate');
            }
        });
    }
}

new PublicMovie();
