@extends('auth.layouts.app')

@section('content')
    <div class="login-container" >
        <div class="login-container__wrapper" style="max-width: 500px">
            <div class="login-container__card-header">{{ __('Сброс пароля') }}</div>
            <div class="login-container__card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="login-container__card-item">
                        <label for="email" >{{ __('Email Адрес') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="login-container__form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                        <div class="login-container__button-wrapper" style="justify-content: center">
                            <button type="submit" class="login-container__btn">
                                {{ __('Отправить ссылку для сброса пароля') }}
                            </button>
                        </div>
                </form>
            </div>

        </div>
    </div>
@endsection
