class Halls {
    constructor() {
        this.addRowBtn = document.querySelector('.admin-halls__add-row-btn');
        this.selectSeatsType = document.querySelector('.admin-halls__seats-type');
        this.inputSeatsCount = document.querySelector('.admin-halls__seats-count');

        this.rowContainer = document.querySelector('.admin-halls__rows')
        this.deleteHallBtn = document.querySelectorAll('.admin-theatres__delete-hall-icon');
        this.editHallCell = document.querySelectorAll('.admin-theatres__edit-halls');

        this.init();
    }

    init() {
        this.ajax();
        this.deleteHalls();
        this.openEditHallPage();
        this.removeRows();
    }

    ajax() {
        this.addRowBtn && this.addRowBtn.addEventListener('click', () => {
            if (this.inputSeatsCount.value > 35 || this.inputSeatsCount.value <= 0) {
                alert('Ошибка, нельзя вводить более 35 мест или меньше 1')

                return
            }

            const countRow = document.querySelectorAll('.admin-halls__row').length;

            fetch(`/admin/ajax/show-row-seats?seats_count=${this.inputSeatsCount.value}&seats_type=${this.selectSeatsType.value}&count_row=${countRow + 1}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
                .then((response) => {
                    return response.json();
                })
                .then((resp) => {
                    console.log(this.rowContainer)
                    console.log(resp.html)
                    this.rowContainer && this.rowContainer.insertAdjacentHTML('beforeend', resp.html);
                });
        });
    }

    deleteHalls() {
        this.deleteHallBtn && this.deleteHallBtn.forEach(item => {
            item.addEventListener('click', (event) => {
                event.preventDefault();

                const hallName = event.currentTarget.getAttribute('data-hall-name');
                if (confirm(`Вы уверены, что хотите удалить зал: ${hallName}?`)) {

                    const form = event.currentTarget.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            })
        });
    }

    openEditHallPage() {
        this.editHallCell && this.editHallCell.forEach(item => {
            item.addEventListener('click', (event) => {
                if (!event.target.closest('.admin-theatres__delete-hall-icon')) {
                    event.preventDefault(); // Preventing link from being followed

                    const hallId = item.dataset.hallId;
                    const theatreId = item.dataset.theatreId;
                    if (hallId) {
                        window.location.href = `/admin/theatres/${theatreId}/hall/${hallId}`;
                    }
                }
            })
        })
    }

    removeRows() {

        window.addEventListener('click', (event) => {
            const target = event.target
            if (!target.closest('.admin-halls__remove-rows')) {
                return;
            }

            const parentLi = target.closest('.admin-halls__row');

            if (parentLi) {
                const isConfirmed = confirm("Вы уверены, что хотите удалить ряд?");

                if (isConfirmed) {
                    parentLi.remove();
                }
            }

            const rows = document.querySelectorAll('.admin-halls__row');

            rows && rows.forEach((row , index) => {
                const number = row.querySelector('.admin-halls__row-number');
                const numberRow = Number(index) + 1;
                number.textContent = numberRow;

                const inputs = row.querySelectorAll('input');
                inputs && inputs.forEach((input) => {
                    const inputName = input.name;

                    const regex = /\[(\d{1,3})\]/;
                    const match = inputName.match(regex);

                    if (match) {

                        const foundNumber = match[1];

                        const  resultInputName = inputName.replace(`rows[${foundNumber}]`, `rows[${numberRow}]`);

                        input.name = resultInputName;
                    }



                })

            })
        });

    }

}

new Halls();
