<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\DTO\Halls\GetHallsDTO;
use App\Http\Controllers\Ajax\Admin\BaseAdminController;
use App\Http\Requests\Admin\Screenings\ajaxGetHallsRequest;
use App\Services\ScreeningService;
use Illuminate\Http\JsonResponse;

class ScreeningController extends BaseAdminController
{
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
}
