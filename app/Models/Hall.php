<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hall extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cinema_id'
        ];

    public function cinema() : BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }
}
