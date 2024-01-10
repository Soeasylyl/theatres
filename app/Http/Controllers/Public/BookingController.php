<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends BasePublicController
{

    public function generateBookingMap(
        int $theatreId,
        int $hallId,
        int $screeningId,
    )
    {
dd('ТУТ ЛОГИКА ГЕНЕРАЦИИ КАРТЫ БРОНИРОВКИ');
    }
}
