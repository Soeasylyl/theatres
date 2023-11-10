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

                    @if(session('successMessages'))
                        <div class="success-messages">
                            {{ session('successMessages') }}
                        </div>
                    @endif

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
                    <tbody class="admin-container__table-search">
                    @include('admin.partials.search-users')
                    </tbody>
                </table>
                {{ $users->links('admin.partials.pagination') }}
            </div>
        </div>
    </div>
@endsection
