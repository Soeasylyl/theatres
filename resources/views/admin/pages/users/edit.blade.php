@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">

        <div class="admin-container__form">
            <div class="admin-container__grid">
                <div class="admin-container__grid-left">
                    <div class="admin-container__form-header">
                        {{ __('Редактирование информации') }}
                    </div>
                    <div class="admin-container__form-body">
                        <form method="POST" action="{{ route('user.updateInfo', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="admin-container__items">
                                <label for="name">{{ __('Имя пользователя:') }}</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }} "
                                       autocomplete="off" required>
                            </div>

                            <div class="admin-container__items">
                                <label for="email">{{ __('Email адрес:') }}</label>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $user->email) }}" required
                                       autocomplete="off">
                            </div>

                            <div class="admin-container__items">
                                <label for="phone"> {{ __('Номер телефона:') }}</label>
                                <input type="text" id="phone" name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       autocomplete="off">
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
                        {{ __('Изменение роли') }}
                    </div>
                    <div class="adminp-container__form-body">
                        <div class="admin-container__items">
                            <label for="current_password">{{ __('Текущая роль пользователя:') }}</label>
                            <label class="admin-container__label">
                                @if ($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        {{ $enumRole::getDescription($enumRole::from($role->name)) }}
                                    @endforeach
                                @else
                                    {{ __('Без роли') }}
                                @endif
                            </label>
                        </div>

                        <form method="POST" action="{{ route('user.updateRole', ['user' => $user->id]) }}">
                        @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="admin-container__items">
                                <label for="current_password">{{ __('Выберите новую роль: ') }}</label>
                                <select name="role" class="admin-container__select">
                                    <option value="" disabled selected>{{ __('Список ролей') }}</option>
                                    @foreach($enumRole::asSelectArray() as $role)
                                        @if ($role['value'] !==  'super-admin')
                                            <option value="{{ $role['value'] }}"> {{ $role['name'] }}</option>
                                        @endif
                                    @endforeach
                                    <option value="{{ null }}"> {{ __('Без роли') }}</option>

                                </select>
                            </div>

                            <div class="page-wrapper__panel-btn-wrapper">
                                <button type="submit"
                                        class="page-wrapper__panel-btn">{{ __('Сохранить роль') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
@endsection
