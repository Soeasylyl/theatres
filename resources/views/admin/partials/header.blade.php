<header class="admin-header">
    <div class="admin-header__wrapper">
        <a class="admin-header__logo" href="{{ route('admin') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Логотип">
            <div>{{ __('Админ-панель') }}</div>
        </a>

        <div class="admin-header__content">
            <a href="{{ route('user.edit', auth()->user()->id) }}"
               class="admin-header__button">
                <img src="{{ asset('images/svg/user.svg') }}" alt="Мой профиль">
                <div>{{ __('Мой профиль') }}</div>
            </a>

            <a href="{{ route('logout') }}"
               class="admin-header__button-logout"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                <img src="{{ asset('images/svg/exit.svg') }}" alt="Логотип">
                <div>{{ __('Выход') }}</div>
            </a>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

</header>
