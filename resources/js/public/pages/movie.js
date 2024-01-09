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

        this.timeZoneInput = document.querySelector('.movie__timezone-input');

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

        this.setTimeZone();
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

                this.removeTheatreSelect();

                this.filteredScreeningsAjax();
            });
        });
    }

    removeTheatreSelect() {
        this.movieSelectBodyForTheatre?.classList.add('movie__hidden');
        this.movieSvgArrowForTheatre?.classList.remove('movie__svg-rotate');
    }

    removeDateSelect() {
        this.movieSelectBodyForDate?.classList.add('movie__hidden');
        this.movieSvgArrowForDate?.classList.remove('movie__svg-rotate');
    }

    removeTimeSelect() {
        this.movieSelectBodyForTime?.classList.add('movie__hidden');
        this.movieSvgArrowForTime?.classList.remove('movie__svg-rotate');
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
                this.removeTheatreSelect();
            }

            if (!isClickInsideDateSelect) {
                this.removeDateSelect();
            }

            if (!isClickInsideTimeSelect) {
                this.removeTimeSelect();
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
        if (this.movieDateName) {
            const currentDate = new Date();
            const options = {day: 'numeric', month: 'long'};
            const formattedDate = currentDate.toLocaleDateString('ru-RU', options);

            this.movieDateName.textContent = `Сегодня, ${formattedDate}`;
        }
    }

    displayNextSevenDays() {
        if (this.movieSelectBodyForDate) {
            const options = {day: 'numeric', month: 'long'};
            const dateOptions = {weekday: 'long', day: 'numeric', month: 'long'};
            const today = new Date();

            for (let i = 0; i < 7; i++) {
                const currentDate = new Date(today);
                currentDate.setDate(today.getDate() + i);
                const formattedDate = currentDate.toLocaleDateString('ru-RU', i === 0 ? options : dateOptions);

                const dateOption = document.createElement('div');
                dateOption.classList.add('movie__select-date-options');
                dateOption.setAttribute('data-date', currentDate.toISOString().split('T')[0]);

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
    }

    selectDateOption() {
        const dateOptions = document.querySelectorAll('.movie__select-date-options');

        dateOptions?.forEach((option) => {
            option.addEventListener('click', (event) => {
                dateOptions?.forEach((opt) => opt.classList.remove('movie__date-selected'));
                option?.classList.add('movie__date-selected');

                const dateNameElement = option.querySelector('.movie__select-date-options-name');
                this.movieDateName.textContent = dateNameElement ? dateNameElement.textContent.trim() : '';

                this.removeDateSelect();
                this.filteredScreeningsAjax();
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

                this.removeTimeSelect();

                this.filteredScreeningsAjax();
            });
        });
    }

    filteredScreeningsAjax() {
        const url = document.querySelector('.movie__header').getAttribute('data-url');
        const htmlContainer = document.querySelector('.movie__left-column-theatre-template-wrapper');
        const theatreId = document.querySelector('.movie__theatre-selected').dataset.theatreId;
        const date = document.querySelector('.movie__date-selected').dataset.date;
        const {startTime, endTime} = document.querySelector('.movie__time-selected').dataset;

        console.log(theatreId, date, startTime, endTime )
        fetch(`
                    ${url}?theatre_id=${theatreId}
                    &date=${date}
                    &timeZone=${this.timeZoneInput.value}
                    &startTime=${startTime}
                    &endTime=${endTime}
                     `, {
            method: 'get',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => {

                return response.json();
            })
            .then((resp) => {
                htmlContainer.innerHTML = resp.htmlClients;
                const cards = document.querySelectorAll('.movie__left-column-theatre');
                cards.forEach((card) => {
                    card.classList.add('movie__loading');
                })
                // this.setTimeZone();

                setTimeout(function () {
                    cards.forEach((card) => {
                        card.classList.remove('movie__loading');
                    })
                }, 100);
            })
            .catch(error => {
                console.log('Error', error);
            })
    }

    setTimeZone() {
        const screeningTime = document.querySelectorAll('.movie__screening-time');
        const clientTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        if (screeningTime) {
            this.timeZoneInput.value = clientTimezone;

            screeningTime?.forEach(function (element) {
                const utcTimeString = element.textContent;

                // Создаем объект Date с явным указанием, что время в UTC
                const utcTime = new Date(utcTimeString + ' UTC');

                const clientTime = new Date(utcTime.toLocaleString(
                    'en-US', {timeZone: clientTimezone}
                ));

                element.textContent = clientTime.toLocaleString('en-US', {
                    timeZone: clientTimezone,
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit'
                });
            });
        }
    }

}

new PublicMovie();
