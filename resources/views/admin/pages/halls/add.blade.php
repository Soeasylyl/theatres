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
                          action="{{route('hall.store', ['theatres' => $theatreId])}}"
                          enctype="multipart/form-data">
                        <div class="admin-halls__form">
                            @csrf
                            @method('POST')
                            <div class="admin-halls__form-left">
                                <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                         :errorAttribute="'name'"
                                         input_required>
                                    {{ __('Название зала:') }}
                                </x-input>

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
                                <x-textarea :inputAttributes="[
                                        'name'=>'description',
                                        'pattern' => '^.{0,1000}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                            :errorAttribute="'description'"
                                            input_required
                                >{{ __('Описание зала:') }}</x-textarea>

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

