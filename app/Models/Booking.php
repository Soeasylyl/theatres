<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = ['status'];

    public function screening(): BelongsTo
    {
        return $this->BelongsTo(Screening::class);
    }

    public function seat(): BelongsTo
    {
        return $this->BelongsTo(Seat::class);
    }

    public function payments(): hasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

}
