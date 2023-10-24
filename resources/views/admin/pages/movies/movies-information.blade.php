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
                            <td>{{ \Carbon\Carbon::parse($movie->date_start)->isoFormat('D MMMM YYYY') }}</td>
                            <td>{{ substr($movie->session_duration, 0, 5) }}</td>
                            <td>{{ $movie->rating }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <nav aria-label="pagination">
                    <ul class="pagination justify-content-center">
                        <!-- Предыдущая страница -->
                        @if ($movies->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">{{ __('Предыдущая') }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $movies->previousPageUrl() }}"
                                   rel="prev">{{ __('Предыдущая') }}</a>
                            </li>
                        @endif

                        <!-- Страницы -->
                        @foreach ($movies as $movie)
                            <li class="page-item {{ $movie->isActive ? 'active' : '' }}">
                                <a class="page-link" href="{{ $movie->url }}">{{ $movie->label }}</a>
                            </li>
                        @endforeach

                        <!-- Следующая страница -->
                        @if ($movies->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $movies->nextPageUrl() }}"
                                   rel="next">{{ __('Следующая') }}</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">{{ __('Следующая') }}</span>
                            </li>
                        @endif
                    </ul>
                </nav>


            </div>
        </div>
    </div>
@endsection
