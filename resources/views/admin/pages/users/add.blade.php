@php
    use App\Enums\RolesUsersEnum;
@endphp

@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">{{ __('Создание нового пользователя') }} </div>
            @if (session('error'))
                <div class="error-messages">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.store') }}">
                @csrf
                <div class="admin-container__grid">
                    <div>
                        <x-input :inputAttributes="[
                                        'name'=>'name',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                 :errorAttribute="'name'"
                                 input_required>
                            {{ __('Имя пользователя:') }}
                        </x-input>

                        <x-input :inputAttributes="[
                                        'name'=>'email',
                                        'type' => 'email',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                 :errorAttribute="'email'"
                                 input_required>
                            {{ __('Email Адрес:') }}
                        </x-input>

                        <x-input :inputAttributes="[
                                        'name'=>'phone',
                                        'type' => 'phone',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                 :errorAttribute="'phone'"
                                 input_required>
                            {{ __('Номер телефона:') }}
                        </x-input>

                    </div>
                    <div>
                        <div class="admin-container__items">
                            <label>{{ __('Выберите кинотеатр') }}:</label>
                            <div class="login-container__card-item">
                                <select name="cinema" class="admin-container__select">
                                    <option value="" disabled selected>{{ __('Список кинотеатров') }}</option>
                                    @forelse($cinemas as $cinema)
                                        <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                                    @empty
                                        <tr>
                                            <td>{{ __('Фильмов не существует') }}</td>
                                        </tr>
                                    @endforelse
                                    <option value="{{ null }}"> {{ __('Без кинотеатра') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="admin-container__items">
                            <label>{{ __('Выберите роль') }}:</label>
                            <div class="login-container__card-item">
                                <select name="role" class="admin-container__select">
                                    <option value="" disabled selected>{{ __('Список ролей') }}</option>
                                    @foreach(RolesUsersEnum::asSelectArray() as $role)
                                        @if ($role['value'] !==  RolesUsersEnum::SUPER_ADMIN->value)
                                            <option value="{{ $role['value'] }}"> {{ $role['name'] }}</option>
                                        @endif
                                    @endforeach
                                    <option value="{{ null }}"> {{ __('Без роли') }}</option>
                                </select>
                            </div>
                        </div>

                        <x-input :inputAttributes="[
                                        'name'=>'password',
                                        'type' => 'password',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                 :errorAttribute="'password'"
                                 input_required>
                            {{ __('Введите пароль:') }}
                        </x-input>

                        <x-input :inputAttributes="[
                                        'name'=>'password_confirmation',
                                        'type' => 'password',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                 :errorAttribute="'password_confirmation'"
                                 input_required>
                            {{ __('Подтвердите пароль:') }}
                        </x-input>

                    </div>

                </div>
                <div class="login-container__button-wrapper" style="justify-content: center">
                    <button type="submit" class="login-container__btn" style="width: 50%">
                        {{ __('Создать пользователя') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
