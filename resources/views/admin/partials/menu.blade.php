<nav class="admin-menu">
    <ul class="admin-menu__items">
        <li class="admin-menu__item {{ Route::currentRouteName() === 'admin' ? 'active' : '' }}">
            <a href="{{ route('admin') }}">{{ __('Главная страница') }}</a>
        </li>
        <li class="admin-menu__item {{ Route::currentRouteName() === 'theatres' ? 'active' : '' }}">
            <a href="{{ route('admin.theatres') }}">{{ __('Кинотеатры') }}</a>
        </li>
        <li class="admin-menu__item {{ Route::currentRouteName() === 'movies' ? 'active' : '' }}">
            <a href="{{ route('admin.movies') }}">{{ __('Фильмы') }}</a>
        </li>
        @if(!auth()->user()->hasRole(App\Enums\RolesUsersEnum::CINEMA_MANAGER->value))
            <li class="admin-menu__item {{ Route::currentRouteName() === 'users' ? 'active' : '' }}">
                <a href="{{ route('users') }}">{{ __('Пользователи') }}</a>
            </li>
        @endif

    </ul>
</nav>
