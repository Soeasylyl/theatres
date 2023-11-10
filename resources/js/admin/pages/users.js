class Users {
    constructor() {
        this.deleteUserButton = document.querySelectorAll('.admin-container__table_last_cell_trash');
        this.deleteProfileButton = document.getElementById('deleteProfileButton');
        this.blockUserButton = document.querySelectorAll('.page-wrapper__block-wrapper');
        this.blockModal = document.getElementById('blockModal');
        this.blockUserCloseBtn = document.querySelector('.modal__close-btn');
        this.searchUsersInput = document.querySelector('.admin-container__search-bar');
        this.searchUsersContainer = document.querySelector('.admin-container__table-search');

        this.init();
    }

    init() {
        this.deleteProfile();
        this.deleteUser();
        this.openBlockUserModal();
        this.closeBlockUserModal();
        this.searchUsers();
    }

    deleteUser() {
        this.deleteUserButton && this.deleteUserButton.forEach(item => {
            item.addEventListener('click', (event) => {
                event.preventDefault(); // Preventing link from being followed

                const user = event.currentTarget.getAttribute('data-username'); // Getting the username
                if (confirm(`Вы уверены, что хотите удалить пользователя ${user}?`)) {

                    const form = event.currentTarget.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    }

    closeBlockUserModal() {
        this.blockUserCloseBtn && this.blockUserCloseBtn.addEventListener('click', () =>
            this.blockModal && this.blockModal.classList.remove('modal__active')
        )
    }

    openBlockUserModal() {
        this.blockUserButton && this.blockUserButton.forEach(item => {
            item.addEventListener('click', (event) => {
                this.blockModal && this.blockModal.classList.add('modal__active');
            });
        });
    }

    deleteProfile() {
        this.deleteProfileButton && this.deleteProfileButton.addEventListener('click', (event) => {
                event.preventDefault();

            if (confirm(`Вы уверены, что хотите удалить свой профиль?`)) {

                const form = event.currentTarget.closest('form');
                if (form) {
                    form.submit();
                }
            }
            }
        )
    }

    searchUsers() {
        this.searchUsersInput && this.searchUsersInput.addEventListener('input', async () =>{
            const searchTerm = this.searchUsersInput.value.trim();
            const response = await fetch(`/admin/users/search?search=${searchTerm}`, {
                method: 'GET',
            })

            const resp = await response.json();
         this.searchUsersContainer.innerHTML = resp.htmlUsers;
        })
    }
}

new Users();
