<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Http\Request;

class HallController extends BaseAdminController
{
    public function __construct(
        private readonly TheatreRepositoryInterface $theatreRepository,
    )
    {

    }

    public function show(int $theatreId)
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(theatreId: $theatreId, relations: ['seatTypes']);
        $seatTypes = $theatre->seatTypes;

        return view('admin.pages.halls.add', compact('seatTypes'));
    }

    public function create()
    {

    }

    public function showRowSeats(Request $request)
    {
        $countSeats = $request->input('seats_count');
        $seatTypeId = $request->get('seats_type');

        $viewPath = 'admin.pages.halls.hall-row-ajax';

        $template = view($viewPath, [
            'countSeats' => (int)$countSeats,
            'seatTypeId' => $seatTypeId,
        ])->render();

        return response()->json(
            [
                'html' => $template,
            ]
        );
    }
}
