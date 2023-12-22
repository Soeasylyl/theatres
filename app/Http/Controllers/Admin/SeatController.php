<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\EditHallDTO;
use App\DTO\Seats\DeleteSeatDTO;
use App\DTO\Seats\UpdateSeatDTO;
use App\Http\Requests\Admin\Seats\DeleteSeatRequest;
use App\Http\Requests\Admin\Seats\UpdateSeatRequest;
use App\Services\HallService;
use App\Services\SeatService;
use App\Services\SeatTypeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeatController extends BaseAdminController
{

    public function __construct(
        private readonly HallService     $hallService,
        private readonly SeatTypeService $seatTypeService,
    )
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
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
        $deleteSeatDto = new DeleteSeatDTO(
            seatId: $request->input('seat_id'),
        );
        try {
            $seatService->deleteSeat($deleteSeatDto);

            return response()->json([
                'status' => true,
                'message' => 'Место успешно удалено',
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
