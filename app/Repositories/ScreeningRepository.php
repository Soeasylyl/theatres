<?php

namespace App\Repositories;

use App\DTO\Screening\CreateScreeningDTO;
use App\DTO\Screening\UpdateScreeningDTO;
use App\Models\Screening;
use App\Models\User;
use App\Repositories\Interfaces\ScreeningRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ScreeningRepository implements ScreeningRepositoryInterface
{
    /**
     * Gets a list of paginated sessions depending on various parameters,
     * such as cinema, date, show type (all, upcoming, completed) and search by movie title.
     *
     * @param string|null $fScreening
     * @param string|null $searchTerm
     * @param int|null $theatreId
     * @param string|null $date
     * @return LengthAwarePaginator
     */
    public function getScreeningsPaginateList(
        ?string $fScreening,
        ?string $searchTerm = null,
        ?int    $theatreId = null,
        ?string $date = null,
    ): LengthAwarePaginator
    {
        $now = now();

        return Screening::with(['hall.theatre', 'movie'])
            ->when(!is_null($theatreId), fn(Builder $builder) =>
                $builder->whereHas('hall.theatre', fn(Builder $subBuilder) =>
                    $subBuilder->where('id', $theatreId)))
            ->when(!is_null($date), fn(Builder $builder) =>
                $builder->whereDate('start_at', $date))
            ->when($fScreening === 'upcoming', fn(Builder $builder) =>
                $builder->where('start_at', '>', $now))
            ->when($fScreening === 'completed', fn(Builder $builder) =>
                $builder->where('start_at', '<', $now))
            ->when(!is_null($searchTerm), fn(Builder $builder) =>
                $builder->whereHas('movie', fn(Builder $builder) =>
                    $builder->where('name', 'ilike', "%$searchTerm%")))
            ->orderBy('start_at', 'desc')
            ->paginate(config('app.pagination_limit'));
    }

    /**
     *  Retrieves a filtered list of sessions for a producer with pagination.
     *
     * @param User $producer
     * @param string|null $fScreening
     * @param string|null $searchTerm
     * @param int|null $theatreId
     * @param string|null $date
     * @return LengthAwarePaginator
     */
    public function getFilteredScreeningsByProducer(
        User    $producer,
        ?string $fScreening,
        ?string $searchTerm = null,
        ?int    $theatreId = null,
        ?string $date = null,
    ): LengthAwarePaginator
    {
        $now = now();

        return Screening::with(['hall.theatre', 'movie'])
            ->when(!is_null($date), fn(Builder $builder) =>
                $builder->whereDate('start_at', $date))
            ->when(!is_null($theatreId), fn(Builder $builder) =>
                $builder->whereHas('hall.theatre', fn(Builder $builder) =>
                    $builder->where('id', $theatreId)))
            ->whereHas('hall.theatre.users', fn(Builder $builder) =>
                $builder->where('user_id', $producer->id))
            ->when($fScreening === 'upcoming', fn(Builder $builder) =>
                $builder->where('start_at', '>', $now))
            ->when($fScreening === 'completed', fn(Builder $builder) =>
                $builder->where('start_at', '<', $now))
            ->when(!is_null($searchTerm), fn(Builder $builder) =>
                $builder->whereHas('movie', fn(Builder $builder) =>
                    $builder->where('name', 'ilike', "%$searchTerm%")))
            ->orderBy('start_at', 'desc')
            ->paginate(config('app.pagination_limit'));
    }

    /**
     *  Creates a new session based on the transferred data.
     *
     * @param CreateScreeningDTO $dto
     * @return Screening
     */
    public function createScreening(CreateScreeningDTO $dto): Screening
    {
        return Screening::create([
            'movie_id' => $dto->getMovieId(),
            'hall_id' => $dto->getHallId(),
            'price' => $dto->getPrice(),
            'start_at' => $dto->getDateStart(),
        ]);
    }

    /**
     *  Retrieve a screening by its ID, eagerly loading specified relations.
     *
     * @param int $screeningId
     * @param array $relations
     * @return Screening
     */
    public function getScreeningByIdOrFail(int $screeningId, array $relations = []): Screening
    {
        return Screening::with($relations)->findOrFail($screeningId);
    }

    /**
     *  Updates session data in the database based on the passed data from the UpdateScreeningDTO object.
     *
     * @param Screening $screening
     * @param UpdateScreeningDTO $dto
     * @return Screening
     */
    public function updateScreening(
        Screening $screening,
        UpdateScreeningDTO $dto
    ): Screening
    {
         $screening->update([
           'movie_id' => $dto->getMovieId(),
           'hall_id' => $dto->getHallId(),
           'price' => $dto->getPrice(),
           'start_at' => $dto->getDateStart(),
       ]);

        return $screening;
    }
}
