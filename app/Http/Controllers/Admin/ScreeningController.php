<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\GetHallsDTO;
use App\DTO\Screening\CreateScreeningDTO;
use App\DTO\Screening\DeleteScreeningDTO;
use App\DTO\Screening\EditScreeningDTO;
use App\DTO\Screening\SearchScreeningDTO;
use App\DTO\Users\GetUserDTO;
use App\Http\Requests\Admin\Screenings\ajaxGetHallsRequest;
use App\Http\Requests\Admin\Screenings\CreateScreeningRequest;
use App\Http\Requests\Admin\Screenings\DeleteScreeningRequest;
use App\Http\Requests\Admin\Screenings\SearchScreeningRequest;
use App\Services\ScreeningService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScreeningController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        SearchScreeningRequest $request,
        ScreeningService       $screeningService,
    )
    {
        $authUser = auth()->user();
        $searchScreeningDTO = new SearchScreeningDTO(
            producer: $authUser,
            theatreId: $request->input('fTheatre'),
            date: $request->input('fDate'),
            fScreenings: $request->input('fScreenings'),
            searchTerm: $request->input('search'),
        );

        $data = $screeningService->getScreeningsBasedOnRolePaginated($searchScreeningDTO);

        return view('admin.pages.screenings.index', [
            'screenings' => $data['screenings'],
            'theatres' => $data['theatres'],
            'fTheatre' => $searchScreeningDTO->getTheatreId(),
            'fDate' => $searchScreeningDTO->getDate(),
            'fScreenings' => $searchScreeningDTO->getFScreenings(),
            'searchTern' => $searchScreeningDTO->getSearchTerm(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(
        ScreeningService $screeningService,
    )
    {
        $getUserDto = new GetUserDTO(
            producer: auth()->user(),
        );

        $theatres = $screeningService->getTheatres($getUserDto->getProducer());

        return view('admin.pages.screenings.add', compact('theatres'));
    }

    /**
     * Processes an AJAX request to obtain a list of theaters based on the specified theater ID.
     *
     * @param ajaxGetHallsRequest $request
     * @param ScreeningService $screeningService
     * @return JsonResponse
     */
    public function getHalls(
        ajaxGetHallsRequest $request,
        ScreeningService    $screeningService,
    )
    {
        $getHallsDto = new GetHallsDTO(
            $request->input('theatreId')
        );

        try {
            $halls = $screeningService->getHalls($getHallsDto);

            return response()->json([
                'status' => true,
                'halls' => $halls,
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        CreateScreeningRequest $request,
        ScreeningService       $screeningService,
    )
    {
        $createScreeningDto = new CreateScreeningDTO(
            producer: auth()->user(),
            theatreId: $request->input('theatre'),
            hallId: $request->input('hall'),
            movieId: $request->input('movie_id'),
            price: $request->input('price'),
            dateStart: $request->input('date'),
            timeZone: $request->input('timeZone'),
        );

        try {
            $screeningService->createScreening($createScreeningDto);

            return redirect()
                ->route('screening.index')
                ->with('successMessages', 'Сеанс успешно добавлен');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Displays the session edit page with relevant data.
     *
     * @param int $screeningId
     * @param ScreeningService $screeningService
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(
        int              $screeningId,
        ScreeningService $screeningService,
    )
    {
        $editScreeningDto = new EditScreeningDTO(
            screeningId: $screeningId,
        );

        $data = $screeningService->getScreeningDataToEdit($editScreeningDto);

        return view('admin.pages.screenings.edit', [
            'screening' => $data['screening'],
            'screeningHall' => $data['screeningHall'],
            'halls' => $data['halls'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param int $id
     * @param DeleteScreeningRequest $request
     * @param ScreeningService $screeningService
     * @return RedirectResponse
     */
    public function destroy(
        int                    $id,
        DeleteScreeningRequest $request,
        ScreeningService       $screeningService,
    )
    {
        $deleteScreeningDto = new DeleteScreeningDTO(
            screeningId: $id,
            theatreId: $request->input('theatre_id'),
            producer: auth()->user(),
        );

        try {
            $screeningService->deleteScreening($deleteScreeningDto);

            return redirect()
                ->route('screening.index')
                ->with('successMessages', 'Сеанс успешно удалён');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
