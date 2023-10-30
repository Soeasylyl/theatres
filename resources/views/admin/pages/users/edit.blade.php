@php
    use App\Enums\RolesUsersEnum;
@endphp

@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        @php
            //FIXME: Сделать через роли, а не по ID
        @endphp
        @if($authUser->id === $user->id)
            <div class="admin-container__form">
                <div class="admin-container__items">
                    <label for="current_password">{{ __('Текущая роль пользователя:') }}</label>
                    <label class="admin-container__label">
                        @if ($userRole)
                            {{ RolesUsersEnum::getDescription(RolesUsersEnum::from($userRole->name)) }}
                        @else
                            {{ __('Роль не определена') }}
                        @endif
                    </label>
                </div>
                @endif

                <div class="admin-container__items">
                    <label for="current_password">{{ __('Кинотеатры к которым относится пользователь:') }}</label>
                    <label class="admin-container__label">
                        @if($user->cinemas->isNotEmpty())
                            {{ $user->cinemas->pluck('name')->implode(', ') }}
                        @else
                            {{ __('Нет кинотеатра') }}
                        @endif
                    </label>
                </div>

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
                                        {{ RolesUsersEnum::getDescription(RolesUsersEnum::from($role->name)) }}
                                    @empty
                                        {{ __('Без роли') }}
                                    @endforelse
                                </label>
                            </div>

                            <form method="POST" action="{{ route('user.updateRole', ['user' => $user->id]) }}">
                                @csrf
                                @method('PUT')
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
                                            @foreach(RolesUsersEnum::asSelectArray() as $role)
                                                @if ($role['value'] !==  RolesUsersEnum::SUPER_ADMIN->value)
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
                                          action="{{ $authUser->can(\App\Enums\PermissionsUsersEnum::MANAGE_USERS->value) ? route('user.update', $user->id) : route('user.updateProfile', $user->id)   }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="success-messages-wrapper">
                                            @if(session('message'))
                                                <div class="success-messages">
                                                    {{ session('message') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="admin-container__items">
                                            <label for="name">{{ __('Имя пользователя:') }}</label>
                                            <div>
                                                <input type="text" id="name" name="name"
                                                       value="{{ old('name', $user->name) }} "
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
                                    <form method="POST"
                                          @if($user->id === $authUser->id)
                                              action="{{ route('user.updatePasswordProfile', $user->id) }}"
                                          @else
                                              action="{{
                                                            $authUser->can(\App\Enums\PermissionsUsersEnum::MANAGE_USERS->value) ?
                                                            route('user.updatePassword', $user->id) : route('user.updatePasswordProfile', $user->id)
                                              }}"
                                        @endif>
                                        @csrf
                                        @method('PUT')

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
                                            <div class="admin-container__items">
                                                <label for="current_password">{{ __('Введите старый пароль:') }}</label>
                                                <div>
                                                    <input type="password" id="current_password" name="current_password"
                                                           required placeholder="{{ __('Текущий пароль') }}">
                                                    @error('current_password')
                                                    <div class="error-messages">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                        <div class="admin-container__items">
                                            <label for="new_password">{{ __('Введите новый пароль:') }}</label>
                                            <div>
                                                <input type="password" id="new_password" name="new_password"
                                                       required placeholder="{{ __('Новый пароль') }}">
                                                @error('new_password')
                                                <div class="error-messages">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="admin-container__items">
                                            <label
                                                for="new_password_confirmation">{{ __('Повторите новый пароль:') }}</label>
                                            <div>
                                                <input type="password" id="new_password_confirmation"
                                                       name="new_password_confirmation" required
                                                       placeholder="{{ __('Новый пароль') }}">
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
                </div>

                @if(!($authUser->id === $user->id))
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
