@extends('public.layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="movie-header">
                <div class="movie-header__btn">Кнопка "назпд"</div>
                <div class="movie-header__name">Название фильма по центру</div>
            </div>
            <div class="movie-body">
                <div class="movie-body__sort-menu">
                    <div class="movie-body__sort-menu-items">
                        <select>
                            <option value="1">Выберите изображение</option>
{{--                            <option value="2" data-icon="path_to_your_svg_file.svg">SVG Image</option>--}}
                        </select>
                    </div>
                </div>
                <div class="movie-body__content"></div>
            </div>
        </div>
    </section>

@endsection
