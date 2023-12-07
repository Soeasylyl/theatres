<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\DeleteTheatreDTO;
use App\DTO\Theatres\EditTheatreDTO;
use App\DTO\Theatres\SearchTheatreDTO;
use App\DTO\Theatres\UpdateTheatreDTO;
use App\Http\Requests\Admin\Theatres\SearchRequest;
use App\Http\Requests\Admin\Theatres\TheatreRequest;
use App\Services\TheatreService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TheatreController extends BaseAdminController
{
    /**
     * @param SearchRequest $request
     * @param TheatreService $theatreService
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(SearchRequest $request, TheatreService $theatreService)
    {
        $authUser = auth()->user();
        $searchTern = $request->input('search');

        $searchTheatreDTO = new SearchTheatreDTO(
            producer: $authUser,
            searchTerm: $searchTern,
        );

        $theatres = $theatreService->getTheatresWithHallsPaginated($searchTheatreDTO);

        return view('admin.pages.theatres.theatres-information', compact('theatres', 'searchTern'));
    }

    /**
     *  Display the view for adding a new theatre.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('admin.pages.theatres.add');
    }

    /**
     * Processing a request to create a new cinema.
     *
     * @param TheatreRequest $request
     * @param TheatreService $theatreService
     * @return RedirectResponse
     */
    public function store(TheatreRequest $request, TheatreService $theatreService)
    {
        $authUser = auth()->user();
        $createTheatreDTO = new CreateTheatreDTO(
            user: $authUser,
            name: $request->input('name'),
            address: $request->input('address'),
            description: $request->input('description'),
            theatreImages: $request->file('theatreImages'),
        );

        try {
            $theatreService->createAndSaveTheatreWithMedia($createTheatreDTO);

            return redirect()
                ->route('theatres')
                ->with('successMessages', 'Кинотеатр ' . $createTheatreDTO->getName() . ' успешно добавлен');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     *  Display the edit view for a specific theatre based on its ID.
     *
     * @param int $theatreId
     * @param TheatreService $theatreService
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(int $theatreId, TheatreService $theatreService)
    {
        $editTheatreDTO = new EditTheatreDTO(
            theatreId: $theatreId,
        );

        $theatreData = $theatreService->getTheatreDataForEdit($editTheatreDTO);

        return view('admin.pages.theatres.edit', [
            'theatre' => $theatreData['theatre'],
            'halls' => $theatreData['halls'],
            'media' => $theatreData['media'],
            'seatsTypes' => $theatreData['seatsTypes'],
        ]);
    }

    /**
     * Update a theater's information based on the provided TheatreRequest and theatre ID.
     *
     * @param TheatreRequest $request
     * @param int $theatreId
     * @param TheatreService $theatreService
     * @return RedirectResponse
     */
    public function update(
        TheatreRequest $request,
        int            $theatreId,
        TheatreService $theatreService,
    )
    {
        $updateTheatreDTO = new UpdateTheatreDTO(
            theatreId: $theatreId,
            name: $request->input('name'),
            address: $request->input('address'),
            description: $request->input('description'),
            theatreImages: $request->file('$theatreImages'),
        );

        try {
            $theatreService->updateTheatre(dto: $updateTheatreDTO);

            return redirect()
                ->route('theatres')
                ->with('successMessages', 'Информация о кинотеатре ' . $updateTheatreDTO->getName() . ' успешно обновлена');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     *  Delete a theater based on the provided ID.
     *
     * @param int $theatreId
     * @param TheatreService $theatreService
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(int $theatreId, TheatreService $theatreService)
    {
        $deleteTheatreDTO = new DeleteTheatreDTO(
            theatreId: $theatreId,
        );

        try {
            $theatreService->deleteTheatre(theatreId: $deleteTheatreDTO->getTheatreId());

            return redirect()->back()->with('successMessages', 'Кинотеатр успешно удален.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
