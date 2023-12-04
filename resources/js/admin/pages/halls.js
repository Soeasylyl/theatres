class Halls {
    constructor() {
        this.addRowBtn = document.querySelector('.admin-halls__add-row-btn');
        this.selectSeatsType = document.querySelector('.admin-halls__seats-type');
        this.inputSeatsCount = document.querySelector('.admin-halls__seats-count');

        this.rowContainer = document.querySelector('.admin-halls__rows')

        this.init();
    }

    init() {
        this.ajax();

    }

    ajax() {
        this.addRowBtn && this.addRowBtn.addEventListener('click', () => {
            if(this.inputSeatsCount.value > 35 || this.inputSeatsCount.value <= 0) {
                alert('Ошибка, нельзя вводить более 35 мест или меньше 1')

                return
            }

            const countRow = document.querySelectorAll('.admin-halls__row').length;

            fetch(`/admin/ajax/show-row-seats?seats_count=${this.inputSeatsCount.value}&seats_type=${this.selectSeatsType.value}&count_row=${countRow+1}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
        .then((response) => {
                return response.json();
            })
                .then((resp) => {
                    this.rowContainer && this.rowContainer.insertAdjacentHTML('beforeend', resp.html);
                });
        });
    }

}

new Halls();
