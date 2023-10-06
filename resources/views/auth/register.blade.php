@extends('admin.layouts.app')

@section('content')
    <div class="login-container">
        <div class="login-container__wrapper" >
            <div class="login-container__card-header">{{ __('Регистрация') }} </div>
            <div class="login-container__card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="login-container__card-item">
                        <label for="name">{{ __('Имя') }}</label>

                        <div class="login-container__card-item">
                            <input id="name" type="text"
                                   class="login-container__form-control @error('name') is-invalid @enderror" name="name"
                                   value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="login-container__card-item">
                        <label for="email">{{ __('Email Адрес') }}</label>

                        <div class="login-container__card-item">
                            <input id="email" type="email"
                                   class="login-container__form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="login-container__card-item">
                        <label for="phone">{{ __('Телефон') }}</label>

                        <div class="login-container__card-item">
                            <input id="phone" type="phone"
                                   class="login-container__form-control @error('phone') is-invalid @enderror"
                                   name="phone"
                                   value="{{ old('phone') }}" required autocomplete="phone">
                            @error('phone')
                            <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="login-container__card-item">
                        <label for="password">{{ __('Пароль') }}</label>
                        <div class="login-container__card-item">
                            <input id="password" type="password"
                                   class="login-container__form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="new-password">

                            @error('password')
                            <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="login-container__card-item">
                        <label for="password-confirm">{{ __('Подтверждение пароля') }}</label>

                        <div class="login-container__card-item">
                            <input id="password-confirm" type="password" class="login-container__form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="login-container__button-wrapper" style="justify-content: center">
                        <button type="submit" class="login-container__btn" style="width: 66%">
                            {{ __('Регистрация') }}
                        </button>
                    </div>

                </form>
            </div>


        </div>
@endsection
