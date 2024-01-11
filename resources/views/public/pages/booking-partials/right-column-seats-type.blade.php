<div class="booking__right-column-content">
                        <span class="booking__right-column-seats-type-title">
                            {{ __('Типы мест') }}
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
                            {{ $seatType->name }}
                        </div>
                        <div class="booking__right-column-seat-type-price">
                            {{ sprintf("%s %s", $seatType->amount, ' $') }}
                        </div>
                    </div>
                    <div class="booking__right-column-seat-type-description">
                        {{ $seatType->description }}
                    </div>
                </div>
            @empty
                <div class="booking__right-column-seat-type">
                    <div class="booking__right-column-seat-type-title">
                        <div class="booking__right-column-seat-type-name">
                            {{ __('Нет доступных типов мест') }}
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="booking__right-column-seat-type-item">
            <button>
                {{ __('Выберите места') }}
            </button>
        </div>
    </div>

</div>
