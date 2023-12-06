@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-theatres">
                <div class="admin-container__form-header">
                    {{ __('Добавление нового Кинотеатра') }}
                </div>
                @error('error')
                <div class="error-messages">
                    {{$message}}
                </div>
                @enderror
                <div class="admin-theatres__body">
                    <form method="POST"
                          action="{{ route('theatre.store') }}"
                          class="admin-theatres__form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="admin-theatres__form-left">
                            <div class="admin-theatres__items">
                                @error('name')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-theatres__item-header">
                                    {{ __('Название:') }}
                                </div>
                                <div class="admin-theatres__item-body">
                                    <input type="text" name="name"
                                           autocomplete="off" required
                                           placeholder="{{ __('Название кинотеатра') }}">
                                </div>
                            </div>

{{--                            <x-input :inputAttributes="[ 'type'=>'text', 'name'=>'name', 'required'=>'required' ]"--}}
{{--                                     input_required>--}}
{{--                                {{ __('Название кинотеатра:') }}--}}
{{--                            </x-input>--}}

                            <div class="admin-theatres__items">
                                @error('description')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-theatres__item-header">
                                    {{ __('Описание:') }}
                                </div>
                                <div class="admin-theatres__item-body">
                                <textarea type="text" name="description"
                                          autocomplete="off" required
                                          placeholder="{{ __('Описание информации о кинотеатре') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="admin-theatres__form-right">
                            <div class="admin-theatres__items">
                                @error('name')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-theatres__item-header">
                                    {{ __('Адрес:') }}
                                </div>
                                <div class="admin-theatres__item-body">
                                    <input type="text" name="address"
                                           autocomplete="off" required
                                           placeholder="{{ __('Адрес кинотеатра') }}">
                                </div>
                            </div>
                            <div class="admin-theatres__items">
                                @error('$theatreImages')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                @error('$theatreImages.*')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div id="previewTheatreImage" class="admin-theatres__preview-container"></div>
                                <div class="admin-theatres__item-header">
                                    {{ __('Загрузка медиа-файлов:') }}
                                </div>
                                <div class="admin-theatres__item-body">
                                    <input id="theatreImageInput" type="file" name="$theatreImages[]"
                                           autocomplete="off" multiple>
                                </div>
                            </div>
                        </div>

                        <div class="login-container__button-wrapper" style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Добавить кинотеатр') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

