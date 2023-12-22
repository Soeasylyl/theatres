class Notifications {
    constructor() {
        this.hideTimerGeneral = 3400;
        this.hideTimerOnClick = 250;
        this.init();
    }

    init() {
        this.dangers = document.querySelectorAll('.notifications-danger');
        this.warnings = document.querySelectorAll('.notifications-warning');
        this.successes = document.querySelectorAll('.notifications-success');

        this.hideNotifications(this.dangers, 'danger');
        this.hideNotifications(this.warnings, 'warning');
        this.hideNotifications(this.successes, 'success');
        this.hideNotificationsOnClick(this.dangers);
        this.hideNotificationsOnClick(this.warnings);
        this.hideNotificationsOnClick(this.successes);
    }

    hideNotifications(elements, type) {
        setTimeout(() => {
            elements.forEach((element) => {
                element.remove();
            });
        }, this.hideTimerGeneral);
    }

    hideNotificationsOnClick(elements) {
        elements.forEach((element) => {
            element.addEventListener('click', () => {
                element.style.opacity = '0';
                setTimeout(() => {
                    element.remove();
                }, this.hideTimerOnClick);
            });
        });
    }
}

new Notifications();
window.notifications = new Notifications();
