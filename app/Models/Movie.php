<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Movie
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $session_duration
 * @property \Illuminate\Support\Carbon $date_start
 * @property float $rating
 * @property int $age_limit
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Screening> $screenings
 * @property-read int|null $screenings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\MovieFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereAgeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereSessionDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Movie extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'session_duration',
        'date_start',
        'rating',
        'age_limit',
        'slug',
    ];

    protected $casts = [
        'date_start' => 'date',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'movie_genre',
            'movie_id',
            'genre_id',
        );
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(
            Media::class,
            'model',
            'model_type',
            'model_id',
        );
    }
}
