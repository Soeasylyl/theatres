<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SeatResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        dd($this->collection);
        return [
            $this->row => [
                $this->id => [
                    'number' => $this->number,
                    'seatsTypeName' => $this->seatType->name,
                    'seatsTypeId' => $this->seatType->id,
                    'posX' => $this->position_x,
                    'posY' => $this->position_y,
                    'price' => $this->seatType->amount,
                ]
            ]
        ];
    }
}
