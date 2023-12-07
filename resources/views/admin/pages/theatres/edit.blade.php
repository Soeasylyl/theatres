@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-theatres">
                <div class="admin-container__form-header">
                    {{ __('Редактирование данных Кинотеатра') }}
                </div>
                @if(session('successMessages'))
                    <div class="success-messages">{{ session('successMessages') }}</div>
                @endif
                @if (session('error'))
                    <div class="error-messages">{{ session('error') }}</div>
                @endif
                @error('seat_name')
                <div class="error-messages">{{$message}}</div>
                @enderror
                @error('seat_description')
                <div class="error-messages">{{$message}}</div>
                @enderror
                @error('seat_amount')
                <div class="error-messages">{{$message}}</div>
                @enderror
                <div class="admin-theatres__body">
                    <div class="admin-theatres__body-wrapper">
                        <form method="POST"
                              action="{{ route('theatre.update', ['theatres' => $theatre->id]) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="admin-theatres__form-left">

                                <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'value' => $theatre->name,
                                         ]"
                                         :errorAttribute="'name'"
                                         input_required>
                                    {{ __('Название кинотеатра:') }}
                                </x-input>

                                <x-input :inputAttributes="[
                                        'name'=>'address',
                                        'pattern' => '^.{1,100}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'value' => $theatre->address,
                                         ]"
                                         :errorAttribute="'address'"
                                         input_required>
                                    {{ __('Адрес кинотеатра:') }}
                                </x-input>

                                <x-textarea :inputAttributes="[
                                        'name'=>'description',
                                        'pattern' => '^.{0,1000}$',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                            :errorAttribute="'description'"
                                            :text-content="$theatre->description"
                                            input_required
                                >{{ __('Описание кинотеатра:') }}</x-textarea>

                                <div class="admin-theatres__items">
                                    @error('$theatreImages')
                                    <div class="error-messages">{{$message}}</div>
                                    @enderror
                                    @error('$theatreImages.*')
                                    <div class="error-messages">{{$message}}</div>
                                    @enderror
                                    <div id="previewTheatreImage" class="admin-theatres__preview-container"></div>
                                    <div class="admin-theatres__item-header">
                                        {{ __('Загрузка изображений кинотеатра:') }}
                                    </div>
                                    <div class="admin-theatres__item-body">
                                        <input id="theatreImageInput" type="file" name="theatreImages[]"
                                               autocomplete="off" multiple>
                                    </div>
                                </div>
                                <div class="login-container__button-wrapper" style="justify-content: center">
                                    <button type="submit" class="login-container__btn" style="width: 50%">
                                        {{ __('Сохранить изменения') }}
                                    </button>
                                </div>

                            </div>
                        </form>
                        <div class="admin-theatres__form-right">
                            <div class="admin-theatres__items">
                                <div class="admin-theatres__item-header">
                                    {{ __('Доступные типы мест:') }}
                                </div>
                                <table class="admin-theatres__table">
                                    <thead>
                                    <th>{{ __('Название') }}</th>
                                    <th>{{ __('Цена за место') }}</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @forelse($seatsTypes as $seatsType)
                                        <tr class="admin-theatres__edit_theatres"
                                            data-seat-type-id="{{ $seatsType->id }}">
                                            <td class="admin-theatres__seat-type-name">{{ $seatsType->name }}</td>
                                            <td class="admin-theatres__seat-type-amount">{{ $seatsType->amount }}</td>
                                            <td class="admin-theatres__seat-type-description"
                                                style="display: none">{{ $seatsType->description }}</td>
                                            <td>
                                                <form method="POST"
                                                      action="{{ route('seat-type.delete', $theatre->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="seat_type_id"
                                                           value="{{ $seatsType->id }}">
                                                    <div class="admin-theatres__delete-seat-type-icon"
                                                         data-seats-type-name="{{ $seatsType->name }}">
                                                        <svg width="32"
                                                             height="32"
                                                             viewBox="0 0 32 32">
                                                            <title>{{ __('Удалить') }}</title>
                                                            <path
                                                                    d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
                                                        </svg>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>{{ __('Типов мест не найдено') }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <a class="login-container__btn open-add-seat-type-btn"
                                   style="justify-content: center; display: flex;">{{ __('Добавить новый тип мест') }}</a>
                            </div>

                            <div class="admin-theatres__items">
                                <div class="admin-theatres__item-header">{{ __('Доступные залы:') }}</div>
                                <table class="admin-theatres__table">
                                    <thead>
                                    <th>{{ __('Название зала') }}</th>
                                    <th>{{ __('Количество мест') }}</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @forelse($halls as $hall)
                                        <tr>
                                            <td>{{ $hall->name }}</td>
                                            <td>{{ $hall->seats->count() }}</td>
                                            <td>
                                                <form method="POST" action=" {{ route('hall.delete', $theatre->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="hall_id" value="{{ $hall->id }}">
                                                    <div class="admin-theatres__delete-hall-icon"
                                                         data-hall-name="{{ $hall->name }}">
                                                        <svg width="32"
                                                             height="32"
                                                             viewBox="0 0 32 32">
                                                            <title>{{ __('Удалить') }}</title>
                                                            <path
                                                                    d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
                                                        </svg>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>{{ __('Залов не найдено') }}</td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>

                                <a class="login-container__btn"
                                   style="justify-content: center; display: flex; text-decoration: none;"
                                   href="{{ route('hall.create',['theatres' => $theatre->id]) }}">{{ __('Добавить новый зал') }}</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
