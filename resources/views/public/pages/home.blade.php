@extends('public.layouts.app')

@section('content')
    <!-- Slider main container -->
    <section>
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-container mySwiper">
                <div class="swiper-wrapper">
                    @forelse ($movies as $movie)
                        <div class="swiper-slide">
                            <div class="container">
                                <div class="swiper-slide-items">
                                    <div class="swiper-slide-item">
                                        <div class="h7">{{ $movie->name }}</div>
                                    </div>
                                    <a href="{{ route('user.show.movie', $movie->slug) }}"
                                       class="btn-by-ticket">{{ __('Купить билет') }}</a>
                                </div>
                                <div class="swiper-slide-img">
                                    <img src="{{ asset($movie->medias->where('collection', 'frames')->first()->path) }}"
                                         alt="{{ $movie->name }}">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            <h2>{{ __('Извините, фильмы в настоящее время недоступны.') }}</h2>
                        </div>
                    @endforelse
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
                            <svg id="svg-icon-calendar" viewBox="0 0 32 32" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <text text-anchor="middle" x="47%" dy="22" fill="currentColor"
                                      font-family="Ubuntu, Roboto, Arial, Helvetica, sans-serif" font-size="16">
                                    <script>
                                        const currentDate = new Date();
                                        const day = currentDate.getDate();
                                        document.write(day);
                                    </script>
                                </text>
                                <g>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M13.9813 1.06034V2.53448H7.93434V1.06034C7.93434 0.813942 7.85252 0.550849 7.66699 0.342753C7.47308 0.125251 7.19376 0 6.87237 0C6.56851 0 6.30755 0.146308 6.13267 0.320671C5.95788 0.494939 5.8104 0.7558 5.8104 1.06034V2.53448H3.42244C1.59484 2.53448 0 4.12237 0 5.94828V26.5862C0 28.513 1.6054 30 3.42244 30H26.5733C28.4916 30 29.9957 28.5026 29.9957 26.5862V5.96277C30.095 4.11364 28.4794 2.53448 26.6641 2.53448H24.2761V1.06034C24.2761 0.7558 24.1286 0.494939 23.9538 0.320671C23.7789 0.146308 23.518 0 23.2141 0C22.9103 0 22.6493 0.146308 22.4744 0.320671C22.2996 0.494939 22.1522 0.7558 22.1522 1.06034V2.53448H16.196V0.97617L16.1693 0.896339C16.0937 0.670038 15.9502 0.459633 15.7745 0.301986C15.6026 0.147723 15.3487 0 15.0432 0C14.7394 0 14.4784 0.146308 14.3035 0.320671C14.1288 0.494939 13.9813 0.7558 13.9813 1.06034ZM27.781 5.94828V27.1034H27.8531C27.6515 27.5582 27.1936 27.8793 26.6641 27.8793H3.42244C2.70799 27.8793 2.12393 27.2948 2.12393 26.5862V5.94828C2.12393 5.2397 2.70799 4.65517 3.42244 4.65517H5.8104V6.67241C5.8104 6.97696 5.95788 7.23782 6.13267 7.41209C6.30755 7.58645 6.56851 7.73276 6.87237 7.73276C7.17623 7.73276 7.43718 7.58645 7.61207 7.41209C7.78685 7.23782 7.93434 6.97696 7.93434 6.67241V4.65517H13.8905V6.67241C13.8905 6.97696 14.038 7.23782 14.2128 7.41209C14.3876 7.58645 14.6486 7.73276 14.9525 7.73276C15.2563 7.73276 15.5173 7.58645 15.6922 7.41209C15.8669 7.23782 16.0144 6.97696 16.0144 6.67241V4.65517H21.9706V6.67241C21.9706 6.97696 22.1181 7.23782 22.2929 7.41209C22.4677 7.58645 22.7287 7.73276 23.0325 7.73276C23.3364 7.73276 23.5974 7.58645 23.7722 7.41209C23.947 7.23782 24.0945 6.97696 24.0945 6.67241V4.65517H26.4825C27.1969 4.65517 27.781 5.2397 27.781 5.94828Z"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect width="32" height="32"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                            <a href="#"> {{ __('Расписание сеансов') }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper now-in-cinema-slider">
            <div class="swiper-container mySwiper-nowInCinema">
                <div class="swiper-wrapper swiper-wrapper-posters">
                    @forelse($movies as $movie)
                        <div class="swiper-slide swiper-slide-posters">
                            <div class="swiper-slide-poster-img">
                                @if ($media = optional($movie->medias->where('collection', 'poster')->first()))
                                    <img src="{{ asset($media->path) }}" alt="{{ $movie->name }}">
                                @endif
                                @if (isset($posterPaths[$movie->id]))
                                    <img src="{{ asset($posterPaths[$movie->id]) }}" alt="{{ $movie->name }}">
                                @endif
                            </div>
                            <div class="swiper-slide-poster-age"> {{ $movie->age_limit }}</div>
                            <div class="swiper-slide-poster-name">
                                <div class="h7">{{ $movie->name }}</div>
                            </div>
                            <div class="swiper-slide-poster-genres">
                                @forelse ($movie->genres as $genre)
                                    {{ $genre->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @empty
                                    {{ __('Жарны отсутствуют') }}
                                @endforelse
                            </div>
                            <div>
                                <a href="{{ route('user.show.movie', $movie->slug) }}"
                                   class="btn-by-ticket">{{ __('Купить билет') }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            <h2>{{ __('Извините, фильмы в настоящее время недоступны.') }}</h2>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-button-next swiper-custom-button-next"></div>
                <div class="swiper-button-prev swiper-custom-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="swiper coming-soon-slider swiper-hidden">
            <div class="swiper-container mySwiper-ComingSoon">
                <div class="swiper-wrapper">
                    @forelse($movies as $movie)
                        <div class="swiper-slide swiper-slide-posters">
                            <div class="swiper-slide-poster-img">
                                @if ($media = optional($movie->medias->where('collection', 'poster')->first()))
                                    <img src="{{ asset($media->path) }}" alt="{{ $movie->name }}">
                                @endif
                                @if (isset($posterPaths[$movie->id]))
                                    <img src="{{ asset($posterPaths[$movie->id]) }}" alt="{{ $movie->name }}">
                                @endif
                            </div>
                            <div class="swiper-slide-poster-age"> {{ $movie->age_limit }}</div>
                            <div class="swiper-slide-poster-name">
                                <div class="h7">{{ $movie->name }}</div>
                            </div>
                            <div class="swiper-slide-poster-genres">
                                @forelse ($movie->genres as $genre)
                                    {{ $genre->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @empty
                                    {{ __('Жарны отсутствуют') }}
                                @endforelse
                            </div>
                            <div>
                                <a href="{{ route('user.show.movie', $movie->slug) }}"
                                   class="btn-by-ticket">{{ __('Купить билет') }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            <h2>{{ __('Извините, фильмы в настоящее время недоступны.') }}</h2>
                        </div>
                    @endforelse
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
