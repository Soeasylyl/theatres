<header id='headerId' class="header">
<div class="header-container">
    <div class="header-wrapper">
        <div class="header-wrapper__hamburger"></div>
        <div class="header-wrapper__logo">
            <a href="#">
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
                <span class="header-wrapper__text"> {{ __('Войти в личный кабинет') }}</span>
                </div>
            </div>
        </div>
        <div class="header-wrapper__calendar"></div>


    </div>
</div>
</header>
