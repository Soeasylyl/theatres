<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * App\Models\Screening
 *
 * @property int $id
 * @property int $movie_id
 * @property int $hall_id
 * @property string $price
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Models\Hall $hall
 * @property-read \App\Models\Movie $movie
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Screening newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Screening newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Screening query()
 * @method static \Illuminate\Database\Eloquent\Builder|Screening whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Screening whereHallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Screening whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Screening whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Screening wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Screening whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Screening whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Screening extends Model
{
    use HasApiTokens, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'start_at',
        'price',
        'movie_id',
        'hall_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'start_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

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
     *  An accessor for the price attribute that removes the "$" character from the beginning of the value
     *  and returns a cleaned string.
     *
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value): string
    {
        return ltrim($value, '$');
    }
}
