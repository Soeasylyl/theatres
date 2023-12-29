@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-theatres">
                <div class="admin-container__form-header">
                    {{ __('Добавление нового сеанса') }}
                </div>
                <div class="admin-screenings__body">
                    <form method="POST"
                          action="{{ route('screening.store') }}"
                          class="admin-screenings__form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="admin-screenings__form-left">
                            <div class="admin-screenings__item">
                                <select class="admin-halls__seats-type"
                                        data-get-hall-url="{{ route('screening.get-halls') }}"
                                        name="theatre"
                                        id="screeningsTheatreSelectAdd">
                                    <option value="" disabled selected>{{ __('Выберите кинотеатр:') }}</option>
                                    @if(isset($theatres))
                                        <option value="" selected>{{ __(('Все кинотеатры')) }}</option>
                                        @forelse($theatres as $theatre)
                                            <option value="{{ $theatre->id }}"> {{ $theatre->name }}</option>
                                        @empty
                                            <option value="null">{{ __(('Нет доступных кинотеатров')) }}</option>
                                        @endforelse
                                    @endif
                                </select>
                                @error('theatre')
                                <div class="error-message">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="admin-screenings__item admin-screenings__hidden">
                                <select class="admin-halls__seats-type" name="hall">
                                    <option value="" disabled selected>{{ __('Выберите зал:') }}</option>

                                </select>
                                @error('hall')
                                <div class="error-message">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="admin-screenings__form-right">

                            <div class="select__select-box" data-movies-url="{{ route('movie.get-movies') }}">
                                <div class="select__select-option">
                                    <input id="screeningsSelectSoValue"
                                           name=""
                                           type="text"
                                           placeholder="{{ __('Поиск фильма:') }}"
                                           readonly
                                    >
                                </div>
                                <div class="select__content">
                                    <div class="select__select-search">
                                        <input id="screeningsSelectOptionsSearch"
                                               name=""
                                               type="text"
                                               placeholder="{{ __('Поиск:') }}"
                                        >
                                        <ul class="select__options">

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <x-input :inputAttributes="[
                                        'name'=>'price',
                                        'type' => 'number',
                                        'step' => 'any',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'min' => '1',
                                         ]"
                                     :errorAttribute="'price'"
                                     input_required>
                                {{ __('Минимальная цена билета:') }}
                            </x-input>

                            <input type="hidden" name="timeZone" class="admin-screenings__timezone-input">
                            <x-input :inputAttributes="[
                                        'name'=>'date',
                                        'type'=>'datetime-local',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'date'"
                                     input_required>
                                {{ __('Выберите дату начала показа:') }}
                            </x-input>

                        </div>
                        <div class="login-container__button-wrapper admin-screenings__button-wrapper"
                             style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Добавить сеанс') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

