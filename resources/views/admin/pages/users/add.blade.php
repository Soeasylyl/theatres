@php
    use App\Enums\RolesUsersEnum;
@endphp

@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">{{ __('Создание нового пользователя') }} </div>
            <form method="POST" action="{{ route('users.create') }}">
                @csrf
                <div class="admin-container__grid">


                    <div>
                        <div class="admin-container__items">
                            <label for="name">{{ __('Имя') }}</label>

                            <div class="login-container__card-item">
                                <input id="name" type="text"
                                       class="login-container__form-control @error('name') is-invalid @enderror"
                                       name="name"
                                       value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span role="alert">
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="admin-container__items">
                            <label for="email">{{ __('Email Адрес') }}</label>

                            <div class="login-container__card-item">
                                <input id="email" type="email"
                                       class="login-container__form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span role="alert">
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="admin-container__items">
                            <label for="phone">{{ __('Телефон') }}</label>

                            <div class="login-container__card-item">
                                <input id="phone" type="phone"
                                       class="login-container__form-control @error('phone') is-invalid @enderror"
                                       name="phone"
                                       value="{{ old('phone') }}" required autocomplete="phone">
                                @error('phone')
                                <span role="alert">
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <div>
                        <div class="admin-container__items">
                            <label>{{ __('Выберите кинотеатр') }}:</label>
                            <div class="login-container__card-item">
                                <select name="cinema" class="admin-container__select">
                                    <option value="" disabled selected>{{ __('Список кинотеатров') }}</option>
                                    @foreach($cinemas as $cinema)
                                        <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                                    @endforeach
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

                        <div class="admin-container__items">
                            <label for="password">{{ __('Пароль') }}</label>
                            <div class="login-container__card-item">
                                <input id="password" type="password"
                                       class="login-container__form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       required autocomplete="new-password">

                                @error('password')
                                <span role="alert">
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="admin-container__items">
                            <label for="password-confirm">{{ __('Подтверждение пароля') }}</label>

                            <div class="login-container__card-item">
                                <input id="password-confirm" type="password" class="login-container__form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
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
