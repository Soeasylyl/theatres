@extends('emails.layouts.app')

@section('title', __('Пользователь заблокирован'))

@section('mail')
    <section class="email-page">
        <h1>Поздравляем, срок блокироки истёк, вы разблокированны!</h1>
    </section>
@endsection
