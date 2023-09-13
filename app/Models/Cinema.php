<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
//    use HasFactory;

    public function SeatTypes(): HasMany
    {
        return $this->hasMany(SeatType::class);
    }

    public function Halls(): HasMany
    {
        return $this->hasMany(Hall::class);
    }
}
