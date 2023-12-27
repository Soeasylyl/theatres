<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Screening\SearchScreeningDTO;
use App\Services\ScreeningService;
use Illuminate\Http\Request;

class ScreeningController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request $request,
        ScreeningService $sessionService,
    )
    {
        $authUser = auth()->user();
        $checkRoleUserDTO = new SearchScreeningDTO(
            producer: $authUser,
            theatreId: $request->get('theatre'),
            date: $request->get('date'),
        );

        $data = $sessionService->getScreeningsBasedOnRolePaginated($checkRoleUserDTO);

        return view('admin.pages.screenings.index', [
            'screenings' => $data['screenings'],
            'theatres' => $data['theatres'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
