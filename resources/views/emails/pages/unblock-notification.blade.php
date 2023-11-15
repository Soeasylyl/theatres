@extends('emails.layouts.app')

@section('title', __('Пользователь заблокирован'))

@section('mail')
    <section class="email-page">
        @if ($user)
            <h1>Здравствуйте {{$user->name}}!
                <br> Поздравляем, ваша блокировка истекла!
            </h1>
        @endif
    </section>
@endsection
