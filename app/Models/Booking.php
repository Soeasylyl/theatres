<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'status',
        'screening_id',
        'seat_id',
        'user_id',
        'slug'
    ];

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function payments(): hasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
