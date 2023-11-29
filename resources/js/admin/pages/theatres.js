class Theatres {
    constructor() {
        this.addHallButton = document.querySelector('.open-add-hall-btn');
        this.addHallModal = document.getElementById('addHallModal');
        this.addHallCloseBtn = document.querySelector('.modal__close-btn');
        this.mainClass = document.querySelector('.admin-main');

        this.theatreImageInput = document.getElementById('theatreImageInput');
        this.previewTheatreContainer = document.getElementById('previewTheatreImage');

        this.init();
    }

    init() {
        this.openAddHallModal();
        this.closeBlockUserModal();
        this.previewTheatreImage();
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

    closeBlockUserModal() {
        this.addHallCloseBtn && this.addHallCloseBtn.addEventListener('click', () => {
            this.addHallModal && this.addHallModal.classList.remove('modal__active');
            this.mainClass && this.mainClass.classList.remove('open-modal-overflow-hidden');
        });
    }
}

new Theatres();
