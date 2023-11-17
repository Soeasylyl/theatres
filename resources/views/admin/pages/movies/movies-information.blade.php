@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">
                {{ __('Список Фильмов') }}
                @if(session('error_delete_movie'))
                    <div class="error-messages">
                        {{ session('error_delete_movie') }}
                    </div>
                @endif
                <div class="success-messages-wrapper">
                    @if(session('successMessages'))
                        <div class="success-messages">
                            {{ session('successMessages') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="admin-container__form-body">
                @php
                // TODO: Сделать проверку по ролям и отображать только  СУПЕР-АДМИНИСТРАТОРУ и МОДЕРАТОРУ
                @endphp
                <div class="admin-container__menu">
                    <a class="page-wrapper__panel-btn"
                       @php
                           // TODO: Вставить роут для перехода на страницу добавления фильма!
                       @endphp
                       href="#"> {{ __('Добавить фильм') }}</a>

                    <form method="get" action="{{ route('users') }}" class="admin-container__search-wrapper" >

                        <div class="admin-container__search-element-wrapper">
                            <input name="search" type="text"
                                   class="admin-container__search-bar"
                                   placeholder="{{ __('Поиск фильмов') }}">
                            @error('search')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="submit" class="page-wrapper__panel-btn">
                            {{ __('Поиск') }}
                        </button>
                    </form>
                </div>

                <table class="admin-container__table">
                    <thead>
                    <th>{{ __('Название') }}</th>
                    <th>{{ __('Старт показа') }}</th>
                    <th>{{ __('Длительность фильма') }}</th>
                    <th>{{ __('Рейтинг') }}</th>
                    <th>{{ __(' ') }}</th>
                    </thead>
                    <tbody>
                    @forelse($movies as $movie)
                        <tr>
                            <td>{{ $movie->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($movie->date_start)->isoFormat('D MMMM YYYY') }}</td>
                            <td>{{ substr($movie->session_duration, 0, 5) }}</td>
                            <td>{{ $movie->rating }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>{{ __('Фильмов не существует') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $movies->links('admin.partials.pagination') }}
            </div>
        </div>
    </div>
@endsection
