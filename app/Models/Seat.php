<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Seat
 *
 * @property int $id
 * @property int $seat_type_id
 * @property int $hall_id
 * @property int $row
 * @property float $position_x
 * @property float $position_y
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Models\Hall $hall
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\SeatType $seatType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\SeatFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Seat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereHallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereSeatTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereUpdatedAt($value)
 * @property int $number
 * @method static \Illuminate\Database\Eloquent\Builder|Seat whereNumber($value)
 * @mixin \Eloquent
 */
class Seat extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'row',
        'number',
        'hall_id',
        'seat_type_id',
        'position_x',
        'position_y',
    ];

    /**
     * @return BelongsTo
     */
    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return BelongsTo
     */
    public function seatType(): BelongsTo
    {
        return $this->belongsTo(SeatType::class);
    }
}
