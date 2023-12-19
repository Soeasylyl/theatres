class Halls {
    constructor() {
        this.deleteHallBtn = document.querySelectorAll('.admin-theatres__delete-hall-icon');
        this.editHallCell = document.querySelectorAll('.admin-theatres__edit-halls');

        this.init();
    }

    init() {
        this.deleteHalls();
        this.openEditHallPage();
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

}

new Halls();
