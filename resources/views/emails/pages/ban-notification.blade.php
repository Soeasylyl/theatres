@extends('emails.layouts.mail')

@section('title', __('Пользователь заблокирован'))

@section('mail')
    <table style=" background: linear-gradient(180deg,#a4103a 0%,#262626 100%);
                   width: 100%;
                   padding: 0 10px 0 10px;
                   border-radius: 12px 12px 0 0;
                   color: #fff;
                   text-align: center;">
        <thead>
        <tr>
            <td>
                @if ($user)
                    <h1>Здравствуйте {{$user->name}}!
                @endif
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                @if ($user)
                    Вы заблокированны до {{ $user->blocked_until->format('d-m-Y H:i') }}
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <table style=" width: 100%;
                   padding: 15px;
                   border-radius: 0 0 12px 12px;
                   color: #fff;
                   background: linear-gradient(180deg,#262626 0%,#a4103a 100%);">
        <thead>
        <tr>
            <td style=" padding-top: 60px;
                        padding-bottom: 45px;">
            </td>
        </tr>
        </thead>
        <tr>
            <td style=" padding-left: 10px;
                        padding-bottom: 15px;">
                Это письмо было отправлено на Ваш адрес, поскольку Вы являетесь клиентом <br>Сети кинотеатров КиноБронь.
            </td>
        </tr>
    </table>
@endsection
