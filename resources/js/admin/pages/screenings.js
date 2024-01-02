class Screenings {
    constructor() {
        this.filteredScreeningsBtn = document.querySelector('.open-filters-modal');
        this.screeningsModal = document.getElementById('filteredScreeningsModal');
        this.screeningsCloseModal = document.querySelector('.modal__close-btn');
        this.mainClass = document.querySelector('.admin-main');

        this.theatreSelect = document.getElementById('screeningsTheatreSelectAdd');

        this.deleteScreeningButton = document.querySelectorAll('.admin-container__table_last_cell_screenings_trash');

        this.timeZoneInput = document.querySelector('.admin-screenings__timezone-input');
        this.init();
    }

    init() {
        this.openFilteredScreeningsModal();
        this.closeFilteredScreeningsModal();
        this.deleteScreening();
        this.selectedTheatreAjax()
        this.setTimeZone();
    }

    selectedTheatreAjax() {
        this.theatreSelect?.addEventListener('change', () => {
            const url = this.theatreSelect.dataset.getHallUrl;
            const selectedValue = this.theatreSelect.value;
            const hallSelect = document.querySelector('.admin-screenings__item select[name="hall"]');
            if (selectedValue) {
                fetch(`${url}?theatreId=${selectedValue}`, {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                })
                    .then((response) => {

                        return response.json();
                    })
                    .then((resp) => {
                        if (resp.status) {
                            hallSelect.parentNode.classList.remove('admin-screenings__hidden');

                            hallSelect.innerHTML = '';
                            const option = document.createElement('option');
                            option.value = null;
                            option.textContent = 'Выберите зал';
                            option.disabled = true;
                            option.selected = true;
                            hallSelect.appendChild(option);

                            resp.halls.forEach(hall => {
                                const option = document.createElement('option');
                                option.value = hall.id;
                                option.textContent = hall.name;
                                hallSelect.appendChild(option);
                            });

                        } else {
                            hallSelect.innerHTML = '';
                            const option = document.createElement('option');
                            option.value = null;
                            option.textContent = 'Нет доступных залов';
                            hallSelect.appendChild(option);

                            console.log(resp.message);
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при выполнении запроса:', error);
                    });
            }
        });
    }

    deleteScreening() {
         this.deleteScreeningButton?.forEach(item => {
            item.addEventListener('click', (event) => {
                event.preventDefault(); // Preventing link from being followed

                const dateTime = event.currentTarget.getAttribute('data-screening-start');
                const theatreName = event.currentTarget.getAttribute('data-theatre-name');
                const hallName = event.currentTarget.getAttribute('data-hall-name');
                if (confirm(`Вы уверены, что хотите удалить сеанс кинотеатра ${theatreName}, в зале ${hallName} на ${dateTime}?`)) {

                    const form = event.currentTarget.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    }

    closeFilteredScreeningsModal() {
        this.screeningsCloseModal?.addEventListener('click', () => {
            this.screeningsModal?.classList.remove('modal__active');
            this.mainClass?.classList.remove('open-modal-overflow-hidden');
        });
    }

    openFilteredScreeningsModal() {
        this.filteredScreeningsBtn?.addEventListener('click', () => {
            this.screeningsModal?.classList.add('modal__active');
            this.mainClass.classList?.add('open-modal-overflow-hidden');
        });
    }

    setTimeZone() {
        if (this.timeZoneInput) {
            this.timeZoneInput.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
        }
    }
}

new Screenings();
