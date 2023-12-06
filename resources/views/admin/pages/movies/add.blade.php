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
                            <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'name'"
                                     input_required>
                                {{ __('Название фильма:') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'date_start',
                                        'type' => 'datetime-local',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'date_start'"
                                     input_required>
                                {{ __('Дата мировой премьеры:') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'session_duration',
                                        'pattern' => '^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'session_duration'"
                                     input_required>
                                {{ __('Длительность фильма (формат 02:12:00):') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'rating',
                                        'pattern' => '^(?:10|[1-9](?:\.\d)?)$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'rating'"
                                     input_required>
                                {{ __('Рэйтинг фильма от 1.1 до 10:') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'age_limit',
                                        'pattern' => '^(?:[0-9]|1[0-9]|21)$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'age_limit'"
                                     input_required>
                                {{ __('Возрастное ограничение (до 21 года):') }}
                            </x-input>
                        </div>
                        <div class="admin-movies__form-right">
                            <x-textarea :inputAttributes="[
                                        'name'=>'description',
                                        'pattern' => '^.{0,1000}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                        :errorAttribute="'description'"
                                        input_required
                            >{{ __('Описание сюжета фильма:') }}</x-textarea>
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
