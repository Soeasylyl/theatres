<div class="booking__right-column-content">
                        <span class="booking__right-column-seats-type-title">
                            {{ __('Мои билеты') }}
                        </span>
    <div class="booking__right-column-theatre-name">
        {{ $screening->hall->theatre->name }}
    </div>
    <div class="booking__right-column-seats-type">
        <div class="booking__right-column-seats-type-wrapper">
            @forelse($screening->hall->theatre->seatTypes as $seatType)
                <div class="booking__right-column-seat-type">
                    <div class="booking__right-column-seat-type-title">
                        <div class="booking__right-column-seat-type-name">
                            НОМЕР РЯДА / НОМЕР МЕСТА
                        </div>
                        <div class="booking__right-column-seat-type-price">
                            777 $
{{--                            {{ sprintf("%s %s", $seatType->amount, ' $') }}--}}
                        </div>
                    </div>
                    <div class="booking__right-column-seat-type-description">
                        Название типа места
                    </div>
                </div>
            @empty
                <div class="booking__right-column-seat-type">
                    <div class="booking__right-column-seat-type-title">
                        <div class="booking__right-column-seat-type-name">
                            {{ __('Место недоступно') }}
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="booking__right-column-seat-type-ticket">
            <div class="booking__right-column-seats-type-amount">
                <span>{{ __('Итого:') }}</span>
                <div class="booking__right-column-seats-type-price">
                    {{ sprintf('%s %s', '153.00', '$') }}
                </div>
            </div>
            <button>
                {{ __('Подтвердить и перейти к оплате') }}
            </button>
        </div>
    </div>

</div>
