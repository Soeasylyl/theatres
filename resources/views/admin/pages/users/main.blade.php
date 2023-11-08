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
                    <tbody>
                    @forelse($users as $user)
                        <tr class="{{ $user->blocked_until ? 'ban' : '' }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->isoFormat('D MMMM YYYY') : __('Не верифицирован') }}</td>
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
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="23"
                                             viewBox="0 0 1024 1024">
                                            <path fill="#000"
                                                  d="M846.183 388.811l-361.159 361.586-83.378-83.378 361.347-361.398 83.19 83.19zM868.797 366.17l-83.178-83.178 55.274-55.282c12.523-12.525 32.766-12.428 45.33 0.102l37.754 37.65c12.541 12.506 12.633 32.815 0.153 45.309l-55.334 55.399zM380.919 691.546l79.851 79.851-100.317 19.755 20.465-99.606zM704 320v0l-192-224h-351.912c-35.395 0-64.088 28.747-64.088 64.235v735.531c0 35.476 28.51 64.235 63.918 64.235h480.165c35.301 0 63.918-28.743 63.918-63.705v-320.295l242.563-242.563c25.094-25.094 25.155-65.719 0.309-90.565l-37.744-37.744c-24.924-24.924-65.199-25.057-90.565 0.309l-114.563 114.563zM672 608v288.211c0 17.55-14.326 31.789-31.999 31.789h-480.003c-17.448 0-31.999-14.262-31.999-31.855v-736.291c0-17.286 14.264-31.855 31.858-31.855h320.142v159.811c0 35.82 28.624 64.189 63.933 64.189h128.067l-320 320-32 160 160-32 192-192zM512 144l150.398 176h-118.503c-17.475 0-31.896-14.453-31.896-32.281v-143.719z"></path>
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('user.delete', $user->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <div class="admin-container__table_last_cell_trash"
                                             data-username="{{ $user->name }}"
                                             title="{{ __('Удалить') }}">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="23"
                                                 viewBox="0 0 1024 1024">
                                                <path fill="#000"
                                                      d="M672 192h128v32h-544v-32h128v-32c0-35.593 28.616-64 63.917-64h160.167c35.249 0 63.917 28.654 63.917 64v32zM256 256h544v607.956c0 53.066-42.982 96.044-96.004 96.044h-351.992c-53.317 0-96.004-43.001-96.004-96.044v-607.956zM288 288v576.295c0 35.184 28.589 63.705 63.74 63.705h352.519c35.203 0 63.74-28.743 63.74-63.705v-576.295h-480zM384 352v512h32v-512h-32zM512 352v512h32v-512h-32zM640 352v512h32v-512h-32zM448.094 128c-17.725 0-32.094 14.204-32.094 32v32h224v-32c0-17.673-14.012-32-32.094-32h-159.813z"></path>
                                            </svg>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('Нет доступных пользователей') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $users->links('admin.partials.pagination') }}
            </div>
        </div>
    </div>
@endsection
