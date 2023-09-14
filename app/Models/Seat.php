<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    protected $fillable = [
        'description',
        'status',
        'row',
        'hall_id',
        'seat_type_id',
        'position_x',
        'position_y'
        ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function seatType(): BelongsTo
    {
        return $this->belongsTo(SeatType::class);
    }
}
