class Theatres {
    constructor() {
        this.addHallButton = document.querySelector('.open-add-hall-btn');
        this.addHallModal = document.getElementById('addHallModal');
        this.addHallCloseBtn = document.querySelector('.modal__close-btn');
        this.mainClass = document.querySelector('.admin-main');

        this.theatreImageInput = document.getElementById('theatreImageInput');
        this.previewTheatreContainer = document.getElementById('previewTheatreImage');

        this.modalSeatsContainer = document.querySelector('.modal__seats-container');
        this.addSeatsIcon = document.querySelector('.modal__add-seats-icon');

        this.init();
    }

    init() {
        this.openAddHallModal();
        this.closeBlockUserModal();
        this.previewTheatreImage();
        this.addNewSeatsBlock();

        this.addSeatsIcon && this.addSeatsIcon.addEventListener('click', () => this.addNewSeatsBlock());
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

    openAddHallModal() {
        this.addHallButton && this.addHallButton.addEventListener('click', (event) => {
            this.addHallModal && this.addHallModal.classList.add('modal__active');
            this.mainClass && this.mainClass.classList.add('open-modal-overflow-hidden');
        });
    }

    addNewSeatsBlock() {
        const newSeatsBlock = document.createElement('div');
        newSeatsBlock.classList.add('modal__seats');

        newSeatsBlock.innerHTML = `
             <div class="modal__seats-number">
                        <div class="modal__seats-number-left">
                            <div class="modal__seats-title">
                                Название:
                            </div>
                            <input type="text" name="seatsCount"
                                   required placeholder="Обычное">

                            <div class="modal__seats-title">
                                Описание
                            </div>
                            <textarea type="text" name="hallName"
                                      placeholder="Введите типа места"></textarea>
                        </div>
                        <div class="modal__seats-number-right">
                            <div class="modal__delete-seats-icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                     viewBox="0 0 32 32">
                                    <path
                                        d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
        `;

        this.modalSeatsContainer.appendChild(newSeatsBlock);

        // Добавим обработчик для удаления блока
        const deleteSeatsIcon = newSeatsBlock.querySelector('.modal__delete-seats-icon');
        deleteSeatsIcon && deleteSeatsIcon.addEventListener('click', () => this.deleteCurrentSeatsBlock(newSeatsBlock));
    }

    deleteCurrentSeatsBlock(seatsBlock) {
        this.seatsBlocks = document.querySelectorAll('.modal__seats');
        if (this.seatsBlocks.length > 1) {
            seatsBlock && seatsBlock.parentNode.removeChild(seatsBlock);
        }
    }

    closeBlockUserModal() {
        this.addHallCloseBtn && this.addHallCloseBtn.addEventListener('click', () => {
            this.addHallModal && this.addHallModal.classList.remove('modal__active');
            this.mainClass && this.mainClass.classList.remove('open-modal-overflow-hidden');
        });
    }
}

new Theatres();
