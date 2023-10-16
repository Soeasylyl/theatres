@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">
                {{ __('Список Фильмов') }}
            </div>
            <div class="admin-container__form-body">
                <table class="admin-container__table">
                    <thead>
                    <th>{{ __('Название') }}</th>
                    <th>{{ __('Старт показа') }}</th>
                    <th>{{ __('Длительность фильма') }}</th>
                    <th>{{ __('Рейтинг') }}</th>
                    <th>{{ __(' ') }}</th>
                    </thead>
                    <tbody>
                    @foreach($movies as $movie)
                        <tr>
                            <td>{{ $movie->name }}</td>
                            <td>{{ $movie->date_start->format('Y-m-d') }}</td>
                            <td>{{ substr($movie->session_duration, 0, 5) }}</td>
                            <td>{{ $movie->rating }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
