@extends('public.layouts.app')

@section('content')
    <!-- Slider main container -->
    <section>
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-container mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($movies as $movie)
                        <div class="swiper-slide">
                            <div class="container">
                                <div class="swiper-slide-items">
                                    <div class="swiper-slide-item">
                                        <div class="h7">{{ $movie->name }}</div>
                                    </div>
                                    <a href="{{ route('user.show.movie', $movie->slug) }}" class="btn-by-ticket">{{ __('Купить билет') }}</a>
                                </div>
                                <div class="swiper-slide-img">
                                    <img src="{{ asset($movie->medias->first()->path) }}" alt="{{ $movie->name }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <section class="posters">
        <div class="container">
            <div class="home-container">
                <div class="posters__header">
                    <span>{{ __('Афиша') }}</span>
                </div>
                <div class="posters__menu">
                    <div class="posters__menu-items">
                        <div class="posters__menu-item posters__menu-active">
                            <span>{{ __('Сейчас в кино') }}</span>
                        </div>
                        <div class="posters__menu-item">
                            <span> {{ __('Скоро') }}</span>
                        </div>
                    </div>
                    <div class="posters__menu-items">
                        <div class="posters__menu-calendar">
                            {!! file_get_contents(public_path('/images/svg/social/calendar.svg')) !!}
                            <a href="#"> {{ __('Расписание сеансов') }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper now-in-cinema-slider">
            <div class="swiper-container mySwiper-nowInCinema">
                <div class="swiper-wrapper swiper-wrapper-posters">
                    @foreach ($movies as $movie)
                        <div class="swiper-slide swiper-slide-posters">
                            <div class="swiper-slide-poster-img">
                                <img src="{{ asset($movie->medias->first()->path) }}" alt="{{ $movie->name }}">
                            </div>
                            <div class="swiper-slide-poster-age"> {{ $movie->age_limit }}</div>
                            <div class="swiper-slide-poster-name">
                                <div class="h7">{{ $movie->name }}</div>
                            </div>
                            <div
                                class="swiper-slide-poster-genres">{{$movie->genres()->pluck('name')->implode(', ')}}</div>
                            <div>
                                <a href="{{ route('user.show.movie', $movie->slug) }}" class="btn-by-ticket">{{ __('Купить билет') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next swiper-custom-button-next"></div>
                <div class="swiper-button-prev swiper-custom-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="swiper coming-soon-slider swiper-hidden">
            <div class="swiper-container mySwiper-ComingSoon">
                <div class="swiper-wrapper">
                    @foreach ($movies as $movie)
                        <div class="swiper-slide swiper-slide-posters">
                            <div class="swiper-slide-poster-img">
                                <img src="{{ asset($movie->medias->first()->path) }}" alt="{{ $movie->name }}">
                            </div>
                            <div class="swiper-slide-poster-age"> {{ $movie->age_limit }}</div>
                            <div class="swiper-slide-poster-name">
                                <div class="h7">{{ $movie->name }}</div>
                            </div>
                            <div
                                class="swiper-slide-poster-genres">{{$movie->genres()->pluck('name')->implode(', ')}}</div>
                            <div>
                                <a href="{{ route('user.show.movie', $movie->slug) }}" class="btn-by-ticket">{{ __('Купить билет') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next swiper-custom-button-next"></div>
                <div class="swiper-button-prev swiper-custom-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

    </section>
    <section class="services">
        <div class="services__background"></div>
        <div class="container">
            <div class="services__wrapper">
                <div class="services__left-content">
                    <div class="services__left-content-title">{{ __('Услуги') }}</div>
                    <div
                        class="services__left-content-description">{{ __('Бронируйте кинозалы, Media room и Party room или арендуйте кинопространство целиком – смотрите, празднуйте, обучайтесь с удовольствием!') }}</div>
                    <div class="btn-by-ticket">{{ __('Подробнее') }}</div>
                </div>
                <div class="services__right-content">
                    <img src="{{ asset('images/home/servicesImage.jpg') }}">
                </div>
            </div>
        </div>
    </section>
    <section class="visa">
        <div class="services__background"></div>
        <div class="container">
            <div class="services__wrapper">
                <div class="visa__left-content">
                    <img src="{{ asset('images/home/visa.png') }}">
                </div>
                <div class="visa__right-content">
                    <div class="services__left-content-title">{{ __('Мир привилегий VISA') }}</div>
                    <div
                        class="services__left-content-description">{{ __('При оплате билетов в кинопространствах mooon и Silver Screen платежными карточками Visa вы получаете скидку!') }}</div>
                    <div class="btn-by-ticket">{{ __('Подробнее') }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
