<?php

namespace App\Repositories;

use App\Models\Hall;
use App\Models\Seat;
use App\Repositories\Interfaces\SeatRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class SeatRepository implements SeatRepositoryInterface
{
    /**
     * Create a new seat within the specified hall based on provided seat details.
     *
     * @param int $seatsTypeId
     * @param int $hallId
     * @param int $theatreId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return Seat
     */
    public function createSeat(
        int   $seatsTypeId,
        int   $hallId,
        int   $theatreId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY
    ): Seat
    {
        $hall = Hall::query()
            ->where('theatre_id', $theatreId)
            ->when($seatsTypeId, function (Builder $builder) use ($seatsTypeId, $theatreId) {
                $builder->whereHas('theatre', function (Builder $query) use ($seatsTypeId) {
                    $query->whereHas('seatTypes', function (Builder $seatTypeQuery) use ($seatsTypeId) {
                        $seatTypeQuery->where('id', $seatsTypeId);
                    });
                });
            })
            ->when($hallId, function (Builder $builder) use ($hallId) {
                $builder->where('id', $hallId);
            })
            ->firstOrFail();

        return $hall->seats()->create([
            'seat_type_id' => $seatsTypeId,
            'hall_id' => $hallId,
            'row' => $rowNumber,
            'number' => $seatNumber,
            'position_x' => $positionX,
            'position_y' => $positionY,
        ]);
    }

    /**
     * Gets a Seat by identifier with the ability to load associated data.
     *
     * @param int $seatId
     * @param array|null $relations
     * @param array|null $columns
     * @return Seat
     */
    public function getSeatById(int $seatId, ?array $relations = [], ?array $columns = ['*']): Seat
    {
        return Seat::select($columns)->with($relations)->find($seatId);
    }

    /**
     * Updates information about the Seat.
     *
     * @param int $seatId
     * @param int $seatsTypeId
     * @param int $hallId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return bool|int
     */
    public function updateSeat(
        int   $seatId,
        int   $seatsTypeId,
        int   $hallId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY,
    ): bool|int
    {
        return Seat::where('id', $seatId)->update([
            'seat_type_id' => $seatsTypeId,
            'hall_id' => $hallId,
            'row' => $rowNumber,
            'number' => $seatNumber,
            'position_x' => $positionX,
            'position_y' => $positionY,
        ]);
    }

    /**
     * Delete seats in a hall that are not present in the given list of seat IDs.
     *
     * @param int $hallId
     * @param array $seatIdsList
     * @return bool
     */
    public function deleteSeatsNotInList(int $hallId, array $seatIdsList): bool
    {
        return Seat::where('hall_id', $hallId)
            ->whereNotIn('id', $seatIdsList)
            ->delete();
    }

    /**
     * Deletes a seat with the given seat ID.
     *
     * @param int $seatId
     * @return bool
     */
    public function deleteSeatsByIdOrFail(int $seatId): bool
    {
        return Seat::findOrFail($seatId)->delete();
    }
}
