@extends('public.layouts.app')

@section('content')
    <section>
        <div class="container">
            <input class="movie__timezone-input" name="timezone" type="hidden">
            <div class="movie__header" data-url="{{ route('public.show.movie', ['movie' => $movie]) }}">
                <a href="{{ route('public.show.movie', ['movie' => $movie]) }}" class="movie__header-btn-back">
                    <svg id="svg-icon-lg-arrow-left" viewBox="0 0 28 22" width="100%" height="100%">
                        <path fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="miter"
                              vector-effect="non-scaling-stroke" d="M2.5,11 L12,1 M2.5,11 L12,21 M1.7,11 L27,11"></path>
                    </svg>
                </a>
                <div class="movie__header-name">{{ $movie->name }}</div>
                <div></div>
            </div>
            <div class="movie__body">
                <div class="booking__hero">
                    <div class="booking__poster">
                        @if ($media = optional($movie->poster))
                            <img src="{{ asset($media->path) }}" alt="{{ $movie->name }}">
                        @endif
                    </div>

                    <div class="booking__description">
                        <h2 class="booking__movie-name"> {{ $movie->name }}</h2>
                        <div class="booking__movie-content">
                            <div class="booking__movie-address-wrapper">
                                <div class="booking__movie-address-svg">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M8.86878 22.2065L8.86945 22.2075C10.0089 23.8966 11.2719 25.6848 12.2748 27.0754C12.7763 27.7708 13.2129 28.367 13.5366 28.8019C13.6984 29.0193 13.8323 29.1967 13.932 29.3262C14.0291 29.4523 14.0991 29.5398 14.1299 29.5707C14.3346 29.776 14.6584 30 15 30C15.3233 30 15.6602 29.8902 15.8834 29.5544L15.89 29.543C15.89 29.543 15.8905 29.542 15.8928 29.5382L15.9016 29.5241C15.9053 29.5183 15.9097 29.5117 15.9147 29.5041C15.92 29.4962 15.926 29.4874 15.9328 29.4775C15.9592 29.4391 15.9957 29.3874 16.0418 29.3233C16.1338 29.195 16.2627 29.0185 16.4221 28.8013L16.7357 28.3743C17.0071 28.0052 17.3306 27.5651 17.6877 27.0759C18.7027 25.6856 19.9908 23.8971 21.1305 22.2075L21.132 22.2052C22.7179 19.7203 23.9338 17.5309 24.7536 15.6625C25.5725 13.796 26 12.2412 26 11.0284L25.9999 11.0249C25.8002 5.01598 20.9062 0 14.901 0C8.89629 0 4 5.01611 4 11.0284C4 12.2403 4.40214 13.7945 5.20907 15.6619C6.01667 17.5309 7.23292 19.7209 8.86878 22.2065ZM20.8453 18.2996C19.212 21.1842 17.0486 24.3359 14.901 27.1349C12.7534 24.3359 10.5899 21.1842 8.95669 18.2996C8.12901 16.8377 7.43848 15.4462 6.95514 14.2051C6.47108 12.9621 6.19802 11.878 6.19802 11.0284C6.19802 6.11914 10.1131 2.19858 14.901 2.19858C19.6889 2.19858 23.604 6.11914 23.604 11.0284C23.604 11.878 23.3309 12.9621 22.8468 14.2051C22.3635 15.4462 21.673 16.8377 20.8453 18.2996Z"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M15 14.6C16.9882 14.6 18.6 12.9882 18.6 11C18.6 9.01178 16.9882 7.4 15 7.4C13.0118 7.4 11.4 9.01178 11.4 11C11.4 12.9882 13.0118 14.6 15 14.6ZM15 17C18.3137 17 21 14.3137 21 11C21 7.68629 18.3137 5 15 5C11.6863 5 9 7.68629 9 11C9 14.3137 11.6863 17 15 17Z"></path>
                                    </svg>
                                </div>
                                <span class="booking__movie-address">
                                    {{ $screening->hall->theatre->address }}
                                </span>
                                <span> &nbsp;/&nbsp;{{ __('Зал') }}&nbsp; </span>
                                <span class="booking__movie-hall-name">
                                    {{ $screening->hall->name }}
                                </span>
                            </div>
                            <div class="booking__movie-date-wrapper">
                                <div class="booking__movie_date-svg">
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
                                </div>
                                <span>
                                    {{ $screening->start_at->locale('ru')->isoFormat('DD MMMM') }}
                                </span>
                                <span>
                                    &nbsp;/&nbsp;
                                </span>
                                <div class="booking__movie-time"
                                     data-time-url="{{
                                        route('public.get.screenings.time', [
                                            'movie' => $movie,
                                            'screening' => $screening->id,
                                        ])
                                     }}"
                                >
                                </div>
                            </div>
                            <div class="booking__movie-age-limit">
                                {{ $screening->movie->age_limit }}+
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="booking__body-content">
                <div class="booking__notification">
                    <div class="booking__notification-wrapper">
                        <div class="booking__notification-title">
                            {{ __('Этот сеанс закончится после 23:00.') }}
                        </div>
                        <p class="booking__notification-text">
                            {{ __('Обратите внимание! После 23:00 выход из кинотеатра, осуществляется через улицу.
                                    В случае возникновения вопросов, обращайтесь к нашим сотрудникам, они будут рады Вам помочь.') }}
                        </p>
                    </div>
                </div>
                <div class="movie__body-left-column">

                </div>
                <div class="movie__body-right-column">
                    <div class="movie__right-column-wrapper">


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
