<footer>

    <div class="modal" id="addSeatTypeModal">
        @if(isset($theatre))
        <div class="modal__container">
            <form method="POST" action="{{ route('seat-type.create', ['theatres' => $theatre->id]) }}">
                @csrf
                @method('POST')

                <div class="modal__seats-wrapper">
                    <div class="modal__title">{{ __('Добавление нового типа мест:') }}</div>
                    <div class="modal__seats-container">
                        <div class="modal__seats-number">
                            <div class="modal__seats-number-left">
                                <div class="modal__items">
                                    <div class="modal__seats-title">
                                        {{ __('Название:') }}
                                    </div>
                                    <input type="text" name="seat_name"
                                           required placeholder="Обычное">
                                </div>
                                <div class="modal__items">
                                    <div class="modal__seats-title">
                                        {{ __('Описание') }}
                                    </div>
                                    <textarea type="text" name="seat_description"
                                              placeholder="Введите описание типа места"></textarea>
                                </div>

                                <div class="modal__items">
                                    <div class="modal__seats-title">
                                        {{ __('Цена за место:') }}
                                    </div>
                                    <input type="text" name="seat_amount"
                                           required placeholder="Цена в $">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal__button-wrapper">
                    <button type="submit" class="modal__button modal__add-btn">{{ __('Добавить') }}</button>
                    <div class="modal__button modal__close-btn">{{ __('Отмена') }}</div>
                </div>
            </form>
        </div>
        @endif
    </div>

    <div class="modal" id="blockModal">
        @if(isset($user))
        <div class="modal__container">
            <div class="modal__title">{{ __('ЗАБЛОКИРОВАТЬ ДО:') }}</div>
            <form method="POST" action="{{ route('user.block', $user->id )}}">
                @csrf
                @method('PATCH')

                <input type="hidden" name="timeZone" id="timezone">
                <input type="datetime-local" name="dateTime" required/>

                <div class="modal__button-wrapper">
                    <button type="submit" class="modal__button modal__block-btn">{{ __('Заблокировать') }}</button>
                    <div class="modal__button modal__close-btn">{{ __('Отмена') }}</div>
                </div>
            </form>
        </div>
        @endif
    </div>

</footer>
