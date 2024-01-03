@extends('public.layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="movie__header">
                <a href="{{ route('public.pages.home') }}" class="movie__header-btn-back">
                    <svg id="svg-icon-lg-arrow-left" viewBox="0 0 28 22" width="100%" height="100%">
                        <path fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="miter"
                              vector-effect="non-scaling-stroke" d="M2.5,11 L12,1 M2.5,11 L12,21 M1.7,11 L27,11"></path>
                    </svg>
                </a>
                <div class="movie-header__name">{{ $movie->name }}</div>
                <div></div>
            </div>
            <div class="movie__body">
                <div class="movie__body-sort-menu">
                    <div class="movie__body-sort-menu-items movie__body-menu-left">

                        <div class="movie__select">
                            <div class="movie__select-header">
                                <div class="movie__select-header-content" id="movieSelectHeaderForTheatre">
                                    <svg class="movie__svg-icon" xmlns="http://www.w3.org/2000/svg" width="30"
                                         height="30" viewBox="0 0 30 30"
                                         fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M8.86878 22.2065L8.86945 22.2075C10.0089 23.8966 11.2719 25.6848 12.2748 27.0754C12.7763 27.7708 13.2129 28.367 13.5366 28.8019C13.6984 29.0193 13.8323 29.1967 13.932 29.3262C14.0291 29.4523 14.0991 29.5398 14.1299 29.5707C14.3346 29.776 14.6584 30 15 30C15.3233 30 15.6602 29.8902 15.8834 29.5544L15.89 29.543C15.89 29.543 15.8905 29.542 15.8928 29.5382L15.9016 29.5241C15.9053 29.5183 15.9097 29.5117 15.9147 29.5041C15.92 29.4962 15.926 29.4874 15.9328 29.4775C15.9592 29.4391 15.9957 29.3874 16.0418 29.3233C16.1338 29.195 16.2627 29.0185 16.4221 28.8013L16.7357 28.3743C17.0071 28.0052 17.3306 27.5651 17.6877 27.0759C18.7027 25.6856 19.9908 23.8971 21.1305 22.2075L21.132 22.2052C22.7179 19.7203 23.9338 17.5309 24.7536 15.6625C25.5725 13.796 26 12.2412 26 11.0284L25.9999 11.0249C25.8002 5.01598 20.9062 0 14.901 0C8.89629 0 4 5.01611 4 11.0284C4 12.2403 4.40214 13.7945 5.20907 15.6619C6.01667 17.5309 7.23292 19.7209 8.86878 22.2065ZM20.8453 18.2996C19.212 21.1842 17.0486 24.3359 14.901 27.1349C12.7534 24.3359 10.5899 21.1842 8.95669 18.2996C8.12901 16.8377 7.43848 15.4462 6.95514 14.2051C6.47108 12.9621 6.19802 11.878 6.19802 11.0284C6.19802 6.11914 10.1131 2.19858 14.901 2.19858C19.6889 2.19858 23.604 6.11914 23.604 11.0284C23.604 11.878 23.3309 12.9621 22.8468 14.2051C22.3635 15.4462 21.673 16.8377 20.8453 18.2996Z"
                                              fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M15 14.6C16.9882 14.6 18.6 12.9882 18.6 11C18.6 9.01178 16.9882 7.4 15 7.4C13.0118 7.4 11.4 9.01178 11.4 11C11.4 12.9882 13.0118 14.6 15 14.6ZM15 17C18.3137 17 21 14.3137 21 11C21 7.68629 18.3137 5 15 5C11.6863 5 9 7.68629 9 11C9 14.3137 11.6863 17 15 17Z"
                                              fill="white"/>
                                    </svg>
                                    <div class="movie__select-theatre-name">
                                        {{ __('Все кинотеатры') }}
                                    </div>
                                    <svg class="movie__svg-arrow" id="svgIconRoundArrow" viewBox="0 0 22 22"
                                         width="100%" height="100%">
                                        <circle fill="none" stroke="currentColor" stroke-width="2"
                                                vector-effect="non-scaling-stroke" cx="11" cy="11" r="10"></circle>
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                              vector-effect="non-scaling-stroke" d="M6,9 L11,14 L16,9"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="movie__select-body movie__hidden" id="movieSelectBodyForTheatre">
                                <div class="movie__select-theatre-options movie__theatre-selected">
                                    <div class="movie__select-theatre-options-name">
                                        {{ __('Все кинотеатры') }}
                                    </div>
                                </div>
                                @forelse($theaters as $theatre)
                                    <div class="movie__select-theatre-options">
                                        <div class="movie__select-theatre-options-name">{{ $theatre->name }}</div>
                                        <span>{{ $theatre->address }}</span>
                                    </div>
                                @empty
                                    <div class="movie__select-options">
                                        {{ __('Кинотеатры не найдены') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="movie__body-sort-menu-items">
                        <label>
                            <select>
                                <option value="1">Сегодняшняя дата</option>
                                {{--                            форычем список будующих дат когда будут сеансы--}}

                            </select>
                        </label>
                    </div>

                    <div class="movie__body-sort-menu-items movie__body-menu-right">
                        <label>
                            <select>
                                <option value="1">Все сеансы</option>
                                {{--                            Список для сортировки--}}
                                <option value="2">7:00 - 11:59</option>
                                <option value="2">12:00 - 16:59</option>
                                <option value="2">17:00 - 21:59</option>
                                <option value="2">22:00 - 6:59</option>

                            </select>
                        </label>
                    </div>

                </div>
                <div class="movie__body-content"></div>
            </div>
        </div>
    </section>

@endsection
