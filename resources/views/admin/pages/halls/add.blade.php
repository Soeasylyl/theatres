@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-halls">
                <div class="admin-container__form-header">
                    {{ __('Добавление нового Зала') }}
                </div>

                <div class="admin-halls__body">
                    <form method="POST"
                          action="{{route('hall.create', ['theatres' => $theatreId])}}"
                          enctype="multipart/form-data">
                        <div class="admin-halls__form">
                            @csrf
                            @method('POST')
                            <div class="admin-halls__form-left">
                                <div class="admin-halls__items">
                                    @error('name')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <div class="admin-halls__item-header">
                                        {{ __('Название:') }}
                                    </div>
                                    <div class="admin-halls__item-body">
                                        <input type="text" name="name"
                                               autocomplete="off" required
                                               placeholder="{{ __('Название зала') }}">
                                    </div>
                                </div>
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
                                <div class="admin-halls__items">
                                    @error('description')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <div class="admin-halls__item-header">
                                        {{ __('Описание:') }}
                                    </div>
                                    <div class="admin-halls__item-body">
                                <textarea type="text" name="description"
                                          autocomplete="off" required
                                          placeholder="{{ __('Описание зала') }}"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="admin-halls__seats">

                            <h2 class="admin-halls__title">
                                {{ __('Визуализация создания зала') }}
                            </h2>
                            @if($numberRow>0)
                            <ul class="admin-halls__rows">
                                @include('admin.pages.halls.hall-row-ajax')
                            </ul>
                            @endif
                            <div class="admin-halls__body-wrapper">
                                <div class="admin-halls__item">
                                    <label for="">{{ __('Введите количество мест:') }}</label>
                                    <input class="admin-halls__seats-count" type="number" name="seats_count"
                                           placeholder="Количество мест">
                                </div>
                                <div class="admin-halls__item">
                                    <label for="">{{ __('Выберите тип мест:') }}</label>
                                    <select class="admin-halls__seats-type" name="seats_type">
                                        @forelse($seatTypes as $seatType)
                                            <option value="{{ $seatType->id }}">{{ $seatType->name }}</option>
                                        @empty
                                            <option value="none">{{ __(('Нет доступных типов')) }}</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="admin-halls__add-row-btn">Добавить новый ряд</div>
                            </div>

                        </div>


                        <div class="login-container__button-wrapper" style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Добавить зал') }}
                            </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

