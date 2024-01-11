<?php

namespace App\Http\Controllers\Public;

use App\DTO\Booking\CheckBookingSeatForScreeningDTO;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends BasePublicController
{
    /**
     * @param int $theatreId
     * @param int $hallId
     * @param int $screeningId
     * @param BookingService $bookingService
     * @return JsonResponse
     */
    public function generateBookingMap(
        int            $theatreId,
        int            $hallId,
        int            $screeningId,
        BookingService $bookingService,
    ): JsonResponse
    {
        $bookingDto = new CheckBookingSeatForScreeningDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            screeningId: $screeningId,
        );

        try {
            $bookingData = $bookingService->generateBookingDataForScreening($bookingDto);

            return response()->json($bookingData);
        } catch (\Throwable $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function checkBookingSeats(
        Request        $request,
        int            $theatreId,
        int            $hallId,
        int            $screeningId,
        BookingService $bookingService,
    )
    {
        $bookingDto = new CheckBookingSeatForScreeningDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            screeningId: $screeningId,
            seatIds: $request->input('seatIds'),
        );

        $bookingSeats = $bookingService->checkSeatStatus($bookingDto);

        dd("Тут будет срендерена и отправлена страница, 2 шаблона готовы");
    }
}
