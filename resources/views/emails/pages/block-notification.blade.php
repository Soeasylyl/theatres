@extends('emails.layouts.app')

@section('title', __('Пользователь заблокирован'))

@section('mail')
    <section class="email-page">
        @if ($user)
            <h1>Здравствуйте {{$user->name}}!
               <br> Вы заблокированны до {{ $user->blocked_until->format('d-m-Y H:i') }}
            </h1>
        @endif
    </section>
@endsection
