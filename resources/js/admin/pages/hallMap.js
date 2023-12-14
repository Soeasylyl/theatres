class HallMap {
    constructor() {
        this.addHallMapButton = document.querySelector('.add-hall-map');
        this.previewHallMapContainer = document.querySelector('.admin-halls__preview-map');

        this.init();
    }

    init() {
        this.addEventListeners();
    }

    addEventListeners() {
        this.addHallMapButton && this.addHallMapButton.addEventListener('click', () => {
            this.addHallMap();
        });

        this.previewHallMapContainer && this.previewHallMapContainer.addEventListener('click', (event) => {
            const closeButton = this.previewHallMapContainer.querySelector('.admin-halls__close-button');
            if (event.target === closeButton) {
                this.removeHallMap();
            }
        });
    }

    addHallMap() {
        const isMapVisible = this.previewHallMapContainer.classList.contains('fade-in');

        if (!isMapVisible) {
            this.previewHallMapContainer.innerHTML = '';

            // SVG-код для добавления
            const svgCode = `
            <svg width="1000" height="1000" class="sc-cAJUJo cBTvCJ" id="scheme">
              <path d="M20,20 Q 475 5, 950 20" class="sc-ccXozh ibOKzl"></path>
              <text text-anchor="middle" x="50%" dy="10%" fill="currentColor" font-family="Ubuntu, Roboto, Arial, Helvetica, sans-serif" font-size="36" font-weight="700" class="sc-bsVVwV hWBiPl">Экран
              </text>
            </svg>
        `;
            this.previewHallMapContainer.innerHTML = svgCode;

            this.addBorderToMap();
            this.addCloseButton();

            this.scrollToBottom();

            this.previewHallMapContainer.classList.add('fade-in');
        }
    }


    scrollToBottom() {
        const scrollHeight = document.documentElement.scrollHeight;
        const scrollStep = Math.PI / (500 / 15); // 15 - время анимации в миллисекундах
        let count = 0, currPos = 0;

        const animateScroll = () => {
            if (currPos < scrollHeight && currPos + window.innerHeight + 100 < scrollHeight) {
                document.documentElement.scrollTop = currPos + Math.PI * count;
                currPos = document.documentElement.scrollTop;
                count += scrollStep;

                requestAnimationFrame(animateScroll);
            }
        };

        animateScroll();
    }




    removeHallMap() {
        this.previewHallMapContainer.classList.remove('fade-in');

        this.previewHallMapContainer.innerHTML = '';
        this.previewHallMapContainer && this.previewHallMapContainer.classList.remove('admin-halls__border-map');
        this.removeCloseButton();

    }

    addBorderToMap() {
        this.previewHallMapContainer && this.previewHallMapContainer.classList.toggle('admin-halls__border-map', true);
    }

    addCloseButton() {
        const existingButton = this.previewHallMapContainer.querySelector('.admin-halls__close-button');

        if (!existingButton) {
            const closeButton = document.createElement('span');
            closeButton.className = 'admin-halls__close-button';
            closeButton.innerText = '×';

            this.previewHallMapContainer.appendChild(closeButton);

            closeButton.addEventListener('click', () => {
                this.removeHallMap();
            });
        }
    }

    removeCloseButton() {
        const existingButton = this.previewHallMapContainer.querySelector('.admin-halls__close-button');

        if (existingButton) {
            existingButton.remove();
        }
    }
}

new HallMap();
