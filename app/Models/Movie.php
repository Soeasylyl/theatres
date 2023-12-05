<?php

namespace App\Models;

use App\Events\ClearStoreEvent;
use App\Traits\HandlesMedia;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\Movie
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $session_duration
 * @property Carbon $date_start
 * @property float $rating
 * @property int $age_limit
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Genre> $genres
 * @property-read int|null $genres_count
 * @property-read Collection<int, Media> $medias
 * @property-read int|null $medias_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Screening> $screenings
 * @property-read int|null $screenings_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
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
    use HasApiTokens, HasFactory, Notifiable, HasSlug, HandlesMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'session_duration',
        'date_start',
        'rating',
        'age_limit',
        'slug',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'date_start' => 'date',
    ];

    protected $dispatchesEvents = [
      'deleting' => ClearStoreEvent::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Genre::class,
            table: 'movie_genre',
            foreignPivotKey: 'movie_id',
            relatedPivotKey: 'genre_id',
        );
    }

    /**
     * @return HasMany
     */
    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    /**
     * Get the poster media associated with the model.
     *
     * @return MorphOne
     */
    public function poster(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
                    ->where('collection', 'poster');
    }

    /**
     * Get the frames media associated with the model.
     *
     * @return MorphMany
     */
    public function frames(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')
                    ->where('collection', 'frames');
    }
}
