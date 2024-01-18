<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'row' => $this->row,
            'number' => $this->number,
            'seatsTypeName' => $this->seatType->name,
            'seatsTypeId' => $this->seatType->id,
            'posX' => $this->position_x,
            'posY' => $this->position_y,
            'price' => $this->seatType->amount,
        ];
    }
}
