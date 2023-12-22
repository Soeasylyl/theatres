@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-halls">
                <div class="admin-container__form-header"
                     data-page-url="{{ route('generateMap.create', ['theatres' => $theatreId, 'halls' => $hallId]) }}">
                    {{ __('Редактирование зала') }}
                </div>

                <div class="admin-halls__body">
                    <div class="admin-halls__seats ">
                        <div class="admin-halls__rows">
                            <div class="admin-halls__map-container">
                                <div id="contextMenu" class="admin-halls__map-context-menu">
                                    <ul id="menuList"></ul>
                                </div>
                                <div class="admin-halls__preview-map">

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

                                <x-input :inputAttributes="[
                                        'name'=>'x_pos_seat',
                                        'type' => 'text',
                                        'autocomplete' => 'off',
                                        'class'=> 'admin-halls__seats-count',
                                        'pattern'=>'^\d+(\.\d+)?$',
                                         ]"
                                         :errorAttribute="'x_pos_seat'"
                                >
                                    {{ __('Координата Х:') }}
                                </x-input>

                                <x-input :inputAttributes="[
                                        'name'=>'y_pos_seat',
                                        'type' => 'text',
                                        'autocomplete' => 'off',
                                        'class'=> 'admin-halls__seats-count',
                                        'pattern'=>'^\d+(\.\d+)?$',
                                         ]"
                                         :errorAttribute="'y_pos_seat'"
                                >
                                    {{ __('Координата У:') }}
                                </x-input>

                                @csrf
                                <div class="admin-halls__save-seat-btn"
                                     data-selected-seat-id=""
                                     data-hall-id="{{ $hallId }}">{{ __('Сохранить') }}</div>

                                <input id="scaleSlider" type="range" min="0.1" max="1.2" step="0.1" value="0.7">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

