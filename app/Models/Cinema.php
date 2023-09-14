<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Cinema extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address'
    ];

    public function seatTypes(): HasMany
    {
        return $this->hasMany(SeatType::class);
    }

    public function halls(): HasMany
    {
        return $this->hasMany(Hall::class);
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }
}
