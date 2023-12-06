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
                <form method="POST" action="{{ route('seat-type.update', ['theatres' => $theatre->id]) }}">
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

</footer>
