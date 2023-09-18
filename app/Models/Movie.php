<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Movie extends Model
{
    protected $fillable = [
        'name',
        'description',
        'session_duration',
        'date_start',
        'rating',
        'age_limit',
        'slug'
    ];

    protected $casts = [
        'date_start' => 'date'
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'movie-genre');
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
