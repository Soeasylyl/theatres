class Users {
    constructor() {
        this.deleteUserButton = document.querySelectorAll('.admin-container__table_last_cell_trash');
        this.deleteProfileButton = document.getElementById('deleteProfileButton');

        this.init();
    }

    init() {
        this.deleteProfile();
        this.deleteUser();
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
}

new Users();
