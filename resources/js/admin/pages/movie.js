class Movie {
    constructor() {
        this.framesInput = document.getElementById('framesMovieInput');
        this.previewFramesContainer = document.getElementById('previewMovieFrames');
        this.posterInput = document.getElementById('posterMovieInput');
        this.previewPosterContainer = document.getElementById('previewMoviePoster');

        this.isMovieCreatePage = window.location.pathname === '/admin/movies/create';

        this.init();
    }

    init() {
        this.previewFramesImage()
        this.previewPosterImage()
        this.movieLocalStorage()
        this.clearLocalStoragePeriodically();
    }

    clearLocalStoragePeriodically() {
        setInterval(() => {
            localStorage.clear();
        }, 5 * 60 * 1000);
    }

    previewFramesImage() {
        document.addEventListener('DOMContentLoaded', () => {
            this.posterInput && this.posterInput.addEventListener('change', () => {
                this.previewPosterContainer.innerHTML = '';

                Array.from(this.posterInput.files).forEach((file) => {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;

                        this.previewPosterContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    }

    previewPosterImage() {
        document.addEventListener('DOMContentLoaded', () => {
            this.framesInput && this.framesInput.addEventListener('change', () => {
                this.previewFramesContainer.innerHTML = '';

                Array.from(this.framesInput.files).forEach((file) => {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;

                        this.previewFramesContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    }

    movieLocalStorage () {
        if  (this.isMovieCreatePage) {
            const inputs = document.querySelectorAll('input, textarea');

            inputs.forEach(input => {
                const key = `form_${input.name}`;

                if (input.type !== 'file') {
                    // При изменении значения сохраняем его в localStorage
                    input.addEventListener('change', () => {
                        if (input.type === 'datetime-local') {
                            localStorage.setItem(key, input.valueAsNumber.toString()); // преобразуем в строку
                        } else {
                            localStorage.setItem(key, input.value);
                        }
                    });

                    // Восстанавливаем значение при загрузке страницы
                    const storedValue = localStorage.getItem(key);
                    if (storedValue !== null) {
                        if (input.type === 'datetime-local') {
                            input.value = new Date(Number(storedValue)).toISOString().slice(0, 16); // преобразуем в дату
                        } else {
                            input.value = storedValue;
                        }
                    }
                }
            });
        }
    }
}

new Movie();
