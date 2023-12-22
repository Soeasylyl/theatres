class HallMap {
    constructor() {
        this.addHallMapButton = document.querySelector('.add-hall-map');
        this.previewHallMapContainer = document.querySelector('.admin-halls__preview-map');
        this.seatsWrapperContainer = document.querySelector('.admin-halls__seats-wrapper');
        this.addSeatsToMapButton = document.querySelector('.admin-halls__add-seat-btn');

        this.draggedElement = null;
        this.editingSVGElement = null;

        this.init();
    }

    init() {
        this.addSeatToMapContainer();
        this.closePreviewMapContainer();
        this.addDragEventListeners();
        this.autoLoadMap();

        this.saveSeatAjax();
        this.addMapContextMenu();
        this.addSVGContextMenuRecursively(this.gElement);
    }

    addMapContextMenu() {
        const mapContainer = document.querySelector('.admin-halls__map');
        mapContainer.addEventListener('contextmenu', (event) => {
            event.preventDefault();
            const svgElement = event.target.closest('[contextmenu="seatContextMenu"]');
            if (svgElement && mapContainer.contains(svgElement)) {
                // Если клик был на SVG элементе или его дочерних элементах, не вызываем контекстное меню для карты
                return;
            }
            // В противном случае, вызываем контекстное меню для карты
            this.showMapContextMenu(event);
        });
    }

    addSVGContextMenuRecursively(parentElement) {
        parentElement.addEventListener('contextmenu', (event) => {
            event.preventDefault();

            // Проверяем, был ли клик на SVG элементе или его дочерних элементах
            const svgElement = event.target.closest('[contextmenu="seatContextMenu"]');
            if (svgElement && parentElement.contains(svgElement)) {
                // Если клик был на SVG элементе или его дочерних элементах, вызываем контекстное меню для SVG
                this.showSVGContextMenu(event);
            }
        });

        const childElements = parentElement.children;
        Array.from(childElements).forEach((childElement) => {
            if (childElement instanceof SVGElement) {
                this.addSVGContextMenuRecursively(childElement);
            }
        });
    }

    showMapContextMenu(event) {
        event.preventDefault();
        const x = event.pageX - 200;
        const y = event.pageY - 60;

        this.displayContextMenu(x, y, [
            {label: 'Добавить новое место', action: () => this.addNewPlace()}
        ]);
    }

    displayContextMenu(x, y, menuItems) {
        const contextMenu = document.getElementById('contextMenu');
        const menuList = document.getElementById('menuList');

        // Очистка предыдущего контекстного меню
        menuList.innerHTML = '';

        // Добавление новых пунктов меню
        menuItems.forEach(item => {
            const menuItem = document.createElement('li');
            menuItem.textContent = item.label;
            menuItem.addEventListener('click', item.action);
            menuList.appendChild(menuItem);
        });

        // Показ контекстного меню
        contextMenu.style.display = 'block';
        contextMenu.style.left = x + 'px';
        contextMenu.style.top = y + 'px';

        // Скрытие контекстного меню при клике вне его области
        document.addEventListener('click', this.hideContextMenu);
    }

    hideContextMenu() {
        const contextMenu = document.getElementById('contextMenu');
        contextMenu.style.display = 'none';
    }

    showSVGContextMenu(event) {
        event.preventDefault();
        const x = event.pageX - 200;
        const y = event.pageY - 60;

        this.displayContextMenu(x, y, [
            {label: 'Редактировать место', action: () => this.editPlace(event)},
            {label: 'Удалить место', action: () => this.deletePlace()}
        ]);
    }

    contextMenuListener(event) {
        event.preventDefault();

        // Находим SVG-элемент, на который был совершен клик
        const clickedElement = event.target.closest('svg');

        if (clickedElement) {
            // Убираем стиль "selected" у предыдущего выбранного элемента
            const previouslySelected = document.querySelector('svg.selected');
            previouslySelected?.classList.remove('selected');

            const numberRowInput = document.querySelector('input[name="number_row"]');
            const numberSeatInput = document.querySelector('input[name="number_seat"]');
            const XSeatInput = document.querySelector('input[name="x_pos_seat"]');
            const YSeatInput = document.querySelector('input[name="y_pos_seat"]');
            const seatsTypeSelect = document.querySelector('select[name="seats_type"]');
            const seatsButton = document.querySelector('[data-update-url]');

            YSeatInput && (YSeatInput.value = clickedElement.getAttribute('y') || clickedElement.dataset.y);
            XSeatInput && (XSeatInput.value = clickedElement.getAttribute('x') || clickedElement.dataset.x);
            numberRowInput && (numberRowInput.value = clickedElement.dataset.numberRow);
            numberSeatInput && (numberSeatInput.value = clickedElement.dataset.numberSeat);
            seatsTypeSelect && (seatsTypeSelect.value = clickedElement.dataset.seatType);
            if (seatsButton && clickedElement && clickedElement.dataset.seatId) {
                const seatId = clickedElement.dataset.seatId;
                seatsButton.dataset.selectedSeatId = seatId;

                const updateUrl = seatsButton.dataset.updateUrl;

                // Разделяем URL по слэшам
                const urlSegments = updateUrl.split('/');

                // Меняем значение последнего сегмента на seatId
                urlSegments[urlSegments.length - 1] = seatId;

                // Объединяем сегменты обратно в строку URL и Присваиваем новое значение атрибуту
                seatsButton.dataset.updateUrl = urlSegments.join('/');
            }

            clickedElement.classList.add('selected');

            this.editingSVGElement = clickedElement;
        }
    }

    addNewPlace() {
        console.log('Добавление нового места');

        this.hideContextMenu();
        const titleElement = document.querySelector('.admin-halls__seats-title');
        titleElement.textContent = 'Добавление нового места:';
        this.seatsWrapperContainer && this.seatsWrapperContainer.classList.remove('admin-halls__hidden');
    }

    editPlace(event) {
        console.log('Редактирование место');
        this.hideContextMenu();
        this.contextMenuListener(event);
        const titleElement = document.querySelector('.admin-halls__seats-title');
        titleElement.textContent = 'Редактирование места:';
        this.seatsWrapperContainer && this.seatsWrapperContainer.classList.remove('admin-halls__hidden');

        const svgElement = this.getEditingSVGElement();
        if (svgElement) {
            // Примените стиль "selected" к SVG элементу
            svgElement.classList.add('selected');
        }

        this.editInputListener();
    }

    saveSeatAjax() {
        const seatsButton = document.querySelector('[data-update-url]');

        seatsButton?.addEventListener('click', () => {
            const numberRow = document.querySelector('input[name="number_row"]').value;
            const numberSeat = document.querySelector('input[name="number_seat"]').value;
            const XSeat = document.querySelector('input[name="x_pos_seat"]').value;
            const YSeat = document.querySelector('input[name="y_pos_seat"]').value;
            const seatsType = document.querySelector('select[name="seats_type"]').value;

            const url = seatsButton.getAttribute('data-update-url');
            const id = seatsButton.getAttribute('data-selected-seat-id');
            const hallId = seatsButton.getAttribute('data-hall-id');
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch(`${url}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    seat_id: id,
                    hall_id: hallId,
                    row: numberRow,
                    number: numberSeat,
                    position_x: XSeat,
                    position_y: YSeat,
                    seat_type_id: seatsType,
                }),
            })
                .then((response) => {
                    return response.json();
                })
                .then(resp => {
                    if (resp.status) {
                       const typeNotification = 'notifications-success';

                       this.resetSelectedSeat(typeNotification,resp.message)
                    } else {
                        const typeNotification = 'notifications-danger';

                        this.resetSelectedSeat(typeNotification,resp.message)
                    }
                })
        });
    }

    resetSelectedSeat(typeNotification, message) {
        const notificationsSection = document.querySelector('.notifications');
        const messageDiv = document.createElement('div');
        messageDiv.innerHTML = message;
        messageDiv.classList.add(typeNotification);
        notificationsSection.appendChild(messageDiv);
        window.notifications.init();

        this.seatsWrapperContainer?.classList.add('admin-halls__hidden');

        const selectedElement = document.querySelector('.selected');
        selectedElement?.classList.remove('selected');
    }


    editInputListener() {
        const XSeatInput = document.querySelector('input[name="x_pos_seat"]');
        const YSeatInput = document.querySelector('input[name="y_pos_seat"]');
        const numberRowInput = document.querySelector('input[name="number_row"]');
        const numberSeatInput = document.querySelector('input[name="number_seat"]');
        const seatsTypeSelect = document.querySelector('select[name="seats_type"]');

        XSeatInput?.addEventListener('input', () => this.handleInputInformationChange('x'));
        YSeatInput?.addEventListener('input', () => this.handleInputInformationChange('y'));
        numberRowInput?.addEventListener('input', () => this.handleInputInformationChange('number_row'));
        numberSeatInput?.addEventListener('input', () => this.handleInputInformationChange('number_seat'));
        seatsTypeSelect?.addEventListener('input', () => this.handleInputInformationChange('seats_type'));
    }

    handleInputInformationChange(data) {
        const numberRowInput = document.querySelector('input[name="number_row"]');
        const numberSeatInput = document.querySelector('input[name="number_seat"]');
        const XSeatInput = document.querySelector('input[name="x_pos_seat"]');
        const YSeatInput = document.querySelector('input[name="y_pos_seat"]');
        const seatsTypeSelect = document.querySelector('select[name="seats_type"]');
        const selectedElement = document.querySelector('svg.selected');

        if (numberRowInput && numberSeatInput && XSeatInput && YSeatInput && seatsTypeSelect) {
            const numberRow = parseInt(numberRowInput.value);
            const numberSeat = parseInt(numberSeatInput.value);
            const XSeat = parseFloat(XSeatInput.value);
            const YSeat = parseFloat(YSeatInput.value);
            const seatsType = parseInt(seatsTypeSelect.value);
            const seatsTypeName = seatsTypeSelect.options[seatsTypeSelect.selectedIndex].textContent;

            if (!isNaN(XSeat) && !isNaN(YSeat) && !isNaN(numberRow) && !isNaN(numberSeat)) {
                selectedElement.setAttributeNS(null, 'x', XSeat);
                selectedElement.setAttributeNS(null, 'y', YSeat);
                selectedElement.setAttributeNS(null, 'data-number-row', numberRow);
                selectedElement.setAttributeNS(null, 'data-number-seat', numberSeat);
                selectedElement.setAttributeNS(null, 'data-seat-type', seatsType);

                const textElement = selectedElement.querySelector('text');
                textElement?.textContent && (textElement.textContent = numberSeat.toString());

                const titleElement = selectedElement.querySelector('title');
                titleElement?.textContent && (titleElement.textContent = `Номер ряда: ${numberRow}, Тип места: ${seatsTypeName}`);
            }
        }
    }

    getEditingSVGElement() {

        const isEditing = true;

        if (isEditing) {

            return this.editingSVGElement;
        }

        return null;
    }

    deletePlace() {
        console.log('Удаление места');
        this.hideContextMenu();
    }

    autoLoadMap() {
        const elementUrl = document.querySelector('[data-page-url]');

        if (elementUrl) {
            const url = elementUrl.dataset.pageUrl;
            const autoload = true;
            this.addHallMap(autoload);
            this.ajaxGetDataHallMap(url);

        }
        this.seatsWrapperContainer && this.seatsWrapperContainer.classList.add('admin-halls__hidden');
    }

    handleDragStart(event) {
        this.draggedElement = null;
        const target = event.target.closest('svg');
        if (target && target.parentNode === this.gElement && target.classList.contains('selected')) {
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
        svgPoint.x = event.pageX;
        svgPoint.y = event.pageY;
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

            const XSeatInput = document.querySelector('input[name="x_pos_seat"]');
            const YSeatInput = document.querySelector('input[name="y_pos_seat"]');
            if (XSeatInput && YSeatInput) {
                XSeatInput.value = dx;
                YSeatInput.value = dy;
            }
        }
    }

    addDragEventListeners() {
        document.addEventListener('mousedown', this.handleDragStart.bind(this));
        document.addEventListener('mouseup', this.handleDragEnd.bind(this));
        document.addEventListener('mousemove', this.handleDrag.bind(this));
        // this.addClickEventListeners();
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

    renderMapToPreview(
        numberSeatInputValue,
        numberRowInputValue,
        seatTypeId,
        seatTypeName,
        renderSeatPosX,
        renderSeatPosY,
        seatId,
    ) {

        if (!numberSeatInputValue) {
            alert('Пожалуйста, введите номер места.');
            return; // Прерываем выполнение функции, если значение отсутствует
        }

        this.findGElementInMap();
        const svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgElement.setAttribute('x', renderSeatPosX !== undefined ? renderSeatPosX : '650');
        svgElement.setAttribute('y', renderSeatPosY !== undefined ? renderSeatPosY : '125');
        svgElement.setAttribute('width', '80');
        svgElement.setAttribute('height', '86');
        svgElement.setAttribute('type', 'recliner');

        svgElement.setAttribute('contextmenu', 'seatContextMenu');

        // Создаем новый скрытый инпут для номера места
        const seatNumberInput = document.createElement('input');
        seatNumberInput.type = 'hidden';
        seatNumberInput.name = `rows[${numberRowInputValue}][${numberSeatInputValue}][seatNumber]`;
        seatNumberInput.value = numberSeatInputValue;

        // Создаем новый скрытый инпут для типа места
        const seatsTypeIdInput = document.createElement('input');
        seatsTypeIdInput.type = 'hidden';
        seatsTypeIdInput.name = `rows[${numberRowInputValue}][${numberSeatInputValue}][seatsTypeId]`;
        seatsTypeIdInput.value = seatTypeId;

        // Создаем новый скрытый инпут для posX
        const posXInput = document.createElement('input');
        posXInput.type = 'hidden';
        posXInput.name = `rows[${numberRowInputValue}][${numberSeatInputValue}][posX]`;
        posXInput.value = svgElement.getAttributeNS(null, 'x');

        // Создаем новый скрытый инпут для posY
        const posYInput = document.createElement('input');
        posYInput.type = 'hidden';
        posYInput.name = `rows[${numberRowInputValue}][${numberSeatInputValue}][posY]`;
        posYInput.value = svgElement.getAttributeNS(null, 'y');

        if (seatId) {
            const seatIdInput = document.createElement('input');
            seatIdInput.type = 'hidden';
            seatIdInput.name = `rows[${numberRowInputValue}][${numberSeatInputValue}][seatId]`;
            seatIdInput.value = seatId;

            this.previewHallMapContainer.appendChild(seatIdInput);
            svgElement.setAttribute('data-seat-id', seatId);
        }

        // Устанавливаем значения номера ряда и места в атрибуты data
        svgElement.setAttribute('data-number-row', numberRowInputValue);
        svgElement.setAttribute('data-number-seat', numberSeatInputValue);

        // Добавляем новые инпуты в форму
        this.previewHallMapContainer.appendChild(seatNumberInput);
        this.previewHallMapContainer.appendChild(seatsTypeIdInput);
        this.previewHallMapContainer.appendChild(posXInput);
        this.previewHallMapContainer.appendChild(posYInput);

        svgElement.setAttribute('data-seat-type', seatTypeId);
        svgElement.setAttribute('data-number-row', numberRowInputValue);

        const titleElement = document.createElementNS('http://www.w3.org/2000/svg', 'title');
        titleElement.textContent = `Номер ряда: ${numberRowInputValue}, Тип места: ${seatTypeName}`;

        // Create the text element
        const textElement = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        textElement.setAttribute('x', '50%');
        textElement.setAttribute('y', '50%');
        textElement.setAttribute('dy', '0.35em');
        textElement.setAttribute('text-anchor', 'middle');
        textElement.setAttribute('font-size', '20');
        textElement.setAttribute('fill', 'white');

        textElement.textContent = numberSeatInputValue;

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
    }

    addSeatToMapContainer() {
        this.addSeatsToMapButton && this.addSeatsToMapButton.addEventListener('click', () => {
            const numberSeatInput = this.seatsWrapperContainer.querySelector('input[name="number_seat"]');
            const numberRowInput = this.seatsWrapperContainer.querySelector('input[name="number_row"]');

            const dataSeatTypeInput = this.seatsWrapperContainer.querySelector('select[name="seats_type"]');
            const selectedSeatTypeId = dataSeatTypeInput ? dataSeatTypeInput.value : '';
            const selectedSeatName = dataSeatTypeInput ? dataSeatTypeInput.options[dataSeatTypeInput.selectedIndex].text : '';

            this.renderMapToPreview(
                numberSeatInput.value.trim(),
                numberRowInput.value.trim(),
                selectedSeatTypeId,
                selectedSeatName,
            );
        })
    }

    closePreviewMapContainer() {
        this.addHallMapButton && this.addHallMapButton.addEventListener('click', () => {
            this.addHallMap();

            const isEditButton = this.addHallMapButton.dataset.edit === 'true';

            if (isEditButton) {
                const url = this.addHallMapButton.dataset.url;
                this.ajaxGetDataHallMap(url)
            }
        });

        this.previewHallMapContainer && this.previewHallMapContainer.addEventListener('click', (event) => {
            const closeButton = this.previewHallMapContainer.querySelector('.admin-halls__close-button');
            if (event.target === closeButton) {
                this.removeHallMap();
            }
        });
    }

    ajaxGetDataHallMap(url) {
        fetch(`${url}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                const seatEntries = Object.entries(data.dataSeats);

                for (const [rowKey, seats] of seatEntries) {
                    for (const [seatKey, seat] of Object.entries(seats)) {
                        const {number, posX, posY, seatsTypeId, seatsTypeName} = seat;

                        // Вызов вашего метода с полученными значениями
                        this.renderMapToPreview(
                            number,
                            rowKey,
                            seatsTypeId,
                            seatsTypeName,
                            posX,
                            posY,
                            seatKey,
                        );
                    }
                }
            });
    }

    addHallMap(autoload) {
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

            if (!autoload) {
                this.addCloseButton();
            }

            this.scrollToElement(this.previewHallMapContainer);

            this.previewHallMapContainer && this.previewHallMapContainer.classList.add('fade-in');
            this.addHallMapButton && this.addHallMapButton.classList.add('admin-halls__hidden');
            this.seatsWrapperContainer && this.seatsWrapperContainer.classList.remove('admin-halls__hidden');
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
        this.previewHallMapContainer && this.previewHallMapContainer.classList.remove('fade-in');
        this.addHallMapButton && this.addHallMapButton.classList.remove('admin-halls__hidden');
        this.seatsWrapperContainer && this.seatsWrapperContainer.classList.add('admin-halls__hidden');

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
