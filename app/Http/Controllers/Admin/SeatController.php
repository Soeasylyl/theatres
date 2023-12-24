<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\EditHallDTO;
use App\DTO\Seats\CreateSeatDTO;
use App\DTO\Seats\SeatIdDTO;
use App\DTO\Seats\UpdateSeatDTO;
use App\Http\Requests\Admin\Seats\CheckSeatRequest;
use App\Http\Requests\Admin\Seats\CreateSeatRequest;
use App\Http\Requests\Admin\Seats\DeleteSeatRequest;
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
    public function generateMap(int $theatreId, int $hallId)
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
        SeatService       $seatService
    )
    {
        $createSeatDto = new CreateSeatDTO(
            seatTypeId: $request->input('seat_type_id'),
            hallId: $request->input('hall_id'),
            row: $request->input('row'),
            number: $request->input('number'),
            posX: $request->input('position_x'),
            posY: $request->input('position_y'),
        );

        try {
            $seatService->createSeat($createSeatDto);

            return response()->json([
                'status' => true,
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
     * @param SeatService $seatService
     * @return JsonResponse
     */
    public function check(
        CheckSeatRequest $request,
        SeatService      $seatService,
    )
    {
        $checkSeatDto = new SeatIdDTO(
            seatId: $request->input('seat_id'),
        );

        try {
            $seat = $seatService->findSeat($checkSeatDto);

            $seatType = $seat->seatType->name;

            return response()->json([
                'status' => true,
                'seat' => $seat,
                'seatTypeName' => $seatType,
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
     * @param SeatService $seatService
     * @return JsonResponse
     */
    public function update(
        UpdateSeatRequest $request,
        SeatService       $seatService,
    )
    {
        $updateSeatDto = new UpdateSeatDTO(
            hallId: $request->input('hall_id'),
            seatId: $request->input('seat_id'),
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
     * @param DeleteSeatRequest $request
     * @param SeatService $seatService
     * @return JsonResponse
     */
    public function destroy(
        DeleteSeatRequest $request,
        SeatService       $seatService
    )
    {
        $deleteSeatDto = new SeatIdDTO(
            seatId: $request->input('seat_id'),
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
