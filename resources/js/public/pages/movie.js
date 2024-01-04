class PublicMovie {
    constructor() {
        this.movieSelectHeaderForTheatre = document.querySelector('#movieSelectHeaderForTheatre');
        this.movieSelectBodyForTheatre = document.querySelector('#movieSelectBodyForTheatre');
        this.movieSvgArrowForTheatre = document.querySelector('#svgIconRoundArrowTheatre');
        this.movieTheatreName = document.querySelector('.movie__select-theatre-name');

        this.movieSelectHeaderForDate = document.querySelector('#movieSelectHeaderForDate');
        this.movieSelectBodyForDate = document.querySelector('#movieSelectBodyForDate');
        this.movieSvgArrowForDate = document.querySelector('#svgIconRoundArrowDate');
        this.movieDateName = document.querySelector('.movie__select-date-name');

        this.movieSelectHeaderForTime = document.querySelector('#movieSelectHeaderForTime');
        this.movieSelectBodyForTime = document.querySelector('#movieSelectBodyForTime');
        this.movieSvgArrowForTime = document.querySelector('#svgIconRoundArrowTime');
        this.movieTimeName = document.querySelector('.movie__select-time-name');

        this.init();
    }

    init() {
        this.openCloseTheatresSelect();
        this.selectTheatreOption();
        this.closeSelectMenuOnOutsideClick();

        this.openCloseDateSelect();
        this.displayCurrentDate();
        this.displayNextSevenDays();
        this.selectDateOption();

        this.openCloseTimeSelect();
        this.selectTimeOption();
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
            const isClickInsideTheatreSelect = this.movieSelectHeaderForTheatre?.contains(event.target)
                || this.movieSelectBodyForTheatre?.contains(event.target);
            const isClickInsideDateSelect = this.movieSelectHeaderForDate?.contains(event.target)
                || this.movieSelectBodyForDate?.contains(event.target);
            const isClickInsideTimeSelect = this.movieSelectHeaderForTime?.contains(event.target)
                || this.movieSelectBodyForTime?.contains(event.target);

            if (!isClickInsideTheatreSelect) {
                this.movieSelectBodyForTheatre?.classList.add('movie__hidden');
                this.movieSvgArrowForTheatre?.classList.remove('movie__svg-rotate');
            }

            if (!isClickInsideDateSelect) {
                this.movieSelectBodyForDate?.classList.add('movie__hidden');
                this.movieSvgArrowForDate?.classList.remove('movie__svg-rotate');
            }

            if (!isClickInsideTimeSelect) {
                this.movieSelectBodyForTime?.classList.add('movie__hidden');
                this.movieSvgArrowForTime?.classList.remove('movie__svg-rotate');
            }
        });
    }

    openCloseDateSelect() {
        this.movieSelectHeaderForDate?.addEventListener('click', () => {
            this.movieSelectBodyForDate?.classList.toggle('movie__hidden');
            this.movieSvgArrowForDate?.classList.toggle('movie__svg-rotate');
        });
    }

    displayCurrentDate() {
        const currentDate = new Date();
        const options = {day: 'numeric', month: 'long'};
        const formattedDate = currentDate.toLocaleDateString('ru-RU', options);

        this.movieDateName.textContent = `Сегодня, ${formattedDate}`;
    }

    displayNextSevenDays() {
        const options = {day: 'numeric', month: 'long'};
        const dateOptions = {weekday: 'long', day: 'numeric', month: 'long'};
        const today = new Date();

        for (let i = 0; i < 7; i++) {
            const currentDate = new Date(today);
            currentDate.setDate(today.getDate() + i);
            const formattedDate = currentDate.toLocaleDateString('ru-RU', i === 0 ? options : dateOptions);

            const dateOption = document.createElement('div');
            dateOption.classList.add('movie__select-date-options');

            if (i === 0) {
                dateOption.classList.add('movie__date-selected');
            }

            const dateName = document.createElement('div');
            dateName.classList.add('movie__select-date-options-name');
            dateName.textContent = i === 0 ? `Сегодня, ${formattedDate}` : formattedDate;

            dateOption.appendChild(dateName);
            this.movieSelectBodyForDate.appendChild(dateOption);
        }
    }

    selectDateOption() {
        const dateOptions = document.querySelectorAll('.movie__select-date-options');

        dateOptions?.forEach((option) => {
            option.addEventListener('click', (event) => {
                dateOptions?.forEach((opt) => opt.classList.remove('movie__date-selected'));
                option?.classList.add('movie__date-selected');

                const dateNameElement = option.querySelector('.movie__select-date-options-name');
                this.movieDateName.textContent = dateNameElement ? dateNameElement.textContent.trim() : '';
            });
        });
    }

    openCloseTimeSelect() {
        this.movieSelectHeaderForTime?.addEventListener('click', () => {
            this.movieSelectBodyForTime?.classList.toggle('movie__hidden');
            this.movieSvgArrowForTime?.classList.toggle('movie__svg-rotate');
        });
    }

    selectTimeOption() {
        const timeOptions = document.querySelectorAll('.movie__select-time-options');

        timeOptions?.forEach((option) => {
            option.addEventListener('click', (event) => {
                timeOptions?.forEach((opt) => opt.classList.remove('movie__time-selected'));
                option?.classList.add('movie__time-selected');

                const timeNameElement = option.querySelector('.movie__select-time-options-name');
                this.movieTimeName.textContent = timeNameElement ? timeNameElement.textContent.trim() : '';
            });
        });
    }

}

new PublicMovie();
