@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-movies">
                <div class="admin-container__form-header">
                    {{ __('Редактирование информации') }}
                </div>
                <div class="admin-movies__body">
                    <form class="admin-movies__form">
                        <div class="admin-movies__items admin-movies__grid-items">
                            <div class="admin-movies__item-header">
                                {{ __('Название:') }}
                            </div>
                            <div class="admin-movies__item-body">
                                <input type="text" id="movie-name" name="movie-name"
                                       value="{{ old('name', $movie->name) }} "
                                       autocomplete="off" required>
                                @error('name')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="admin-movies__items">
                            <div class="admin-movies__item-header">
                                {{ __('Описание:') }}
                            </div>
                            <div class="admin-movies__item-body">
                                <textarea type="text" id="movie-description" name="movie-description"
                                       autocomplete="off" required>{{ old('description', $movie->description) }}
                                </textarea>
                                @error('name')
                                <div class="error-messages">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="admin-movies__items admin-movies__grid-items">
                            <div class="admin-movies__item-header">
                                {{ __('Длительность:') }}
                            </div>
                            <div class="admin-movies__item-body">

                            </div>
                        </div>
                        <div class="admin-movies__items admin-movies__grid-items">
                            <div class="admin-movies__item-header">
                                {{ __('Дата мировой премьера:') }}
                            </div>
                            <div class="admin-movies__item-body">

                            </div>
                        </div>
                        <div class="admin-movies__items admin-movies__grid-items">
                            <div class="admin-movies__item-header">
                                {{ __('Рэйтинг:') }}
                            </div>
                            <div class="admin-movies__item-body">

                            </div>
                        </div>
                        <div class="admin-movies__items admin-movies__grid-items">
                            <div class="admin-movies__item-header">
                                {{ __('Возростное ограничение:') }}
                            </div>
                            <div class="admin-movies__item-body">

                            </div>
                        </div>
                        <div class="admin-movies__items">
                            <div class="admin-movies__item-header">
                                {{ __('Загрузка афиши:') }}
                            </div>
                            <div class="admin-movies__item-body">

                            </div>
                        </div>
                        <div class="admin-movies__items">
                            <div class="admin-movies__item-header">
                                {{ __('Загрузка медиа-файлов:') }}
                            </div>
                            <div class="admin-movies__item-body">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
