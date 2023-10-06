@extends('admin.layouts.app')

@section('content')
    <div class="login-container">
        <div class="login-container__wrapper">
                <div class="login-container__card-header">{{ __('Вход') }}</div>
                <div class="login-container__card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="login-container__card-item">
                            <label for="email">{{ __('Email Адрес') }}</label>
                            <div >
                                <input id="email" type="email" class="login-container__form-control" name="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="login-container__card-item">
                            <label for="password">{{ __('Пароль') }}</label>
                            <div >
                                <input id="password" type="password" class="login-container__form-control" name="password" required
                                       autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="login-container__card-item">
                                <div class="login-container__form-check">
                                    <input class="login-container__form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="login-container__form-check-label" for="remember">{{ __('Запомнить меня') }}</label>
                                </div>
                        </div>


                        <div class="login-container__button-wrapper">
                            <button type="submit" class="login-container__btn">{{ __('Вход')}}</button>
                            @if (Route::has('password.request'))
                                <a class="login-container__btn-link" href="{{ route('password.request') }}">{{ __('Забыли свой пароль?') }}</a>
                            @endif
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
