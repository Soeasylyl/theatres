@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-container__form-header">
                {{ __('Список Кинотеатров') }}
            </div>
            <div class="admin-container__form-body">
                <table class="admin-container__table">
                    <thead>
                    <th>{{ __('Название') }}</th>
                    <th>{{ __('Адрес') }}</th>
                    <th>{{ __('Количество залов') }}</th>


                    <th>{{ __(' ') }}</th>
                    </thead>
                    <tbody>
                    @forelse($theatres as $theatre)
                        <tr>
                            <td>{{ $theatre->name }}</td>
                            <td>{{ $theatre->address }}</td>
                            <td>{{ $theatre->halls_count }}</td>
                        </tr>
                    @empty
                       <h2> {{ __('Кинотеатры не найдены.') }} </h2>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
