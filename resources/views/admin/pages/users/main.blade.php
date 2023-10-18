@php
    use App\Enums\RolesUsersEnum;
@endphp

@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">
                {{ __('Список пользователей') }}
                @if(session('error_delete_user'))
                    <div class="error-messages">
                        {{ session('error_delete_user') }}
                    </div>
                @endif
                <div class="success-messages-wrapper">
                    @php
                        $successMessages = ['success_delete_user', 'success_create_user'];
                    @endphp
                    @foreach($successMessages as $message)
                        @if(session($message))
                            <div class="success-messages">
                                {{ session($message) }}
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="admin-container__form-body">
                <div class="admin-container__menu">
                    <a class="page-wrapper__panel-btn"
                       href="{{ route('users.create') }}"> {{ __('Добавить пользователя') }}</a>
                    <input class="admin-container__search-bar" type="text"
                           placeholder="{{ __('Поиск пользователей') }}">
                </div>
                <table class="admin-container__table">
                    <thead>
                    <th>{{ __('Имя') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Телефон') }}</th>
                    <th>{{ __('Дата регистрации') }}</th>
                    <th>{{ __('Роль') }}</th>
                    <th>{{ __(' ') }}</th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d.m.Y') : __('Не верифицирован') }}</td>
                            <td>
                                @forelse($user->roles as $role)
                                    {{ RolesUsersEnum::getDescription(RolesUsersEnum::from($role->name)) }}
                                @empty
                                    {{ __('Без роли') }}
                                @endforelse

                            </td>
                            <td>
                                <div class="admin-container__table_last_cell">
                                    <a href="{{ route('user.edit', $user->id) }}"
                                       class="admin-container__table_last_cell_edit"
                                       title="{{ __('Редактировать') }}">
                                        {!! file_get_contents(public_path('/images/svg/edit.svg')) !!}
                                    </a>

                                    <form method="POST" action="{{ route('user.delete', $user->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <div class="admin-container__table_last_cell_trash"
                                             data-username="{{ $user->name }}"
                                             title="{{ __('Удалить') }}">
                                            {!! file_get_contents(public_path('/images/svg/delete.svg')) !!}
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
