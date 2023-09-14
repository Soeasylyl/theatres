<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'status',
        'amount',
        'booking_id'
        ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
