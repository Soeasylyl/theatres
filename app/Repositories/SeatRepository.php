<?php

namespace App\Repositories;

use App\Models\Hall;
use App\Models\Seat;
use App\Repositories\Interfaces\SeatRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class SeatRepository implements SeatRepositoryInterface
{
    /**
     * Create a new seat.
     *
     * @param Hall $hall
     * @param int $seatsTypeId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return Seat
     */
    public function createSeat(
        Hall  $hall,
        int   $seatsTypeId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY
    ): Seat
    {
        return $hall->seats()->create([
            'seat_type_id' => $seatsTypeId,
            'row' => $rowNumber,
            'number' => $seatNumber,
            'position_x' => $positionX,
            'position_y' => $positionY,
        ]);
    }

    /**
     * Updates information about the Seat.
     *
     * @param Seat $seat
     * @param int $hallId
     * @param int $seatsTypeId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return Seat
     */
    public function updateSeat(
        Seat  $seat,
        int   $hallId,
        int   $seatsTypeId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY,
    ): Seat
    {
        $seat->update([
            'seat_type_id' => $seatsTypeId,
            'hall_id' => $hallId,
            'row' => $rowNumber,
            'number' => $seatNumber,
            'position_x' => $positionX,
            'position_y' => $positionY,
        ]);

        return $seat;
    }

    /**
     *  Retrieve a seat by ID with specified conditions in the associated hall, theatre, and seat type.
     *
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatsTypeId
     * @param int $seatId
     * @return Seat
     */
    public function getSeatByIdWithTheatreAndHallAndSeatTypeConditionsOrFail(
        int $theatreId,
        int $hallId,
        int $seatsTypeId,
        int $seatId,
    ): Seat
    {
        return Seat::query()
            ->whereHas('hall', function (Builder $builder) use ($seatsTypeId, $theatreId, $hallId) {
                $builder->where('id', $hallId)
                    ->whereHas('theatre', function (Builder $builder) use ($seatsTypeId, $theatreId) {
                        $builder->where('id', $theatreId)
                            ->whereHas('seatTypes', function (Builder $builder) use ($seatsTypeId) {
                                $builder->where('id', $seatsTypeId);
                            });
                    });
            })
            ->findOrFail($seatId);
    }

    /**
     * Get a seat by ID, taking into account affiliation with the theater and hall.
     *
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatId
     * @param array|null $columns
     * @return Seat
     */
    public function getSeatByIdWithTheatreAndHallConditionsOrFail(
        int $theatreId,
        int $hallId,
        int $seatId,
        ?array $columns = ['*']
    ): Seat
    {
        return Seat::query()
            ->select($columns)
            ->whereHas('hall', function (Builder $builder) use ($theatreId, $hallId) {
                $builder->where('id', $hallId)
                    ->whereHas('theatre', function (Builder $builder) use ($theatreId) {
                        $builder->where('id', $theatreId);
                    });
            })
            ->findOrFail($seatId);
    }
}
