<footer class="footer">
    <div class="container">
        <hr class="footer-line">
        <div class="content-footer">
            <div class="content-footer__wrapper">
                <div class="content-footer__items">
                    <div class="content-footer__item">
                        <div class="content-footer__header">{{ __('Афиша') }}</div>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Сейчас в кино') }}</a>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Скоро') }}</a>
                    </div>
                </div>

                <div class="content-footer__items">
                    <div class="content-footer__item">
                        <div class="content-footer__header">{{ __('Кинотеатры') }}</div>
                    </div>
                    @foreach($cinemas as $cinema)
                        <div class="content-footer__item">
                            <a href="#"> {{ $cinema->name }}</a>
                        </div>
                    @endforeach
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Контакты') }}</a>
                    </div>
                </div>

                <div class="content-footer__items">
                    <div class="content-footer__item">
                        <div class="content-footer__header">{{ __('Еда и напитки') }}</div>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Комбо-блюда') }}</a>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Попкорн') }}</a>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Снеки') }}</a>
                    </div>
                </div>

                <div class="content-footer__items">
                    <div class="content-footer__item">
                        <div class="content-footer__header">{{ __('Информация') }}</div>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Возврат билетов') }}</a>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Акции') }}</a>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Новости') }}</a>
                    </div>
                    <div class="content-footer__item">
                        <a href="#"> {{ __('Возрастной рейтинг') }}</a>
                    </div>
                </div>
            </div>
            <div class="content-footer__links">
                <div class="content-footer__links-wrapper">
                    <a href="#">
                        <button>
                        {!! file_get_contents(public_path('/images/svg/social/vk.svg')) !!}
                        </button>
                    </a>
                    <a href="#">
                        <button>
                        {!! file_get_contents(public_path('/images/svg/social/facebook.svg')) !!}
                        </button>
                    </a>
                    <a href="#">
                        <button>
                        {!! file_get_contents(public_path('/images/svg/social/instagram.svg')) !!}
                        </button>
                    </a>
                </div>
                <div class="content-footer__links-wrapper">
                    <div class="content-footer__links-image">
                        <div>   {!! file_get_contents(public_path('/images/svg/payment/visa2.svg')) !!}</div>
                        <div>   {!! file_get_contents(public_path('/images/svg/payment/unionpay.svg')) !!}</div>
                        <div>   {!! file_get_contents(public_path('/images/svg/payment/belcard1.svg')) !!}</div>
                        <div>   {!! file_get_contents(public_path('/images/svg/payment/mastercard1.svg')) !!}</div>
                        <div>   {!! file_get_contents(public_path('/images/svg/payment/mastercard2.svg')) !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="footer-line">
        <div class="footer-info">
            <p> {{ __('Зарегистрировано решением Городского исполнительного комитета от 13.11.2014
                года в Реестре предприятий и организаций под номером 123456789. УНП 123456789,
                юридический адрес: 123456, г. Нью-Йорк, ул. Петрова, д.11, офис 5,
                Интернет-магазин example.com. Режим работы: ежедневно круглосуточно.
                Дата регистрации в Торговом реестре: 01.12.2020 год') }}
                <br><br>
                e-mail: info@example.by.</p>
        </div>
    </div>


</footer>
