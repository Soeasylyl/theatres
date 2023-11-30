class Theatres {
    constructor() {
        this.addSeatTypeButton = document.querySelector('.open-add-seat-type-btn');
        this.addSeatTypeModal = document.getElementById('addSeatTypeModal');
        this.addSeatTypelCloseBtn = document.querySelector('.modal__close-btn');
        this.mainClass = document.querySelector('.admin-main');

        this.editSeatTypeCell = document.querySelectorAll('.admin-theatres__edit_theatres')
        this.editSeatTypeModal = document.getElementById('editSeatTypeModal');
        this.editSeatTypeCloseBtn = document.querySelector('.modal__close-edit-theatre-btn');

        this.theatreImageInput = document.getElementById('theatreImageInput');
        this.previewTheatreContainer = document.getElementById('previewTheatreImage');

        this.deleteSeatTypeButton = document.querySelectorAll('.admin-theatres__delete-seat-type-icon');
        this.deleteTheatreButton = document.querySelectorAll('.admin-container__table_last_cell_cinema_trash');

        this.init();
    }

    init() {
        this.openAddSeatTypeModal();
        this.closeBlockUserModal();
        this.previewTheatreImage();

        this.openEditSeatTypeModal();
        this.closeEditSeatTypeModal();

        this.deleteSeatType();
        this.deleteTheatre();
    }

    previewTheatreImage() {
        document.addEventListener('DOMContentLoaded', () => {
            this.theatreImageInput && this.theatreImageInput.addEventListener('change', () => {
                this.previewTheatreContainer.innerHTML = '';

                Array.from(this.theatreImageInput.files).forEach((file) => {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;

                        this.previewTheatreContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    }

    openAddSeatTypeModal() {
        this.addSeatTypeButton && this.addSeatTypeButton.addEventListener('click', (event) => {
            this.addSeatTypeModal && this.addSeatTypeModal.classList.add('modal__active');
            this.mainClass && this.mainClass.classList.add('open-modal-overflow-hidden');
        });
    }

    closeBlockUserModal() {
        this.addSeatTypelCloseBtn && this.addSeatTypelCloseBtn.addEventListener('click', () => {
            this.addSeatTypeModal && this.addSeatTypeModal.classList.remove('modal__active');
            this.mainClass && this.mainClass.classList.remove('open-modal-overflow-hidden');
        });
    }

    openEditSeatTypeModal() {
        this.editSeatTypeCell && this.editSeatTypeCell.forEach( item => {
            item.addEventListener('click', (event) => {
                if (!event.target.closest('.admin-theatres__delete-seat-type-icon')) {
                    event.preventDefault(); // Preventing link from being followed

                    const seatId = item.getAttribute('data-seat-type-id');
                    const name = item.querySelector('.admin-theatres__seat-type-name');
                    const description = item.querySelector('.admin-theatres__seat-type-description');
                    const amount = item.querySelector('.admin-theatres__seat-type-amount');

                    const idModal = this.editSeatTypeModal.querySelector('input[name = seat_id]')
                    const nameModal = this.editSeatTypeModal.querySelector('input[name = seat_name]');
                    const descriptionModal = this.editSeatTypeModal.querySelector('textarea[name = seat_description]');
                    const amountModal = this.editSeatTypeModal.querySelector('input[name = seat_amount]');

                    idModal.value = seatId;
                    nameModal.value = name.textContent;
                    descriptionModal.value = description.textContent;
                    amountModal.value = amount.textContent;

                    this.editSeatTypeModal && this.editSeatTypeModal.classList.add('modal__active');
                    this.mainClass && this.mainClass.classList.add('open-modal-overflow-hidden');
                }
            });
        });
    }

    closeEditSeatTypeModal() {
        this.editSeatTypeCloseBtn && this.editSeatTypeCloseBtn.addEventListener('click',()  => {
            this.editSeatTypeModal && this.editSeatTypeModal.classList.remove('modal__active');
            this.mainClass && this.mainClass.classList.remove('open-modal-overflow-hidden');
        });
    }

    deleteSeatType() {
        this.deleteSeatTypeButton && this.deleteSeatTypeButton.forEach(item => {
            item.addEventListener('click', (event) => {
                event.preventDefault(); // Preventing link from being followed

                const seatTypeName = event.currentTarget.getAttribute('data-seats-type-name'); // Getting the username
                if (confirm(`Вы уверены, что хотите удалить тип места: ${seatTypeName}?`)) {

                    const form = event.currentTarget.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    }

    deleteTheatre() {
        this.deleteTheatreButton && this.deleteTheatreButton.forEach(item => {
           item.addEventListener('click', (event) => {
               event.preventDefault(); // Preventing link from being followed

               const theatreName = event.currentTarget.getAttribute('data-theatre-name');
               if (confirm(`Вы уверены, что хотите удалить кинотеатр: ${theatreName}?`)) {

                   const form = event.currentTarget.closest('form');
                   if (form) {
                       form.submit();
                   }
               }
           }) ;
        });
    }
}

new Theatres();
