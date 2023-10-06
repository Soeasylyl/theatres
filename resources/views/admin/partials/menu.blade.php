

<nav class="admin-menu">
    <ul class="admin-menu__items">
        <li class="admin-menu__item {{ Route::currentRouteName() === 'admin' ? 'active' : '' }}">
            <a href="{{ route('admin') }}">{{ __('Главная страница') }}</a>
        </li>
        <li class="admin-menu__item {{ Route::currentRouteName() === 'theatres' ? 'active' : '' }}">
            <a href="{{ route('theatres') }}">{{ __('Кинотеатры') }}</a>
        </li>
        <li class="admin-menu__item {{ Route::currentRouteName() === 'movies' ? 'active' : '' }}">
            <a href="{{ route('movies') }}">{{ __('Фильмы') }}</a>
        </li>
        <li class="admin-menu__item {{ Route::currentRouteName() === 'users' ? 'active' : '' }}">
            <a href="{{ route('users') }}">{{ __('Пользователи') }}</a>
        </li>
        <li class="admin-menu__item {{ Route::currentRouteName() === 'roles' ? 'active' : '' }}">
            <a href="{{ route('roles') }}">{{ __('Роли') }}</a>
        </li>
    </ul>
</nav>
