<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\DeleteSeatTypeDTO;
use App\DTO\SeatTypes\UpdateSeatTypeDTO;
use App\Http\Requests\Admin\SeatTypes\SeatTypeRequest;
use App\Http\Requests\Admin\SeatTypes\UpdateSeatTypeRequest;
use App\Services\SeatTypeService;
use Illuminate\Http\RedirectResponse;

class SeatTypeController extends BaseAdminController
{
    public function __construct(
        private readonly SeatTypeService $seatTypeService,
    )
    {
    }

    /**
     *  Creates a new type of movie theater location.
     *
     * @param SeatTypeRequest $request
     * @param int $theatreId
     * @return RedirectResponse
     */
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

            return redirect()->back()->with('successMessages', 'Тип места: ' . $seatType->name . ' успешно добавлен');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Ошибка при создании типа мест ' . $e->getMessage());
        }
    }

    /**
     *  Update a seat type based on the provided request.
     *
     * @param UpdateSeatTypeRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateSeatTypeRequest $request )
    {
        $updateSeatTypeDTO = new UpdateSeatTypeDTO(
            seatTypeId: $request->input('seat_id'),
            name: $request->input('seat_name'),
            description: $request->input('seat_description'),
            amount: $request->input('seat_amount'),
        );

        try {
            $this->seatTypeService->updateSeatType(dto: $updateSeatTypeDTO);

            return redirect()
                ->back()
                ->with('successMessages', 'Информация о типе места ' . $updateSeatTypeDTO->getName() . 'успешно изменена');
        } catch (\Throwable $e) {
            return  redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Processes a request to delete a place type, including checking associated places and redirecting with a message.
     *
     * @param int $seatTypeId
     * @return RedirectResponse
     */
    public function delete(int $seatTypeId)
    {
        $deleteSeatTypeDTO = new DeleteSeatTypeDTO(
            seatTypeId: $seatTypeId,
        );

        try {
            $this->seatTypeService->deleteSeatTypeWithCheck(dto: $deleteSeatTypeDTO);

            return redirect()->back()->with('successMessages', 'Тип места успешно удален.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Ошибка при удалении типа мест ' . $e->getMessage());
        }
    }
}
