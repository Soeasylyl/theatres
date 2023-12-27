class Screenings {
    constructor() {
        this.filteredScreeningsBtn = document.querySelector('.open-filters-modal');
        this.screeningsModal = document.getElementById('filteredScreeningsModal');
        this.screeningsCloseModal = document.querySelector('.modal__close-btn');
        this.mainClass = document.querySelector('.admin-main');


        // this.deleteUserButton = document.querySelectorAll('.admin-container__table_last_cell_trash');
        // this.deleteProfileButton = document.getElementById('deleteProfileButton');
        // this.blockUserButton = document.querySelectorAll('.page-wrapper__block-wrapper');
        // this.timeZoneInput = document.getElementById('timezone');
        this.init();
    }

    init() {
        this.openFilteredScreeningsModal();
        this.closeFilteredScreeningsModal();
        // this.deleteProfile();
        // this.deleteUser();
        // this.setTimeZone();
    }

    // deleteUser() {
    //     this.deleteUserButton && this.deleteUserButton.forEach(item => {
    //         item.addEventListener('click', (event) => {
    //             event.preventDefault(); // Preventing link from being followed
    //
    //             const user = event.currentTarget.getAttribute('data-username'); // Getting the username
    //             if (confirm(`Вы уверены, что хотите удалить пользователя ${user}?`)) {
    //
    //                 const form = event.currentTarget.closest('form');
    //                 if (form) {
    //                     form.submit();
    //                 }
    //             }
    //         });
    //     });
    // }

    closeFilteredScreeningsModal() {
        this.screeningsCloseModal?.addEventListener('click', () => {
            this.screeningsModal?.classList.remove('modal__active');
            this.mainClass?.classList.remove('open-modal-overflow-hidden');
        });
    }

    openFilteredScreeningsModal() {
        this.filteredScreeningsBtn?.addEventListener('click', (event) => {
            this.screeningsModal?.classList.add('modal__active');
            this.mainClass.classList?.add('open-modal-overflow-hidden');
        });

    }

    // deleteProfile() {
    //     this.deleteProfileButton && this.deleteProfileButton.addEventListener('click', (event) => {
    //             event.preventDefault();
    //
    //             if (confirm(`Вы уверены, что хотите удалить свой профиль?`)) {
    //
    //                 const form = event.currentTarget.closest('form');
    //                 if (form) {
    //                     form.submit();
    //                 }
    //             }
    //         }
    //     )
    // }

    // setTimeZone() {
    //     if (this.timeZoneInput) {
    //         this.timeZoneInput.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
    //     }
    // }
}

new Screenings();
