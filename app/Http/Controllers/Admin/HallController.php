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

    public function create(int $theatreId)
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(theatreId: $theatreId, relations: ['seatTypes']);
        $seatTypes = $theatre->seatTypes;
        $numberRow = 0;
        $seatsData = [];

        return view('admin.pages.halls.add', compact('seatTypes', 'theatreId', 'numberRow', 'seatsData'));
    }

    public function store(Request $request)
    {
        dd($request->all(), json_decode($request->input('seats_data')));
    }

    public function showRowSeats(Request $request)
    {
        $countSeats = $request->input('seats_count');
        $seatTypeId = $request->get('seats_type');
        $numberRow = $request->get('count_row');


        $viewPath = 'admin.pages.halls.hall-row-ajax';

        $template = view($viewPath, [
            'countSeats' => (int)$countSeats,
            'seatTypeId' => $seatTypeId,
            'numberRow' => $numberRow,
        ])->render();

        return response()->json(
            [
                'html' => $template,
            ]
        );
    }
}
