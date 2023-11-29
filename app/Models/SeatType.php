<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\SeatType
 *
 * @property int $id
 * @property int $cinema_id
 * @property string $name
 * @property string $description
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cinema $cinema
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Seat> $seats
 * @property-read int|null $seats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\SeatTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereCinemaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeatType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeatType extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'amount',
        'cinema_id',
    ];

    /**
     * @return BelongsTo
     */
    public function cinema() : BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * @return HasMany
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
