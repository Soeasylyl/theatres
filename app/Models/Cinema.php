<?php

namespace App\Models;

use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Cinema
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Hall> $halls
 * @property-read int|null $halls_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SeatType> $seatTypes
 * @property-read int|null $seat_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\CinemaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cinema whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cinema extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HandlesMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'address',
    ];

    /**
     * @return HasMany
     */
    public function seatTypes(): HasMany
    {
        return $this->hasMany(SeatType::class);
    }

    /**
     * @return HasMany
     */
    public function halls(): HasMany
    {
        return $this->hasMany(Hall::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'user_cinema',
            foreignPivotKey: 'cinema_id',
            relatedPivotKey: 'user_id',
        );
    }
}
