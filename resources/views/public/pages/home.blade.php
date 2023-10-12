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
                                    <button class="btn-by-ticket">{{ __('Купить билет') }}</button>
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
                            <a href="#">{{ __('Сейчас в кино') }}</a>
                        </div>
                        <div class="posters__menu-item">
                            <a href="#"> {{ __('Скоро') }} </a>
                        </div>
                    </div>
                    <div class="posters__menu-items">

                        <div class="posters__menu-item">
                            SVG Календаря
                            <a href="#"> {{ __('Расписание сеансов') }} </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper">
            <div class="swiper-container mySwiper-posters">
                <div class="swiper-wrapper">
                    @foreach ($movies as $movie)
                        <div class="swiper-slide swiper-slide-posters">
                            <div class="swiper-slide-poster-img">
                                <img src="{{ asset($movie->medias->first()->path) }}" alt="{{ $movie->name }}">
                            </div>
                            <div class="swiper-slide-poster-age"> Возраст</div>
                            <div class="swiper-slide-poster-name">
                                <div class="h7">{{ $movie->name }}</div>
                            </div>
                            <div class="swiper-slide-poster-genres">жанры, спиок, через. запятую</div>
                            <div>
                                <button class="btn-by-ticket">{{ __('Купить билет') }}</button>
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


        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>
        <h1 style="color: white">main text <br></h1>

@endsection
