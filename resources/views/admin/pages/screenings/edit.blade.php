@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-theatres">
                <div class="admin-container__form-header">
                    {{ __('Редатирование информации о сеансе') }}
                </div>
                <div class="admin-screenings__body">
                    <form method="POST"
                          action="{{ route('screening.update', ['screening' => $screening->id]) }}"
                          class="admin-screenings__form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="admin-screenings__form-left">
                            <div class="admin-screenings__item">
                                <select class="admin-halls__seats-type" name="hall">
                                    <option value="" disabled>{{ __('Выбирите зал') }}</option>
                                    <option value="{{ $screeningHall->id }}" selected>{{ $screeningHall->name}}</option>
                                    @if(isset($halls))
                                        @forelse($halls as $hall)
                                            @if($screeningHall->id !== $hall->id)
                                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                                            @endif
                                        @empty
                                            <option value="null">{{ __(('Нет доступных залов')) }}</option>
                                        @endforelse
                                    @endif
                                </select>
                                @error('hall')
                                <div class="error-message">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <x-input :inputAttributes="[
                                        'name' => 'price',
                                        'type' => 'number',
                                        'step' => 'any',
                                        'required' => 'required',
                                        'autocomplete' => 'off',
                                        'min' => '1',
                                        'value' => $screening->price,
                                         ]"
                                     :errorAttribute="'price'"
                                     input_required>
                                {{ __('Минимальная цена билета:') }}
                            </x-input>
                        </div>

                        <div class="admin-screenings__form-right">

                            <div class="select__select-box" data-movies-url="{{ route('movie.get-movies') }}">
                                <div class="select__select-option">
                                    <input id="screeningsSelectSoValue"
                                           name=""
                                           type="text"
                                           placeholder="{{ __('Выберите фильм:') }}"
                                           @if($screening->movie->name)
                                               value="{{ $screening->movie->name }}"
                                           @endif
                                           readonly
                                    >
                                    <input type="hidden"
                                           id="screeningsSelectSoValueId"
                                           name="movie_id"
                                           @if($screening->movie->id)
                                               value="{{ $screening->movie->id }}"
                                        @endif
                                    >
                                </div>

                                <div class="select__content">
                                    <div class="select__select-search">
                                        <input id="screeningsSelectOptionsSearch"
                                               type="text"
                                               autofocus
                                               placeholder="{{ __('Поиск:') }}"
                                        >

                                        <ul class="select__options">

                                        </ul>
                                    </div>
                                </div>
                                @error('movie_id')
                                <div class="error-message">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <input type="hidden" name="timeZone" class="admin-screenings__timezone-input">
                            <x-input :inputAttributes="[
                                        'name' => 'date',
                                        'type' => 'datetime-local',
                                        'required' => 'required',
                                        'autocomplete' => 'off',
                                        'value' => $screening->start_at,
                                         ]"
                                     :errorAttribute="'date'"
                                     input_required>
                                {{ __('Выберите дату начала показа:') }}
                            </x-input>
                        </div>
                        <div class="login-container__button-wrapper admin-screenings__button-wrapper"
                             style="justify-content: center">
                            <div class="login-container__btn admin-screenings__open-map" style="width: 50%">
                                {{ __('Отобразить карту бронирования') }}
                            </div>
                        </div>
                        <div class="admin-halls__map-container admin-screenings__map admin-screenings__hidden"
                             data-booking-url="{{ route('generate-booking-map', [
                                                            'theatre' => $screening->hall->theatre->id,
                                                            'hall' => $screening->hall->id,
                                                            'screening' => $screening->id,
                                                            ]) }}   "
                        >

                            @include('admin.partials.seat-info-for-map')

                            <div id="contextMenu" class="admin-halls__map-context-menu">
                                <ul id="menuList"></ul>
                            </div>
                            <div class="admin-halls__preview-map">

                            </div>
                        </div>
                        <div class="login-container__button-wrapper admin-screenings__button-wrapper"
                             style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Сохранить изменения') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

