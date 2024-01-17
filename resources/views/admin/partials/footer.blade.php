<footer>
    <div class="modal" id="addSeatTypeModal">
        @if(isset($theatre))
            <div class="modal__container">
                <form method="POST" action="{{ route('seat-type.create', ['theatre' => $theatre->id]) }}">
                    @csrf
                    @method('POST')

                    <div class="modal__seats-wrapper">
                        <div class="modal__title">{{ __('Добавление нового типа мест:') }}</div>
                        <div class="modal__seats-container">
                            <div class="modal__seats-number">
                                <div class="modal__seats-number-left">

                                    <x-input :inputAttributes="[
                                                'name'=>'seat_name',
                                                'required'=>'required',
                                                'autocomplete' => 'off',
                                                 ]"
                                             :errorAttribute="'seat_name'"
                                             input_required>
                                        {{ __('Введите название типа мест:') }}
                                    </x-input>

                                    <x-textarea :inputAttributes="[
                                                    'name'=>'seat_description',
                                                    'required'=>'required',
                                                    'autocomplete' => 'off',
                                                     ]"
                                                :errorAttribute="'seat_description'"
                                                input_required
                                    >{{ __('Введите описание типа места:') }}</x-textarea>

                                    <x-input :inputAttributes="[
                                                'name'=>'seat_amount',
                                                'required'=>'required',
                                                'autocomplete' => 'off',
                                                 ]"
                                             :errorAttribute="'seat_amount'"
                                             input_required>
                                        {{ __('Введите цену за место:') }}
                                    </x-input>

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

    <div class="modal" id="editSeatTypeModal">
        @if(isset($theatre))
            <div class="modal__container">
                <form method="POST" action="{{ route('seat-type.update', ['theatre' => $theatre->id]) }}">
                    @csrf
                    @method('PATCH')

                    <div class="modal__seats-wrapper">
                        <div class="modal__title">{{ __('Редактирование типа мест:') }}</div>
                        <div class="modal__seats-container">
                            <div class="modal__seats-number">
                                <div class="modal__seats-number-left">
                                    <input type="text" name="seat_id" style="display: none">

                                    <x-input :inputAttributes="[
                                        'name'=>'seat_name',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'style' => 'min-width: 450px !important;',
                                         ]"
                                             :errorAttribute="'seat_name'"
                                             input_required>
                                        {{ __('Введите типа места:') }}
                                    </x-input>

                                    <x-textarea :inputAttributes="[
                                        'name'=>'seat_description',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                                :errorAttribute="'seat_description'"
                                                input_required
                                    >{{ __('Введите описание типа места:') }}</x-textarea>

                                    <x-input :inputAttributes="[
                                        'name'=>'seat_amount',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                             :errorAttribute="'seat_amount'"
                                             input_required>
                                        {{ __('Введите цену за место:') }}
                                    </x-input>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal__button-wrapper">
                        <button type="submit" class="modal__button modal__add-btn">{{ __('Сохранить') }}</button>
                        <div class="modal__button modal__close-edit-theatre-btn">{{ __('Отмена') }}</div>
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
                    <x-input :inputAttributes="[
                                        'name'=>'dateTime',
                                        'type'=>'datetime-local',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                             :errorAttribute="'dateTime'"
                             input_required>
                        {{ __('Укажите время блокировки:') }}
                    </x-input>

                    <div class="modal__button-wrapper">
                        <button type="submit" class="modal__button modal__block-btn">{{ __('Заблокировать') }}</button>
                        <div class="modal__button modal__close-btn">{{ __('Отмена') }}</div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @if(request()->route()->getName() === 'screenings.index')
        <div class="modal" id="filteredScreeningsModal">
            <div class="modal__container">
                <div class="modal__title">{{ __('Выберите необходимые фильтры') }}</div>
                <form method="GET" action="{{ route("screenings.index") }}">
                    <div class="modal__item">
                        <select class="admin-halls__seats-type" name="fTheatre">
                            @if(isset($theatres))
                                <option value="" selected>{{ __(('Все кинотеатры')) }}</option>
                                @forelse($theatres as $theatre)
                                    <option value="{{ $theatre->id }}"> {{ $theatre->name }}</option>
                                @empty
                                    <option value="null">{{ __(('Нет доступных кинотеатров')) }}</option>
                                @endforelse
                            @endif
                        </select>
                    </div>

                    <div class="modal__item">
                        <x-input :inputAttributes="[
                                        'name'=>'fDate',
                                        'type'=>'date',
                                        'autocomplete' => 'off',
                                        'style' => 'min-width: 450px !important;',
                                         ]"
                                 :errorAttribute="'dateScreenings'"
                                 input_required>
                            {{ __('Выберите дату:') }}
                        </x-input>
                    </div>

                    <div class="modal__item">
                        <div class="modal__radio-container">
                            <label for="filteredAllScreenings">{{ __('Отобразить все сеансы') }}
                                <input name="fScreenings"
                                       type="radio"
                                       id="filteredAllScreenings"
                                       value="all" checked>
                                <span class="radio-checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="modal__item">
                        <div class="modal__radio-container">
                            <label for="filteredCompleteScreenings">{{ __('Отобразить только предстоящие сеансы') }}
                                <input name="fScreenings"
                                       type="radio"
                                       id="filteredCompleteScreenings"
                                       value="upcoming">
                                <span class="radio-checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="modal__item">
                        <div class="modal__radio-container">
                            <label for="filteredEndedScreenings">{{ __('Отобразить только завершенные сеансы') }}
                                <input name="fScreenings"
                                       type="radio"
                                       id="filteredEndedScreenings"
                                       value="completed">
                                <span class="radio-checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="modal__button-wrapper">
                        <button type="submit"
                                class="modal__button modal__filter-btn">
                            {{ __('Применить фильтры') }}
                        </button>
                        <div class="modal__button modal__close-btn">
                            {{ __('Отмена') }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</footer>
