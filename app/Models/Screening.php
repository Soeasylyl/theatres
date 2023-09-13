<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Screening extends Model
{
    protected $fillable = ['start_at', 'price'];

    public function movie(): BelongsTo
    {
        return $this->BelongsTo(Movie::class);
    }

    public function hall(): BelongsTo
    {
        return $this->BelongsTo(Hall::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
