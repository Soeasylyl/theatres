<?php

namespace App\Models;

use App\Contracts\MediaHandling;
use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Hall
 *
 * @property int $id
 * @property int $cinema_id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Theatre $cinema
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Screening> $screenings
 * @property-read int|null $screenings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Seat> $seats
 * @property-read int|null $seats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\HallFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Hall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hall query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereCinemaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereUpdatedAt($value)
 * @property int $theatre_id
 * @property-read \App\Models\Theatre $theatre
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereTheatreId($value)
 * @mixin \Eloquent
 */
class Hall extends Model implements MediaHandling
{
    use HasApiTokens, HasFactory, Notifiable, HandlesMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function theatre(): BelongsTo
    {
        return $this->belongsTo(Theatre::class);
    }

    /**
     * @return HasMany
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * @return HasMany
     */
    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
}
