@forelse($theatres as $theatre)
    <div class="movie__left-column-theatre">
        <div class="movie__left-column-theatre-wrapper">
            <div class="movie__left-column-theatre-options">
                <div class="movie__theatre-options-wrapper">
                    <h4 class="movie__theatre-options-name">
                        {{ $theatre->name }}
                    </h4>
                    <span class="movie__theatre-options-address">
                        {{ $theatre->address }}
                    </span>
                </div>
            </div>
        </div>
        <div class="movie__right-column-halls">
            @forelse($halls = $theatre->halls as $hall)
                @forelse($screenings = $hall->screenings as $screening)
                    <div class="movie__hall">
                        <div class="movie__hall-wrapper">
                            <div class="movie__screening-time">
                                {{ $screening->start_at  }}
                            </div>
                            <div class="movie__hall-options">
                                <div class="movie__hall-name">
                                    {{ $hall->name }}
                                </div>
                                <div class="movie__hall-load"
                                     style="width: {{
                                        ($screening->bookings->count() > 0)
                                        ? (($screening->bookings->count() / $hall->seats->count()) * 100)
                                        : 0
                                     }}%;">

                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse

            @empty

            @endforelse

        </div>
    </div>
@empty

@endforelse
