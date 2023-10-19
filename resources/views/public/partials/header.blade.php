<header id='headerId' class="header">
    <div class="container">
        <div class="header-wrapper">
            <div class="header-wrapper__hamburger"></div>
            <div class="header-wrapper__logo">
                <a href="{{ route('public.pages.home') }}">
                    {!! file_get_contents(public_path('/images/svg/logo.svg')) !!}
                </a>
                <span class="header-wrapper__text">{{ __('КиноБронь') }}</span>
            </div>
            <div class="header-wrapper__menu">
                <div class="header-wrapper__menu-container">
                    <div class="header-wrapper__menu-item">
                        <span class="header-wrapper__text">{{ __('Афиша') }}</span>
                    </div>
                    <div class="header-wrapper__menu-item">
                        <span class="header-wrapper__text">{{ __('Кинотеатры') }}</span>
                    </div>
                    <div class="header-wrapper__menu-item">
                        <span class="header-wrapper__text">{{ __('Информация') }}</span>
                    </div>
                </div>
                <div class="header-wrapper__authorization">
                    <div class="header-wrapper__menu-item">
                    <span class="header-wrapper__text">
                        @if (Route::has('login.admin'))
                            <div>
                                @auth
                                    <a class="header-wrapper__text"
                                       href="{{ url('/admin') }}">{{ __('Амин-панель') }}</a>
                                    <a class="header-wrapper__text" style="padding-left: 15px"
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">{{ __('Выход') }}</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                @else
                                    <a class="header-wrapper__text"
                                       href="{{ route('login.admin') }}">{{ __('Войти в личный кабинет') }}</a>
                                    <br>
                                    @if (Route::has('register.admin'))
                                        <a class="header-wrapper__text"
                                           href="{{ route('register.admin') }}">{{ __('Регистрация') }}</a>
                                    @endif
                                @endauth
                        </div>
                        @endif
                    </span>
                    </div>
                </div>
            </div>
            <div class="header-wrapper__calendar"></div>


        </div>
    </div>
</header>
