@php
    use App\Enums\RolesUsersEnum;
@endphp

@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">

        {{--                            Отображение роли для профиля--}}
        <div class="admin-container__items">
            <label for="current_password">{{ __('Текущая роль пользователя:') }}</label>
            <label class="admin-container__label"> @if ($userRole)
                    {{ RolesUsersEnum::getDescription(RolesUsersEnum::from($userRole->name)) }}
                @else
                    {{ __('Роль не определена') }}
                @endif
            </label>
        </div>

        <div class="admin-container__form">
            <div class="admin-container__grid">
                <div class="admin-container__grid-left">
                    <div class="admin-container__form-header">
                        {{ __('Редактирование информации') }}
                    </div>
                    <div class="admin-container__form-body">
                        <form method="POST" action="{{ route('admin.profile.updateInfo', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="success-messages-wrapper">
                                @if(session('success_update_profile_info'))
                                    <div class="success-messages">
                                        {{ session('success_update_profile_info') }}
                                    </div>
                                @endif
                            </div>
                            <div class="admin-container__items">
                                <label for="name">{{ __('Имя пользователя:') }}</label>
                                <div>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }} "
                                           autocomplete="off" required>
                                    @error('name')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="admin-container__items">
                                <label for="email">{{ __('Email адрес:') }}</label>
                                <div>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', $user->email) }}" required
                                           autocomplete="off">
                                    @error('email')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="admin-container__items">
                                <label for="phone"> {{ __('Номер телефона:') }}</label>
                                <div>
                                    <input type="text" id="phone" name="phone"
                                           value="{{ old('phone', $user->phone) }}"
                                           autocomplete="off">
                                    @error('phone')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="page-wrapper__panel-btn-wrapper">
                                <button type="submit"
                                        class="page-wrapper__panel-btn">{{ __('Сохранить информацию') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="admin-container__grid-right">
                    <div class="admin-container__form-header">
                        {{ __('Изменение пароля') }}
                    </div>
                    <div class="admin-container__form-body">
                        <form method="POST" action="{{ route('admin.profile.updatePassword', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="success-messages-wrapper">
                                @if(session('success_update_profile_password'))
                                    <div class="success-messages">
                                        {{ session('success_update_profile_password') }}
                                    </div>
                                @endif
                            </div>

                            <div class="admin-container__items">
                                <label for="current_password">{{ __('Введите старый пароль:') }}</label>
                                <div>
                                    <input type="password" id="current_password" name="current_password"
                                           required>
                                    @error('current_password')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="admin-container__items">
                                <label for="new_password">{{ __('Введите новый пароль:') }}</label>
                                <div>
                                    <input type="password" id="new_password" name="new_password" required>
                                    @error('new_password')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="admin-container__items">
                                <label for="new_password_confirmation">{{ __('Повторите новый пароль:') }}</label>
                                <div>
                                    <input type="password" id="new_password_confirmation"
                                           name="new_password_confirmation" required>
                                    @error('new_password_confirmation')
                                    <div class="error-messages">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="page-wrapper__panel-btn-wrapper">
                                <button type="submit"
                                        class="page-wrapper__panel-btn">{{ __('Изменить пароль') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (!RolesUsersEnum::class || $userRole->name != RolesUsersEnum::SUPER_ADMIN->value)
            <div class="admin-container__form grid-center-item">
                <div class="admin-container__form-header">
                    {{ __('Удаление пользователя') }}
                </div>

                <div class="admin-container__form-body">
                    <form method="POST" action="{{ route('user.delete', $user->id) }}">
                        @csrf
                        @method('DELETE')

                        <div class="page-wrapper__panel-btn-wrapper">
                            <button type="submit" class="page-wrapper__panel-btn"
                                    onclick="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}?')">{{ __('Удалить пользователя?') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
