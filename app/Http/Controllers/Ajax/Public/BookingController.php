<?php

namespace App\Http\Controllers\Ajax\Public;

use App\DTO\Booking\CheckBookingSeatForScreeningDTO;
use App\Http\Controllers\Ajax\Public\BasePublicController;
use App\Http\Requests\Public\ajaxCheckSeatsRequest;
use App\Http\Resources\SeatResourceCollection;
use App\Http\Resources\SeatResource;
use App\Repositories\HallRepository;
use App\Services\BookingService;
use App\Services\HallService;
use App\Services\ScreeningService;
use Illuminate\Http\JsonResponse;

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
//        BookingService $bookingService,
        HallRepository $hallRepository,
        HallService $hallService,
    ): JsonResponse
    {
        $bookingDto = new CheckBookingSeatForScreeningDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            screeningId: $screeningId,
        );

        try {
            $seats = $hallService->getHallContent($bookingDto);
//            $bookingData = $bookingService->generateBookingDataForScreening($bookingDto);
            return response()->json(SeatResource::collection($seats ));
        } catch (\Throwable $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param ajaxCheckSeatsRequest $request
     * @param int $theatreId
     * @param int $hallId
     * @param int $screeningId
     * @param BookingService $bookingService
     * @param ScreeningService $screeningService
     * @return JsonResponse
     */
    public function checkBookingSeats(
        ajaxCheckSeatsRequest $request,
        int                   $theatreId,
        int                   $hallId,
        int                   $screeningId,
        BookingService        $bookingService,
        ScreeningService      $screeningService,
    )
    {
        $bookingDto = new CheckBookingSeatForScreeningDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            screeningId: $screeningId,
            seatIds: json_decode($request->input('seatIds')),
        );

        try {
            $dataSeats = $bookingService->checkSeatStatus($bookingDto);

            return response()->json([
                'status' => true,
                'bookingSeats' => $dataSeats['bookingSeats'],
                'htmlTemplate' => view(
                    'public.pages.booking-partials.right-column-tickets', [
                        'screening' => $dataSeats['screening'],
                        'totalPrice' => $dataSeats['totalPrice'],
                        'availableSeats' => $dataSeats['availableSeats'],
                    ])->render()
            ]);

        } catch(\Throwable $exception) {
            $screening = $screeningService->getScreening($bookingDto->getScreeningId());

            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'htmlTemplate' => view(
                    'public.pages.booking-partials.right-column-seats-type', [
                        'screening' => $screening,
                    ])->render(),
            ]);
        }
    }
}
