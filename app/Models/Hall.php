<?php

namespace App\Models;

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
 * @property-read \App\Models\Cinema $cinema
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
 * @mixin \Eloquent
 */
class Hall extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'cinema_id',
        ];

    public function cinema() : BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class,
            'model',
            'model_type',
            'model_id',
        );
    }
}
