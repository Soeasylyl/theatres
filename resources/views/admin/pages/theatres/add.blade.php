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

                            <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'name'"
                                     input_required>
                                {{ __('Название кинотеатра:') }}
                            </x-input>

                            <x-textarea :inputAttributes="[
                                        'name'=>'description',
                                        'pattern' => '^.{0,1000}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                        :errorAttribute="'description'"
                                        >{{ __('Описание кинотеатра:') }}</x-textarea>

                        </div>
                        <div class="admin-theatres__form-right">

                            <x-input :inputAttributes="[
                                        'name'=>'address',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'address'"
                                     input_required>
                                {{ __('Адрес кинотеатра:') }}
                            </x-input>

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
                                    <input id="theatreImageInput" type="file" name="theatreImages[]"
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

