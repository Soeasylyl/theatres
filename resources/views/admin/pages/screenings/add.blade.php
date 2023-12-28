@extends('admin.layouts.app')

@section('content')
    <div class="admin-container">
        <div class="admin-container__form">
            <div class="admin-theatres">
                <div class="admin-container__form-header">
                    {{ __('Добавление нового сеанса') }}
                </div>
                @error('error')
                <div class="error-messages">
                    {{$message}}
                </div>
                @enderror
                <div class="admin-screenings__body">
                    <form method="POST"
                          {{--                          action="{{ route('theatre.store') }}"--}}
                          class="admin-screenings__form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="admin-screenings__form-left">
                            <div class="admin-screenings__item">
                                <select class="admin-halls__seats-type"
                                        data-get-hall-url="{{ route('screening.get-halls') }}"
                                        name="theatre"
                                        id="screeningsTheatreSelectAdd">
                                    <option value="" disabled selected>{{ __('Выберите кинотеатр:') }}</option>
                                    @if(isset($theatres))
                                        <option value="" selected>{{ __(('Все кинотеатры')) }}</option>
                                        @forelse($theatres as $theatre)
                                            <option value="{{ $theatre->id }}"> {{ $theatre->name }}</option>
                                        @empty
                                            <option value="null">{{ __(('Нет доступных кинотеатров')) }}</option>
                                        @endforelse
                                    @endif
                                </select>
                            </div>

                            <div class="admin-screenings__item ">
                                <select class="admin-halls__seats-type admin-screenings__hidden" name="hall">
                                    <option value="" disabled selected>{{ __('Выберите зал:') }}</option>

                                </select>
                            </div>
                        </div>

                        <div class="admin-screenings__form-right">
                            <x-input :inputAttributes="[
                                        'name'=>'price',
                                        'type' => 'number',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                        'min' => '1',
                                         ]"
                                     :errorAttribute="'address'"
                                     input_required>
                                {{ __('Минимальная цена билета:') }}
                            </x-input>

                            <input type="hidden" name="timeZone" class="admin-screenings__timezone-input">
                            <x-input :inputAttributes="[
                                        'name'=>'date',
                                        'type'=>'datetime-local',
                                        'required'=>'required',
                                        'autocomplete' => 'off',
                                         ]"
                                     :errorAttribute="'dateTime'"
                                     input_required>
                                {{ __('Выбирите дату начала показа:') }}
                            </x-input>

                        </div>
                        <div class="login-container__button-wrapper admin-screenings__button-wrapper" style="justify-content: center">
                            <button type="submit" class="login-container__btn" style="width: 50%">
                                {{ __('Добавить сеанс') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

