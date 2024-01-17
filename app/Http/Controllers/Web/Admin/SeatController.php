<?php

namespace App\Http\Controllers\Web\Admin;

use App\DTO\Halls\EditHallDTO;
use App\Services\SeatTypeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SeatController extends BaseAdminController
{
    public function __construct(
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
}
