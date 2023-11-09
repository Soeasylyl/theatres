@extends('errors.app')

@section('title', __('Страница не найдена'))

@section('message')
    <section class="error-page">
        <div class="error-page__background-wrapper">
            <div class="error-page__background"></div>
        </div>

        <div class="error-page__body">
            <div class="error-page__container">
                <div class="error-page__body-wrapper">
                    <div class="error-page__title">{{ __('Не найдена страница твоя (404)') }}</div>
                    <div class="error-page__content">
                        <div class="error-page__description">
                            <div class="error-page__test">{{ __('Тенью жадности привязанность является. Должен научиться отказываться ты от того, что боишься потерять. Из головы страх выкинь, и потеря не причинит вреда тебе') }}</div>
                        </div>
                        <div class="error-page__reference">{{ __('Звездные войны: Эпизод 3 — Месть Ситхов') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
