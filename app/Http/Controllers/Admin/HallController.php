<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\DeleteHallDTO;
use App\DTO\Halls\EditHallDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Http\Requests\Admin\Halls\DeleteHallRequest;
use App\Http\Requests\Admin\Halls\CreateAndUpdateHallRequest;
use App\Services\HallService;
use App\Services\SeatTypeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HallController extends BaseAdminController
{
    public function __construct(
        private readonly HallService $hallService,
        private readonly SeatTypeService $seatTypeService,
    )
    {
    }

    /**
     * Display the form for creating a new hall, providing necessary data for the view.
     *
     * @param int $theatreId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(int $theatreId)
    {
        $hallData = $this->hallService->getDataForCreate($theatreId);

        return view('admin.pages.halls.add', [
            'theatreId' => $theatreId,
            'seatTypes' => $hallData['seatTypes'],
        ]);
    }

    /**
     * Store a new hall in the specified theatre based on the provided form data.
     *
     * @param CreateAndUpdateHallRequest $request
     * @param int $theatreId
     * @return RedirectResponse
     */
    public function store(CreateAndUpdateHallRequest $request, int $theatreId)
    {
        $createHallDto = new CreateHallDTO(
            theatreId: $theatreId,
            name: $request->input('name'),
            description: $request->input('description'),
            rows: $request->input('rows'),
            hallImages: $request->file('hallImages'),
        );

        try {
            $this->hallService->createHall(dto: $createHallDto);

            return redirect()
                ->route('theatre.edit', ['theatres' => $createHallDto->getTheatreId()])
                ->with('successMessages', 'Зал ' . $createHallDto->getName() . ' успешно добавлен');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     *  Process the request to delete a hall and redirect back with a success message.
     *
     * @param DeleteHallRequest $request
     * @return RedirectResponse
     */
    public function destroy(DeleteHallRequest $request)
    {
        $deleteHallDto = new DeleteHallDTO(
            hallId: $request->input('hall_id'),
        );

        $this->hallService->deleteHall($deleteHallDto);

        return redirect()->back()->with('successMessages', 'Зал успешно удалён.');
    }

    /**
     * Displays the hall editing page
     *
     * @param int $theatreId
     * @param int $hallId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(int $theatreId, int $hallId)
    {
        $editHallDto = new EditHallDTO(
            theatreId: $theatreId,
            hallId: $hallId,
        );

        $hall = $this->hallService->getHall($editHallDto->getHallId());
        $seatTypes = $this->seatTypeService->getSeatsTypeToHall($editHallDto->getTheatreId());

        return view('admin.pages.halls.edit', [
            'theatres' => $theatreId,
            'halls' => $hallId,
            'seatTypes' => $seatTypes,
            'hall' => $hall,
        ]);
    }

    /**
     * @param CreateAndUpdateHallRequest $request
     * @param int $theatreId
     * @param int $hallId
     * @return RedirectResponse
     */
    public function update(CreateAndUpdateHallRequest $request, int $theatreId, int $hallId)
    {
        $updateHallDto = new UpdateHallDTO(
            theatreId: $theatreId,
            hallId: $hallId,
            name: $request->input('name'),
            description: $request->input('description'),
            rows: $request->get('rows'),
            hallImages: $request->file('hallImages'),
        );

        try {
            $this->hallService->updateHall(dto: $updateHallDto);

            return redirect()
                ->route('theatre.edit', ['theatres' => $updateHallDto->getTheatreId()])
                ->with('successMessages', 'Информация о зале ' . $updateHallDto->getName() . ' изменена');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
