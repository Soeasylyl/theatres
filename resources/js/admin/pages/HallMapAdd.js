class HallMapAdd {
    constructor() {
        this.addHallMapButton = document.querySelector('.add-hall-map');
        this.previewHallMapContainer = document.querySelector('.admin-halls__preview-map');
        this.seatsWrapperContainer = document.querySelector('.admin-halls__seats-wrapper');
        this.addSeatsToMapButton = document.querySelector('.admin-halls__add-seat-btn');

        this.draggedElement = null;

        this.init();
    }

    init() {
        this.addSeatToMapContainer();
        this.closePreviewMapContainer();
        this.addDragEventListeners();
    }

    handleDragStart(event) {
        this.draggedElement = null;
        const target = event.target.closest('svg');
        if (target && target.parentNode === this.gElement) {
            this.draggedElement = target;
            const point = this.getEventPoint(event);
            const svgPoint = this.getSVGPoint(this.draggedElement);
            this.offsetX = svgPoint.x - point.x;
            this.offsetY = svgPoint.y - point.y;
            this.draggedElement.style.cursor = 'grabbing';
        }
    }

    getSVGPoint(element) {
        const x = parseFloat(element.getAttributeNS(null, 'x'));
        const y = parseFloat(element.getAttributeNS(null, 'y'));
        return {x, y};
    }


    getEventPoint(event) {
        const svgPoint = this.gElement.ownerSVGElement.createSVGPoint();
        svgPoint.x = event.clientX;
        svgPoint.y = event.clientY;
        return svgPoint.matrixTransform(this.gElement.getScreenCTM().inverse());
    }

    handleDragEnd() {
        if (this.draggedElement) {
            this.draggedElement.style.cursor = 'grab';
            this.draggedElement = null;
        }
    }

    handleDrag(event) {
        if (this.draggedElement) {
            const point = this.getEventPoint(event);
            const dx = point.x + this.offsetX;
            const dy = point.y + this.offsetY;

            this.draggedElement.setAttributeNS(null, 'x', dx);
            this.draggedElement.setAttributeNS(null, 'y', dy);

            const posXInput = this.previewHallMapContainer.querySelector(`input[name="rows[${this.draggedElement.dataset.numberRow}][${this.draggedElement.dataset.numberSeat}][posX]"]`);
            const posYInput = this.previewHallMapContainer.querySelector(`input[name="rows[${this.draggedElement.dataset.numberRow}][${this.draggedElement.dataset.numberSeat}][posY]"]`);

            if (posXInput && posYInput) {
                posXInput.value = dx;
                posYInput.value = dy;
            }
        }
    }


    addDragEventListeners() {
        document.addEventListener('mousedown', this.handleDragStart.bind(this));
        document.addEventListener('mouseup', this.handleDragEnd.bind(this));
        document.addEventListener('mousemove', this.handleDrag.bind(this));
    }

    findGElementInMap() {
        const mapContainer = document.querySelector('.admin-halls__map');
        this.gElement = mapContainer.querySelector('g');
        this.scalableGroup = document.getElementById('scalableGroup');
        this.scaleSlider = document.getElementById('scaleSlider');

        if (!this.gElement) {
            this.gElement = document.createElementNS('http://www.w3.org/2000/svg', 'g');
            mapContainer.appendChild(this.gElement);
        }

        this.handleScaleChange();
    }

    addSeatToMapContainer() {
        this.addSeatsToMapButton && this.addSeatsToMapButton.addEventListener('click', () => {
            const numberSeatInput = this.seatsWrapperContainer.querySelector('input[name="number_seat"]');

            if (!numberSeatInput.value.trim()) {
                alert('Пожалуйста, введите номер места.');
                return; // Прерываем выполнение функции, если значение отсутствует
            }

            this.findGElementInMap();
            const svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svgElement.setAttribute('x', '650');
            svgElement.setAttribute('y', '125');
            svgElement.setAttribute('width', '80');
            svgElement.setAttribute('height', '86');
            svgElement.setAttribute('type', 'recliner');

            //Получение номера ряда и типа места для добавления в svg
            const numberRowInput = this.seatsWrapperContainer.querySelector('input[name="number_row"]');
            const dataSeatTypeInput = this.seatsWrapperContainer.querySelector('select[name="seats_type"]');
            const selectedSeatType = dataSeatTypeInput ? dataSeatTypeInput.value : '';
            const selectedSeatName = dataSeatTypeInput ? dataSeatTypeInput.options[dataSeatTypeInput.selectedIndex].text : '';

            // Создаем новый скрытый инпут для номера места
            const seatNumberInput = document.createElement('input');
            seatNumberInput.type = 'hidden';
            seatNumberInput.name = `rows[${numberRowInput.value}][${numberSeatInput.value}][seatNumber]`;
            seatNumberInput.value = numberSeatInput.value;

            // Создаем новый скрытый инпут для типа места
            const seatsTypeIdInput = document.createElement('input');
            seatsTypeIdInput.type = 'hidden';
            seatsTypeIdInput.name = `rows[${numberRowInput.value}][${numberSeatInput.value}][seatsTypeId]`;
            seatsTypeIdInput.value = selectedSeatType;

            // Создаем новый скрытый инпут для posX
            const posXInput = document.createElement('input');
            posXInput.type = 'hidden';
            posXInput.name = `rows[${numberRowInput.value}][${numberSeatInput.value}][posX]`;
            posXInput.value = svgElement.getAttributeNS(null, 'x');

            // Создаем новый скрытый инпут для posY
            const posYInput = document.createElement('input');
            posYInput.type = 'hidden';
            posYInput.name = `rows[${numberRowInput.value}][${numberSeatInput.value}][posY]`;
            posYInput.value = svgElement.getAttributeNS(null, 'y');

            // Устанавливаем значения номера ряда и места в атрибуты data
            svgElement.setAttribute('data-number-row', numberRowInput.value);
            svgElement.setAttribute('data-number-seat', numberSeatInput.value);

            // Добавляем новые инпуты в форму
            this.previewHallMapContainer.appendChild(seatNumberInput);
            this.previewHallMapContainer.appendChild(seatsTypeIdInput);
            this.previewHallMapContainer.appendChild(posXInput);
            this.previewHallMapContainer.appendChild(posYInput);

            svgElement.setAttribute('data-seat-type', selectedSeatType);
            svgElement.setAttribute('data-number-row', numberRowInput.value);

            const titleElement = document.createElementNS('http://www.w3.org/2000/svg', 'title');
            titleElement.textContent = `Номер ряда: ${numberRowInput.value}, Тип места: ${selectedSeatName}`;

            // Create the text element
            const textElement = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            textElement.setAttribute('x', '50%');
            textElement.setAttribute('y', '50%');
            textElement.setAttribute('dy', '0.35em');
            textElement.setAttribute('text-anchor', 'middle');
            textElement.setAttribute('font-size', '20');
            textElement.setAttribute('fill', 'white');

            textElement.textContent = numberSeatInput ? numberSeatInput.value : '';

            const pathElement1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement1.setAttribute('d', 'M18.38,46.15V71.06H55.85V46.15a7.83,7.83,0,0,1,7.82-7.82V33.26A9.67,9.67,0,0,0,61,26.53a8.37,8.37,0,0,1-4.37,1.24H23.42v1a7.65,7.65,0,0,1-7.64,7.64H10.55v1.89h0A7.83,7.83,0,0,1,18.38,46.15Z');
            svgElement.appendChild(pathElement1);

            const pathElement2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement2.setAttribute('d', 'M23.42,18.34v5.23H54a9.67,9.67,0,0,1,4.81,1.27,5.83,5.83,0,0,0,3.64-5.4v-11a5.85,5.85,0,0,0-5.84-5.84H17.64A5.85,5.85,0,0,0,11.8,8.46v2.23h4A7.65,7.65,0,0,1,23.42,18.34Z');
            svgElement.appendChild(pathElement2);

            const pathElement3 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement3.setAttribute('d', 'M23.42,23.57v1.7H56.58a5.75,5.75,0,0,0,2.2-.43A9.67,9.67,0,0,0,54,23.57Z');
            svgElement.appendChild(pathElement3);

            const pathElement4 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement4.setAttribute('d', 'M5.22,46.15V78.88a5.33,5.33,0,0,0,5.33,5.33H63.67A5.33,5.33,0,0,0,69,78.88V46.15a5.33,5.33,0,0,0-5.33-5.32h0V65.77a9.7,9.7,0,0,1-9.7,9.7H20.25a9.7,9.7,0,0,1-9.7-9.7V40.83A5.33,5.33,0,0,0,5.22,46.15Z');
            svgElement.appendChild(pathElement4);

            const pathElement5 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement5.setAttribute('d', 'M20.25,75.47H54a9.7,9.7,0,0,0,9.7-9.7V40.83a5.33,5.33,0,0,0-5.32,5.32V73.56H15.88V46.15a5.33,5.33,0,0,0-5.33-5.32h0V65.77A9.7,9.7,0,0,0,20.25,75.47Z');
            svgElement.appendChild(pathElement5);

            const pathElement6 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement6.setAttribute('d', 'M13.28,26.53a8.34,8.34,0,0,1-4-7.09V13.19h-4A5.15,5.15,0,0,0,.18,18.34V28.8a5.14,5.14,0,0,0,5.14,5.14h5.23v-.68A9.64,9.64,0,0,1,13.28,26.53Z');
            svgElement.appendChild(pathElement6);

            const pathElement7 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement7.setAttribute('d', 'M15.45,24.84a9.61,9.61,0,0,1,4.8-1.27h.67V18.34a5.15,5.15,0,0,0-5.14-5.15h-4v6.25A5.83,5.83,0,0,0,15.45,24.84Z');
            svgElement.appendChild(pathElement7);

            const pathElement8 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement8.setAttribute('d', 'M20.25,23.57a9.61,9.61,0,0,0-4.8,1.27,5.66,5.66,0,0,0,2.19.43h3.28v-1.7Z');
            svgElement.appendChild(pathElement8);

            const pathElement9 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement9.setAttribute('d', 'M13.28,26.53a9.91,9.91,0,0,1,1-.87,7.09,7.09,0,0,1-3.69-6.22V13.19H9.3v6.25A8.34,8.34,0,0,0,13.28,26.53Z');
            svgElement.appendChild(pathElement9);

            const pathElement10 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement10.setAttribute('d', 'M14.24,25.66a9.91,9.91,0,0,0-1,.87,8.3,8.3,0,0,0,4.36,1.24h3.28V26.52H17.64A7.09,7.09,0,0,1,14.24,25.66Z');
            svgElement.appendChild(pathElement10);

            const pathElement11 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement11.setAttribute('d', 'M14.24,25.66a10.27,10.27,0,0,1,1.21-.82,5.83,5.83,0,0,1-3.65-5.4V13.19H10.55v6.25A7.09,7.09,0,0,0,14.24,25.66Z');
            svgElement.appendChild(pathElement11);

            const pathElement12 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            pathElement12.setAttribute('d', 'M17.64,25.27a5.66,5.66,0,0,1-2.19-.43,10.27,10.27,0,0,0-1.21.82,7.09,7.09,0,0,0,3.4.86h3.28V25.27Z');
            svgElement.appendChild(pathElement12);

            svgElement.appendChild(titleElement);
            svgElement.appendChild(textElement);
            this.gElement.appendChild(svgElement);

            const numberSeatInputClear = this.seatsWrapperContainer.querySelector('input[name="number_seat"]');

            if (numberSeatInputClear) {
                numberSeatInputClear.value = ''; // Очищаем только инпут с именем "number_seat"
            }
        })
    }


    closePreviewMapContainer() {
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

            this.previewHallMapContainer.innerHTML = `
            <svg width="1000" height="1000" class="admin-halls__map" >
              <path d="M20,20 Q 475 5, 950 20" class="sc-ccXozh ibOKzl"></path>
               <g id="scalableGroup" transform="scale(0.7)">
               </g>
              <text text-anchor="middle" x="50%" dy="10%" fill="currentColor" font-family="Ubuntu, Roboto, Arial, Helvetica, sans-serif" font-size="36" font-weight="700" class="sc-bsVVwV hWBiPl">Экран
              </text>
            </svg>
        `;
            this.findGElementInMap();
            this.addBorderToMap();
            this.addCloseButton();

            this.scrollToElement(this.previewHallMapContainer);

            this.previewHallMapContainer.classList.add('fade-in');
            this.addHallMapButton.classList.add('admin-halls__hidden');
            this.seatsWrapperContainer.classList.remove('admin-halls__hidden');
        }
    }

    handleScaleChange() {
        this.scaleSlider && this.scaleSlider.addEventListener('input', (event) => {
            const scaleValue = event.target.value;
            this.scalableGroup.setAttribute('transform', `scale(${scaleValue})`);
        });
    }


    scrollToElement(element) {
        const elementOffset = element.offsetTop;
        const duration = 500; // Время анимации в миллисекундах
        const startTime = performance.now();
        const startScrollY = window.scrollY || document.documentElement.scrollTop;

        const animateScroll = (currentTime) => {
            const elapsed = currentTime - startTime;

            // Рассчитываем новую позицию прокрутки
            const progress = Math.min(elapsed / duration, 1);
            const easeInOutQuad = (t) => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            const newPosition = startScrollY + (elementOffset - startScrollY) * easeInOutQuad(progress);

            // Прокручиваем страницу
            window.scrollTo(0, newPosition);

            // Продолжаем анимацию, если не достигли конечной позиции
            if (progress < 1) {
                requestAnimationFrame(animateScroll);
            }
        };

        // Запускаем анимацию
        requestAnimationFrame(animateScroll);
    }



    removeHallMap() {
        this.previewHallMapContainer.classList.remove('fade-in');
        this.addHallMapButton.classList.remove('admin-halls__hidden');
        this.seatsWrapperContainer.classList.add('admin-halls__hidden');

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

new HallMapAdd();
