<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Halls\GetHallsDTO;
use App\DTO\Screening\SearchScreeningDTO;
use App\DTO\Users\GetUserDTO;
use App\Http\Requests\Admin\Screenings\ajaxGetHallsRequest;
use App\Http\Requests\Admin\Screenings\SearchScreeningRequest;
use App\Repositories\HallRepository;
use App\Services\ScreeningService;
use Illuminate\Http\JsonResponse;
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
        ScreeningService      $screeningService,
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
