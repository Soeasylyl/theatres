@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-halls">
                <div class="admin-container__form-header">
                    {{ __('Редактирование информации о зале') }}
                </div>

                <div class="admin-halls__body">
                    <form method="POST"
                          action="{{ route('hall.update', [$theatres, $hall->id]) }}"
                          enctype="multipart/form-data">
                        <div class="admin-halls__form">
                            @csrf
                            @method('patch')
                            <div class="admin-halls__form-left">
                                <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'value' => $hall->name,
                                         ]"
                                         :errorAttribute="'name'"
                                         input_required>
                                    {{ __('Название зала:') }}
                                </x-input>

                                <div class="admin-halls__items">
                                    @error('$hallImages')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    @error('$hallImages.*')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <div id="previewTheatreImage" class="admin-halls__preview-container"></div>
                                    <div class="admin-halls__item-header">
                                        {{ __('Загрузка медиа-файлов:') }}
                                    </div>
                                    <div class="admin-halls__item-body">
                                        <input id="theatreImageInput" type="file" name="hallImages[]"
                                               autocomplete="off" multiple>
                                    </div>
                                </div>

                            </div>
                            <div class="admin-halls__form-right">
                                <x-textarea :inputAttributes="[
                                        'name'=>'description',
                                        'pattern' => '^.{0,1000}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                            :errorAttribute="'description'"
                                            :text-content="$hall->description"
                                            input_required
                                >{{ __('Описание зала:') }}</x-textarea>

                            </div>
                        </div>

                        <div class="admin-halls__seats">
                            <h2 class="admin-halls__title">
                                {{ __('Визуализация создания зала') }}
                            </h2>
                            <div class="admin-halls__rows">
                                <div class="admin-halls__map-container">
                                    <div class="admin-halls__preview-map">
                                    </div>
                                    <div class="admin-halls__map-body">

                                        <div class="login-container__btn add-hall-map"
                                             data-id-hall="{{ $halls }}"
                                             data-id-theatre="{{ $theatres }}"
                                             data-url="{{ route('hall.show.row-seats') }}"
                                             data-edit="true"> {{ __('Показать карту зала') }}</div>
                                    </div>
                                </div>

                            </div>
                            <div class="admin-halls__seats-wrapper admin-halls__hidden">
                                <div class="admin-halls__seats-title">{{ __('Добавление нового места:') }}</div>
                                <div class="admin-halls__seats-body">
                                    <x-input :inputAttributes="[
                                        'name'=>'number_row',
                                        'type' => 'number',
                                        'autocomplete' => 'off',
                                        'class'=> 'admin-halls__seats-count'
                                         ]"
                                             :errorAttribute="'number_row'"
                                    >
                                        {{ __('Укажите номер ряда:') }}
                                    </x-input>

                                    <div class="admin-halls__item">
                                        <label for="">{{ __('Выберите тип места:') }}</label>
                                        <select class="admin-halls__seats-type" name="seats_type">
                                            @forelse($seatTypes as $seatType)
                                                <option value="{{ $seatType->id }}">{{ $seatType->name }}</option>
                                            @empty
                                                <option value="none">{{ __(('Нет доступных типов')) }}</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <x-input :inputAttributes="[
                                        'name'=>'number_seat',
                                        'type' => 'number',
                                        'autocomplete' => 'off',
                                        'class'=> 'admin-halls__seats-count'
                                         ]"
                                             :errorAttribute="'number_seat'"
                                    >
                                        {{ __('Укажите номер места:') }}
                                    </x-input>

                                    <div class="admin-halls__add-seat-btn">{{ __('Добавить') }}</div>

                                    <input id="scaleSlider" type="range" min="0.1" max="1.2" step="0.1" value="0.7">
                                </div>
                            </div>
                        </div>
                        <div class="login-container__button-wrapper" style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Сохранить зал') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

