@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-movies">
                <div class="admin-container__form-header">
                    {{ __('Редактирование информации') }}
                </div>

                @if (session('error'))
                    <div class="error-messages">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="success-messages-wrapper">
                    @if(session('success_update_role'))
                        <div class="success-messages">
                            {{ session('success_update_role') }}
                        </div>
                    @endif
                </div>

                <div class="admin-movies__body">
                    <form method="POST"
                          action="{{ route('movie.update',  ['movie' => $movie->id]) }}"
                          class="admin-movies__form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="admin-movies__form-left">

                            <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'value' => $movie->name,
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
                                        'value' => $movie->date_start,
                                         ]"
                                     :errorAttribute="'date_start'"
                                     input_required>
                                {{ __('Дата мировой премьеры:') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'session_duration',
                                        'required'=>'required',
                                        'pattern' => '^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$',
                                        'autocomplete' => 'off',
                                        'value' => $movie->session_duration,
                                         ]"
                                     :errorAttribute="'session_duration'"
                                     input_required>
                                {{ __('Длина фильма в формате (02:12:00):') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'rating',
                                        'required'=>'required',
                                        'pattern' => '^(?:10|[1-9](?:\.\d)?)$',
                                        'autocomplete' => 'off',
                                        'value' => $movie->rating,
                                         ]"
                                     :errorAttribute="'rating'"
                                     input_required>
                                {{ __('Рэйтинг фильма (от 1.1 до 10):') }}
                            </x-input>

                            <x-input :inputAttributes="[
                                        'name'=>'age_limit',
                                        'required'=>'required',
                                        'pattern' => '^(?:[0-9]|1[0-9]|21)$',
                                        'autocomplete' => 'off',
                                        'value' =>  $movie->age_limit,
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
                                        :text-content="$movie->description"
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
                                {{ __('Сохранить изменения') }}
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('movie.delete', $movie->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="page-wrapper__panel-btn-wrapper grid-center-item"
                             style="margin-left: auto; display: block; width: 20%">
                            <button type="submit" class="page-wrapper__panel-btn "
                                    onclick="return confirm('Вы уверены, что хотите удалить фильм {{ $movie->name }}?')">
                                {{ __('Удалить фильм') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
