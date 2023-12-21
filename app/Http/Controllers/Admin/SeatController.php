<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\EditHallDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Halls\AjaxSeatsRequest;
use App\Services\HallService;
use App\Services\SeatTypeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
