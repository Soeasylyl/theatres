@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        @if($authUser->id === $user->id)
            <div class="admin-container__form">
                <div class="admin-container__items">
                    <label for="current_password">{{ __('Текущая роль пользователя:') }}</label>
                    <label class="admin-container__label">
                        @if ($userRole)
                            {{ App\Enums\RolesUsersEnum::getDescription(App\Enums\RolesUsersEnum::from($userRole->name)) }}
                        @else
                            {{ __('Роль не определена') }}
                        @endif
                    </label>
                </div>
                @endif

                @if(!($user->hasRole(App\Enums\RolesUsersEnum::SUPER_ADMIN->value)) && !($user->hasRole(App\Enums\RolesUsersEnum::MODERATOR->value)))
                    <div class="admin-container__items">
                        <label for="current_password">{{ __('Кинотеатры к которым относится пользователь:') }}</label>
                        <label class="admin-container__label">
                            @if($userCinemasList->isNotEmpty())
                                {{ $userCinemasList->pluck('name')->implode(', ') }}
                            @else
                                {{ __('Нет кинотеатра') }}
                            @endif
                        </label>
                    </div>
                @endif
            </div>

            @if(!($authUser->id === $user->id))
                <div class="admin-container">
                    <div class="admin-container__form">
                        <div class="admin-container__form-header">
                            {{ __('Изменение роли') }}
                        </div>

                        <div class="success-messages-wrapper">
                            @if(session('success_update_role'))
                                <div class="success-messages">
                                    {{ session('success_update_role') }}
                                </div>
                            @endif
                        </div>

                        <div class="admin-container__form-body">
                            <div class="admin-container__items">
                                <label for="current_password">{{ __('Текущая роль пользователя:') }}</label>
                                <label class="admin-container__label">
                                    @forelse($user->roles as $role)
                                        {{ App\Enums\RolesUsersEnum::getDescription(App\Enums\RolesUsersEnum::from($role->name)) }}
                                    @empty
                                        {{ __('Без роли') }}
                                    @endforelse
                                </label>
                            </div>

                            <form method="POST" action="{{ route('user.updateRole', ['user' => $user->id]) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="error-messages__wrapper">
                                    @if(session('error_role'))
                                        <div class="error-messages">
                                            {{ session('error_role') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="admin-container__items">
                                    <label>{{ __('Выберите новую роль:') }}</label>
                                    <div class="login-container__card-item">
                                        <select name="role" class="admin-container__select">
                                            <option value="" disabled selected>{{ __('Список ролей') }}</option>
                                            @foreach(App\Enums\RolesUsersEnum::asSelectArray() as $role)
                                                @if ($role['value'] !==  App\Enums\RolesUsersEnum::SUPER_ADMIN->value)
                                                    <option
                                                        value="{{ $role['value'] }}"> {{ $role['name'] }}</option>
                                                @endif
                                            @endforeach
                                            <option value="{{ null }}"> {{ __('Без роли') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="page-wrapper__panel-btn-wrapper">
                                    <button type="submit"
                                            class="page-wrapper__panel-btn">{{ __('Сохранить роль') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endif

                    <div class="admin-container__form">
                        <div class="admin-container__grid">
                            <div class="admin-container__grid-left">
                                <div class="admin-container__form-header">
                                    {{ __('Редактирование информации') }}
                                </div>
                                @if (session('error'))
                                    <div class="error-messages">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="admin-container__form-body">
                                    <form method="POST"
                                          @if($user->id === $authUser->id)
                                              action="{{ route('user.updateProfile', $user->id) }}"
                                          @else
                                              action="{{ !$authUser->hasRole(\App\Enums\RolesUsersEnum::CINEMA_MANAGER->value) ?
                                                     route('user.update', $user->id) : route('user.updateProfile', $user->id)   }}"
                                        @endif>

                                        @csrf
                                        @method('PATCH')

                                        <div class="success-messages-wrapper">
                                            @if(session('message'))
                                                <div class="success-messages">
                                                    {{ session('message') }}
                                                </div>
                                            @endif
                                        </div>

                                        <x-input :inputAttributes="[
                                                'name'=>'name',
                                                'required'=>'required',
                                                'autocomplete' => 'off',
                                                'value' => $user->name,
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
                                                'value' => $user->email,
                                                 ]"
                                                 :errorAttribute="'email'"
                                                 input_required>
                                            {{ __('Email адрес:') }}
                                        </x-input>

                                        <x-input :inputAttributes="[
                                                    'name'=>'phone',
                                                    'required'=>'required',
                                                    'autocomplete' => 'off',
                                                    'value' => $user->phone,
                                                     ]"
                                                 :errorAttribute="'phone'"
                                                 input_required>
                                            {{ __('Номер телефона:') }}
                                        </x-input>

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
                                    <form method="POST"
                                          @if($user->id === $authUser->id)
                                              action="{{ route('user.updatePasswordProfile', $user->id) }}"
                                          @else
                                              action="{{
                                                        !$authUser->hasRole(\App\Enums\RolesUsersEnum::CINEMA_MANAGER->value) ?
                                                        route('user.updatePassword', $user->id) : route('user.updatePasswordProfile', $user->id)
                                              }}"
                                        @endif>
                                        @csrf
                                        @method('PATCH')

                                        <div class="success-messages-wrapper">
                                            @if(session('success_update_user_password'))
                                                <div class="success-messages">
                                                    {{ session('success_update_user_password') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="error-messages__wrapper">
                                            @if(session('password_error'))
                                                <div class="error-messages">
                                                    {{ session('password_error') }}
                                                </div>
                                            @endif
                                        </div>

                                        @if($authUser->id === $user->id)
                                            <x-input :inputAttributes="[
                                                    'name'=>'current_password',
                                                    'type' => 'password',
                                                    'required'=>'required',
                                                    'autocomplete' => 'off',
                                                     ]"
                                                     :errorAttribute="'current_password'"
                                                     input_required>
                                                {{ __('Введите старый пароль:') }}
                                            </x-input>
                                        @endif

                                        <x-input :inputAttributes="[
                                                    'name'=>'new_password',
                                                    'type' => 'password',
                                                    'required'=>'required',
                                                    'autocomplete' => 'off',
                                                     ]"
                                                 :errorAttribute="'new_password'"
                                                 input_required>
                                            {{ __('Введите новый пароль:') }}
                                        </x-input>

                                        <x-input :inputAttributes="[
                                                    'name'=>'new_password_confirmation',
                                                    'type' => 'password',
                                                    'required'=>'required',
                                                    'autocomplete' => 'off',
                                                     ]"
                                                 :errorAttribute="'new_password_confirmation'"
                                                 input_required>
                                            {{ __('Повторите новый пароль:') }}
                                        </x-input>

                                        <div class="page-wrapper__panel-btn-wrapper">
                                            <button type="submit"
                                                    class="page-wrapper__panel-btn">{{ __('Изменить пароль') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!($authUser->id === $user->id))
                    <div class="admin-container__form grid-center-item">
                        <div class="admin-container__form-header">
                            {{ __('Удаление/Блокировка пользователя') }}
                        </div>

                        <div class="admin-container__form-body">
                            <form method="POST" action="{{ route('user.delete', $user->id) }}">
                                @csrf
                                @method('DELETE')

                                <div class="page-wrapper__panel-btn-wrapper">
                                    <button type="submit" class="page-wrapper__panel-btn"
                                            onclick="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}?')">{{ __('Удалить пользователя?') }}</button>
                                    <div class="page-wrapper__block-wrapper"
                                         data-id="{{ $user->id }}"
                                         title="{{ __('Заблокировать') }}">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="23"
                                             viewBox="0 0 32 32">
                                            <path
                                                d="M27.314 4.686c-3.022-3.022-7.040-4.686-11.314-4.686s-8.292 1.664-11.314 4.686c-3.022 3.022-4.686 7.040-4.686 11.314s1.664 8.292 4.686 11.314c3.022 3.022 7.040 4.686 11.314 4.686s8.292-1.664 11.314-4.686c3.022-3.022 4.686-7.040 4.686-11.314s-1.664-8.292-4.686-11.314zM28 16c0 2.588-0.824 4.987-2.222 6.949l-16.727-16.727c1.962-1.399 4.361-2.222 6.949-2.222 6.617 0 12 5.383 12 12zM4 16c0-2.588 0.824-4.987 2.222-6.949l16.727 16.727c-1.962 1.399-4.361 2.222-6.949 2.222-6.617 0-12-5.383-12-12z"></path>
                                        </svg>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                @endif
    </div>

@endsection
