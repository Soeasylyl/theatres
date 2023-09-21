<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Media extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'path',
        'model_type',
        'model_id'
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
