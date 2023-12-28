<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Screening\SearchScreeningDTO;
use App\Http\Requests\Admin\Screenings\SearchScreeningRequest;
use App\Services\ScreeningService;
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
}
