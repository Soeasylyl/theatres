@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-movies">
                <div class="admin-container__form-header">
                    {{ __('Добавление нового фильма') }}
                </div>
                @error('error')
                <div class="error-messages">
                    {{$message}}
                </div>
                @enderror
                <div class="admin-movies__body">
                    <form method="POST"
                          action="{{ route('movie.store') }}"
                          class="admin-movies__form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="admin-movies__form-left">
                            <div class="admin-movies__items">
                                @error('name')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-movies__item-header">
                                    {{ __('Название:') }}
                                </div>
                                <div class="admin-movies__item-body">
                                    <input type="text" name="name"
                                           autocomplete="off" required
                                           placeholder="{{ __('Название фильма') }}">
                                </div>
                            </div>
                            <div class="admin-movies__items">
                                @error('date_start')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-movies__item-header">
                                    {{ __('Дата мировой премьера:') }}
                                </div>
                                <div class="admin-movies__item-body">
                                    <input type="datetime-local" name="date_start"
                                           autocomplete="off" required>
                                </div>
                            </div>
                            <div class="admin-movies__items">
                                @error('session_duration')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-movies__item-header">
                                    {{ __('Длительность:') }}
                                </div>
                                <div class="admin-movies__item-body">
                                    <input type="text" name="session_duration"
                                           autocomplete="off" required
                                           placeholder="{{ __('Длина фильма в формате 02:12:00') }}">
                                </div>
                            </div>
                            <div class="admin-movies__items">
                                @error('rating')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-movies__item-header">
                                    {{ __('Рэйтинг:') }}
                                </div>
                                <div class="admin-movies__item-body">
                                    <input type="text" name="rating"
                                           autocomplete="off" required
                                           placeholder="{{ __('Рэйтинг фильма от 1.1 до 10') }}">

                                </div>
                            </div>
                            <div class="admin-movies__items">
                                @error('age_limit')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-movies__item-header">
                                    {{ __('Возрастное ограничение:') }}
                                </div>
                                <div class="admin-movies__item-body">
                                    <input type="text" name="age_limit"
                                           autocomplete="off" required
                                           placeholder="{{ __('Возрастное ограничение до 21 года') }}">
                                </div>
                            </div>
                        </div>
                        <div class="admin-movies__form-right">
                            <div class="admin-movies__items">
                                @error('description')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="admin-movies__item-header">
                                    {{ __('Описание:') }}
                                </div>
                                <div class="admin-movies__item-body">
                                <textarea type="text" name="description"
                                          autocomplete="off" required
                                          placeholder="{{ __('Описание сюжета фильма') }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="admin-movies__items">
                            @error('poster')
                            <div class="error-messages">
                                {{$message}}
                            </div>
                            @enderror
                            <div id="previewMoviePoster" class="admin-movies__preview-container"></div>
                            <div class="admin-movies__item-header">
                                {{ __('Загрузка афиши:') }}
                            </div>
                            <div class="admin-movies__item-body">
                                <input id="posterMovieInput" type="file"
                                       name="poster" autocomplete="off">
                            </div>
                        </div>
                        <div class="admin-movies__items">
                            @error('frames')
                            <div class="error-messages">
                                {{$message}}
                            </div>
                            @enderror
                            @error('frames.*')
                            <div class="error-messages">
                                {{$message}}
                            </div>
                            @enderror
                            <div id="previewMovieFrames" class="admin-movies__preview-container"></div>
                            <div class="admin-movies__item-header">
                                {{ __('Загрузка медиа-файлов:') }}
                            </div>
                            <div class="admin-movies__item-body">
                                <input id="framesMovieInput" type="file" name="frames[]"
                                       autocomplete="off" multiple>
                            </div>
                        </div>
                        <div class="login-container__button-wrapper" style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Добавить фильм') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
