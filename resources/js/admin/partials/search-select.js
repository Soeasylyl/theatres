class SearchSelect {
    constructor() {
        this.selectBox = document.querySelector('.select__select-box');
        this.selectOption = document.querySelector('.select__select-option');
        this.soValue = document.querySelector('#screeningsSelectSoValue');
        this.optionSearch = document.querySelector('#screeningsSelectOptionsSearch');
        this.options = document.querySelector('.select__options');

        this.page = 1;
        this.lastPage = 2;
        this.loading = false;

        this.init();
    }

    init() {
        this.openCloseSelectMenu();
        this.closeSelectMenuOnOutsideClick();
        this.searchBySelect();

        this.getMoviesAjax();
        this.setupInfiniteScroll();
    }


    getMoviesAjax() {
        if (this.loading) {
            return;  // Если запрос уже выполняется, выходим из функции
        }

        const url = this.selectBox.dataset.moviesUrl;
        this.loading = true;

        fetch(`${url}?page=${this.page}`, {
            method: 'get',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => {

                return response.json();
            })
            .then((resp) => {
                if (
                    resp.status && resp.movies.last_page >= resp.movies.current_page
                ) {
                    this.populateMoviesOptions(resp.movies);
                    this.setSelectedValue();
                    this.page++;
                    this.lastPage = resp.movies.last_page;
                } else {
                    console.log(resp.message);
                }
            })
            .catch(error => {
                console.error('Ошибка при выполнении запроса:', error);
            })
            .finally(() => {
                this.loading = false;
            });
    }

    setupInfiniteScroll() {
        const optionsList = document.querySelector('.select__options');

        const scrollHandler = () => {
            const scrollTop = optionsList.scrollTop;
            const clientHeight = optionsList.clientHeight;
            const scrollHeight = optionsList.scrollHeight;

            if (scrollTop + clientHeight >= scrollHeight - 200) {
                this.getMoviesAjax();

                if (this.lastPage === this.page) {
                    optionsList.removeEventListener('scroll', scrollHandler);
                }
            }
        };

        // Добавляем обработчик события
        optionsList.addEventListener('scroll', scrollHandler);

        // Вызываем cleanup при выходе из объекта
        window.addEventListener('beforeunload', () => {
            optionsList.removeEventListener('scroll', scrollHandler);
        });
    }

    populateMoviesOptions(movies) {
        movies.data.forEach((movie) => {
            const li = document.createElement('li');
            const span = document.createElement('span');

            const date = new Date(movie.date_start);
            const formattedDate = `${
                ('0' + date.getDate()).slice(-2)} ${('0' + (date.getMonth() + 1)).slice(-2)} ${date.getFullYear()
            }`;

            span.setAttribute('data-movie-id', movie.id);
            span.textContent = `${movie.name} (${formattedDate})`;

            li.appendChild(span);
            this.options.appendChild(li);

            // Добавляем обработчик события для выбора фильма
            li.addEventListener('click', () => {
                this.soValue.value = `${movie.name} (${formattedDate})`;
                this.selectBox.classList.remove('active');
            });
        });
    }


    openCloseSelectMenu() {
        this.selectOption?.addEventListener('click', () => {
            this.selectBox?.classList.toggle('active');
            if (this.selectBox?.classList.contains('active')) {
                // this.getMoviesAjax();
            }
        })
    }

    closeSelectMenuOnOutsideClick() {
        document.addEventListener('click', (event) => {
            const isClickInside = this.selectBox?.contains(event.target);
            if (
                !isClickInside
                && this.selectBox?.classList.contains('active')
            ) {
                this.selectBox?.classList.remove('active');
            }
        });
    }

    setSelectedValue() {
        const optionsList = document.querySelectorAll('.select__options li');

        optionsList?.forEach(item => {
            item?.addEventListener('click', () => {
                this.soValue.value = item.querySelector('span').textContent;
                this.soValue.setAttribute(
                    'data-movie-id',
                    item.querySelector('span').getAttribute('data-movie-id')
                );

                this.selectBox?.classList.remove('active');
            })
        })
    }

    searchBySelect() {
        this.optionSearch?.addEventListener('keyup', () => {
            let filter, li, i, txtValue;
            filter = this.optionSearch.value.toUpperCase();
            li = this.options.getElementsByTagName('li');

            for (i = 0; i < li.length; i++) {
                txtValue = li[i].textContent || li[i].innerText;
                if (
                    txtValue.toUpperCase().indexOf(filter) > -1
                ) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        })
    }
}

new SearchSelect();

