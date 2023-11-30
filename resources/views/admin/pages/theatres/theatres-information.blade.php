@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">
                {{ __('Список Кинотеатров') }}
                @if(session('error_delete_movie'))
                    <div class="error-messages">
                        {{ session('error_delete_movie') }}
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
                @hasrole(\App\Enums\RolesUsersEnum::SUPER_ADMIN->value . '|' . App\Enums\RolesUsersEnum::CINEMA_ADMIN->value)
                <div class="admin-container__menu">
                    <a class="page-wrapper__panel-btn"
                       href="{{ route('theatre.create') }}"> {{ __('Добавить кинотеатр') }}</a>

                    <form method="get" action="{{ route('theatres') }}" class="admin-container__search-wrapper">

                        <div class="admin-container__search-element-wrapper">
                            <input name="search" type="text"
                                   class="admin-container__search-bar"
                                   placeholder="{{ __('Поиск кинотеатра') }}">
                            @error('search')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="submit" class="page-wrapper__panel-btn">
                            {{ __('Поиск') }}
                        </button>
                    </form>
                </div>
                @endhasrole
                <table class="admin-container__table">
                    <thead>
                    <th>{{ __('Название') }}</th>
                    <th>{{ __('Адрес') }}</th>
                    <th>{{ __('Количество залов') }}</th>

                    @hasrole(\App\Enums\RolesUsersEnum::SUPER_ADMIN->value . '|' . App\Enums\RolesUsersEnum::CINEMA_ADMIN->value)
                    <th>{{ __(' ') }}</th>
                    @endhasrole
                    </thead>
                    <tbody>
                    @forelse($theatres as $theatre)
                        <tr>
                            <td>{{ $theatre->name }}</td>
                            <td>{{ $theatre->address }}</td>
                            <td>{{ $theatre->halls->count() }}</td>
                            @hasrole(\App\Enums\RolesUsersEnum::SUPER_ADMIN->value . '|' . App\Enums\RolesUsersEnum::CINEMA_ADMIN->value)
                            <td>
                                <div class="admin-container__table_last_cell">
                                    <a href="{{ route('theatre.edit', $theatre) }}"
                                       class="admin-container__table_last_cell_edit"
                                       title="{{ __('Редактировать') }}">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="23"
                                             viewBox="0 0 1024 1024">
                                            <path fill="#000"
                                                  d="M846.183 388.811l-361.159 361.586-83.378-83.378 361.347-361.398 83.19 83.19zM868.797 366.17l-83.178-83.178 55.274-55.282c12.523-12.525 32.766-12.428 45.33 0.102l37.754 37.65c12.541 12.506 12.633 32.815 0.153 45.309l-55.334 55.399zM380.919 691.546l79.851 79.851-100.317 19.755 20.465-99.606zM704 320v0l-192-224h-351.912c-35.395 0-64.088 28.747-64.088 64.235v735.531c0 35.476 28.51 64.235 63.918 64.235h480.165c35.301 0 63.918-28.743 63.918-63.705v-320.295l242.563-242.563c25.094-25.094 25.155-65.719 0.309-90.565l-37.744-37.744c-24.924-24.924-65.199-25.057-90.565 0.309l-114.563 114.563zM672 608v288.211c0 17.55-14.326 31.789-31.999 31.789h-480.003c-17.448 0-31.999-14.262-31.999-31.855v-736.291c0-17.286 14.264-31.855 31.858-31.855h320.142v159.811c0 35.82 28.624 64.189 63.933 64.189h128.067l-320 320-32 160 160-32 192-192zM512 144l150.398 176h-118.503c-17.475 0-31.896-14.453-31.896-32.281v-143.719z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            @endhasrole
                        </tr>
                    @empty
                        <h2> {{ __('Кинотеатры не найдены.') }} </h2>
                    @endforelse
                    </tbody>
                </table>
                {{ $theatres->appends(['search' => $searchTern])->links('admin.partials.pagination') }}
            </div>
        </div>
    </div>
@endsection
