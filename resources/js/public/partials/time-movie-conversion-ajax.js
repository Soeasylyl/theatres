class TimeMovieConversionAjax {
    constructor() {
        this.init();
    }

    init() {
        if (
            window.location.href.includes('/afisha/') && window.location.href.includes('/booking/')
        ) {
            this.getScreeningsTimeAjax();
        }
    }

    getScreeningsTimeAjax() {
        const timeContainer = document.querySelector('.booking__movie-time');
        const url = timeContainer.getAttribute('data-time-url');
        const notification = document.querySelector('.booking__notification');

        fetch(`${url}`, {
            method: 'get',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => {

                return response.json();
            })
            .then((resp) => {
                if (
                    resp.status === true
                ) {
                    const sessionStart = new Date(resp.sessionStart);
                    const sessionEnd = new Date(resp.sessionEnd);

                    const formattedStartTime = this.formatTime(sessionStart);
                    const formattedEndTime = this.formatTime(sessionEnd);

                    timeContainer.innerHTML = `
                    <span>${formattedStartTime}</span>
                    <span>&nbsp;-&nbsp;</span>
                    <span>${formattedEndTime}</span>
                `;
                    if (
                        sessionEnd.getDate() !== sessionStart.getDate()
                        || (sessionEnd.getHours() >= 23 || sessionEnd.getHours() < 8)
                    ) {
                        notification.classList.add('booking__active');
                    } else {
                        notification.classList.remove('booking__active');
                    }
                } else {
                    console.log(resp.error)
                }
            })
            .catch(error => {
                console.log('Error', error);
            })
    }
    formatTime(date) {
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }
}

new TimeMovieConversionAjax();
