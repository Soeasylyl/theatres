<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\EditTheatreDTO;
use App\DTO\Theatres\SearchTheatreDTO;
use App\Http\Requests\Admin\Theatres\SearchRequest;
use App\Http\Requests\Admin\Theatres\TheatreRequest;
use App\Services\TheatreService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class TheatreController extends BaseAdminController
{
    public function __construct(
        private readonly TheatreService $theatreService)
    {
    }



    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(SearchRequest $request)
    {
        $authUser = auth()->user();
        $searchTern = $request->input('search');

        $searchTheatreDTO = new SearchTheatreDTO(
            producer: $authUser,
            searchTerm: $searchTern,
        );

        $theatres = $this->theatreService->getTheatresWithHallsPaginated($searchTheatreDTO);

        return view('admin.pages.theatres.theatres-information', compact('theatres', 'searchTern'));
    }

    public function show()
    {
        return view('admin.pages.theatres.add');
    }

    /**
     * Processing a request to create a new cinema.
     *
     * @param TheatreRequest $request
     * @return RedirectResponse
     */
    public function create(TheatreRequest $request)
    {
        $authUser = auth()->user();
        $createTheatreDTO = new CreateTheatreDTO(
            user: $authUser,
            name: $request->input('name'),
            address: $request->input('address'),
            description: $request->input('description'),
            theatreImages: $request->file('$theatreImages'),
        );

        try {
            $this->theatreService->createAndSaveTheatreWithMedia($createTheatreDTO);

            return redirect()
                ->route('theatres')
                ->with('successMessages', 'Кинотеатр ' . $createTheatreDTO->getName() . ' успешно добавлен');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $theatreId)
    {
        $editTheatreDTO = new EditTheatreDTO(
            theatreId: $theatreId,
        );

        $theatreData = $this->theatreService->getTheatreDataForEdit($editTheatreDTO);

        return view('admin.pages.theatres.edit', [
            'theatre'=> $theatreData['theatre'],
            'halls' => $theatreData['halls'],
            'media' => $theatreData['media'],
            'seatsTypes' => $theatreData['seatsTypes'],
        ]);
    }
}
