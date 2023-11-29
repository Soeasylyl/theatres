<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\Http\Requests\Admin\SeatTypes\SeatTypeRequest;
use App\Services\SeatTypeService;

class SeatTypeController extends BaseAdminController
{
    public function __construct(
        private readonly SeatTypeService $seatTypeService,
    )
    {
    }

    public function create(SeatTypeRequest $request, int $theatreId)
    {
        $seatTypeDTO = new CreateSeatTypeDTO(
            theatreId: $theatreId,
            name: $request->input('seat_name'),
            description: $request->input('seat_description'),
            amount: $request->input('seat_amount'),
        );

        try {
            $seatType = $this->seatTypeService->createSeatTypeByTheatre(dto: $seatTypeDTO);

            return redirect()
                ->route('theatre.edit',['theatres' => $seatTypeDTO->getTheatreId()])
                ->with('successMessages', 'Тип места: ' . $seatType->name . ' успешно добавлен');
        } catch (\Throwable $e) {
            return redirect()
                ->route('theatre.edit',['theatres' => $seatTypeDTO->getTheatreId()])
                ->with('error', 'Ошибка при создании типа мест ' . $e->getMessage());
        }
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
