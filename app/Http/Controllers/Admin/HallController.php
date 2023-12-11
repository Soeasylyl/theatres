<?php

namespace App\Http\Controllers\Admin;


use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\DeleteHallDTO;
use App\DTO\Halls\EditHallDTO;
use App\DTO\Halls\RenderSeatsDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Http\Requests\Admin\Halls\DeleteHallRequest;
use App\Http\Requests\Admin\Halls\HallRequest;
use App\Http\Requests\Admin\Halls\SeatsDataRowRequest;
use App\Services\HallService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class HallController extends BaseAdminController
{
    public function __construct(
        private readonly HallService $hallService,
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
            'numberRow' => $hallData['numberRow'],
        ]);
    }

    /**
     * Store a new hall in the specified theatre based on the provided form data.
     *
     * @param HallRequest $request
     * @param int $theatresId
     * @return RedirectResponse
     */
    public function store(HallRequest $request, int $theatresId)
    {
        $createHallDto = new CreateHallDTO(
            theatresId: $theatresId,
            name: $request->input('name'),
            description: $request->input('description'),
            rows: $request->input('rows'),
            hallImages: $request->file('hallImages'),
        );

        try {
            $this->hallService->createHall(dto: $createHallDto);

            return redirect()
                ->route('theatre.edit', ['theatres' => $createHallDto->getTheatresId()])
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
     * Display the rendered HTML template for a specific row of seats.
     *
     * @param SeatsDataRowRequest $request
     * @return JsonResponse
     */
    public function showRowSeats(SeatsDataRowRequest $request)
    {
        $renderSeatsDto = new RenderSeatsDTO(
            seatsTypeId: $request->get('seats_type'),
            countSeats: $request->input('seats_count'),
            numberRow: $request->get('count_row'),
            htmlContent: 'admin.pages.halls.hall-row-ajax',
        );

        $template = $this->hallService->renderTemplate(dto: $renderSeatsDto);

        return response()->json(
            [
                'html' => $template,
            ]
        );
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
            theatresId: $theatreId,
            hallId: $hallId,
        );

        $dataHall = $this->hallService->getDataHall($editHallDto);


        return view('admin.pages.halls.edit', [
            'theatres' => $theatreId,
            'halls' => $hallId,
            'dataHall' => $dataHall['dataSeats'],
            'seatTypes' => $dataHall['seatsTypes'],
            'hall' => $dataHall['hall'],
        ]);
    }

    public function update(HallRequest $request, int $theatresId, int $hallId)
    {
        $updateHallDto = new UpdateHallDTO(
            theatresId: $theatresId,
            hallId: $hallId,
            name: $request->input('name'),
            description: $request->input('description'),
            rows: $request->get('rows'),
            hallImages: $request->file('hallImages'),
        );

        try {
            $this->hallService->updateHall(dto: $updateHallDto);

            return redirect()
                ->route('theatre.edit', ['theatres' => $updateHallDto->getTheatresId()])
                ->with('successMessages', 'Информация о зале ' . $updateHallDto->getName() . ' изменена');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
