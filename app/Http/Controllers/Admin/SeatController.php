<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\EditHallDTO;
use App\DTO\Seats\CreateSeatDTO;
use App\DTO\Seats\CheckAndDeleteSeatDTO;
use App\DTO\Seats\UpdateSeatDTO;
use App\Http\Requests\Admin\Seats\CheckSeatRequest;
use App\Http\Requests\Admin\Seats\CreateSeatRequest;
use App\Http\Requests\Admin\Seats\UpdateSeatRequest;
use App\Services\HallService;
use App\Services\SeatService;
use App\Services\SeatTypeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SeatController extends BaseAdminController
{
    public function __construct(
        private readonly HallService     $hallService,
        private readonly SeatTypeService $seatTypeService,
    )
    {
    }

    /**
     *  Show the form for creating a new resource.
     *
     * @param int $theatreId
     * @param int $hallId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(int $theatreId, int $hallId)
    {
        $editHallDto = new EditHallDTO(
            theatreId: $theatreId,
            hallId: $hallId,
        );

        $seatTypes = $this->seatTypeService->getSeatsTypeToHall($editHallDto->getTheatreId());

        return view('admin.pages.seats.edit',
            compact(
                'theatreId',
                'hallId',
                'seatTypes'
            ));
    }

    /**
     * Generates and returns data for map visualization.
     *
     * @param int $theatreId
     * @param int $hallId
     * @return JsonResponse
     */
    public function generateMap(int $theatreId, int $hallId): JsonResponse
    {
        $editHallDto = new EditHallDTO(
            theatreId: $theatreId,
            hallId: $hallId,
        );

        $dataSeats = $this->hallService->getHallContent($editHallDto);

        return response()->json($dataSeats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        CreateSeatRequest $request,
        int               $theatreId,
        int               $hallId,
        SeatService       $seatService
    )
    {
        $createSeatDto = new CreateSeatDTO(
            seatTypeId: $request->input('seat_type_id'),
            hallId: $hallId,
            theatreId: $theatreId,
            row: $request->input('row'),
            number: $request->input('number'),
            posX: $request->input('position_x'),
            posY: $request->input('position_y'),
        );

        try {
            $seatId = $seatService->createSeat($createSeatDto)->id;

            return response()->json([
                'status' => true,
                'seat_id' => $seatId,
                'message' => 'Место успешно добавлено',
            ]);
        } catch (\Throwable $exception) {
            Log::error("Failed to create new seat: {$exception->getMessage()}");

            return response()->json([
                'status' => false,
                'message' => 'Произошла ошибка создания места',
            ]);
        }
    }

    /**
     *  Method for checking the condition of a place.
     *
     * @param CheckSeatRequest $request
     * @param int $theatreId
     * @param int $hallId
     * @param SeatService $seatService
     * @return JsonResponse
     */
    public function check(
        CheckSeatRequest $request,
        int              $theatreId,
        int              $hallId,
        SeatService      $seatService,
    )
    {
        $checkSeatDto = new CheckAndDeleteSeatDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            seatId: $request->input('seat_id'),
        );

        try {
            $seatData = $seatService->findSeatWithSeatType($checkSeatDto);

            return response()->json([
                'status' => true,
                'seat' => $seatData['seat'],
                'seatTypeName' => $seatData['seatType'],
            ]);
        } catch (\Throwable $exception) {
            Log::error("Failed to find seat: {$exception->getMessage()}");

            return response()->json([
                'status' => false,
                'message' => 'Произошла ошибка при поиске места',
            ]);
        }
    }

    /**
     * Updates information about a seat in the hall.
     *
     * @param UpdateSeatRequest $request
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatId
     * @param SeatService $seatService
     * @return JsonResponse
     */
    public function update(
        UpdateSeatRequest $request,
        int               $theatreId,
        int               $hallId,
        int               $seatId,
        SeatService       $seatService,
    )
    {
        $updateSeatDto = new UpdateSeatDTO(
            hallId: $hallId,
            seatId: $seatId,
            theatreId: $theatreId,
            seatTypeId: $request->input('seat_type_id'),
            row: $request->input('row'),
            number: $request->input('number'),
            posX: $request->input('position_x'),
            posY: $request->input('position_y'),
        );

        try {
            $seatService->updateSeat($updateSeatDto);

            return response()->json([
                'status' => true,
                'message' => 'Место успешно сохранено',
            ]);
        } catch (\Throwable $exception) {
            Log::error("Failed to save seat: {$exception->getMessage()}");

            return response()->json([
                'status' => false,
                'message' => 'Произошла ошибка сохранения места',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatId
     * @param SeatService $seatService
     * @return JsonResponse
     */
    public function destroy(
        int         $theatreId,
        int         $hallId,
        int         $seatId,
        SeatService $seatService
    )
    {
        $deleteSeatDto = new CheckAndDeleteSeatDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            seatId: $seatId,
        );
        try {
            $seatService->deleteSeat($deleteSeatDto);

            return response()->json([
                'status' => true,
                'message' => 'Место успешно удалено',
            ]);
        } catch (\Throwable $exception) {
            Log::error("Failed to save seat: {$exception->getMessage()}");

            return response()->json([
                'status' => false,
                'message' => 'Произошла ошибка при удалении места',
            ]);
        }
    }
}
