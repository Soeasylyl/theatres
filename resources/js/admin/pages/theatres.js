class Theatres {
    constructor() {
        this.addSeatTypeButton = document.querySelector('.open-add-seat-type-btn');
        this.addSeatTypeModal = document.getElementById('addSeatTypeModal');
        this.addSeatTypelCloseBtn = document.querySelector('.modal__close-btn');
        this.mainClass = document.querySelector('.admin-main');

        this.theatreImageInput = document.getElementById('theatreImageInput');
        this.previewTheatreContainer = document.getElementById('previewTheatreImage');

        this.deleteSeatTypeButton = document.querySelectorAll('.admin-theatres__delete-icon');
        this.deleteTheatreButton = document.querySelectorAll('.admin-container__table_last_cell_cinema_trash');

        this.init();
    }

    init() {
        this.openAddSeatTypeModal();
        this.closeBlockUserModal();
        this.previewTheatreImage();
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
