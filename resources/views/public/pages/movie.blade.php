@extends('public.layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="movie-header">
                <div class="movie-header__btn">Кнопка "назад"</div>
                <div class="movie-header__name">Название фильма по центру</div>
            </div>
            <div class="movie-body">
                <div class="movie-body__sort-menu">
                    <div class="movie-body__sort-menu-items">
                        <label>
                            <select>
                                <option value="1">Все кинотеатры</option>
                                {{--                            форычем список кинотеатров вывести--}}

                            </select>
                        </label>
                    </div>

                    <div class="movie-body__sort-menu-items">
                        <label>
                            <select>
                                <option value="1">Сегодняшняя дата</option>
                                {{--                            форычем список будующих дат когда будут сеансы--}}

                            </select>
                        </label>
                    </div>

                    <div class="movie-body__sort-menu-items">
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
                <div class="movie-body__content"></div>
            </div>
        </div>
    </section>

@endsection
