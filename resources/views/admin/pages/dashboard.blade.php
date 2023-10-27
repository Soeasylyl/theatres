@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">
                <h1>Общие данные</h1>
            </div>
            <h1>Количество пользователей: {{$countUsers}}</h1>
            <h1>Количество кинотеатров: {{$countCinemas}}</h1>
            <h1>Список кинотеатров:</h1>
            <h3>
                <table>
                    <thead>
                    <tr>
                        <td>Название</td>
                        <td>Общее количество мест</td>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cinemas as $cinema)

                        <tr>
                            <td>{{$cinema->name}} </td>
                            <td>{{$cinema->halls->sum(function ($hall){
                                return $hall->seats->count();
                                })
                                }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>{{ __('Фильмов не существует') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </h3>

        </div>
    </div>

@endsection
