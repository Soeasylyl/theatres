<?php

namespace App\Repositories\Interfaces;

use App\DTO\Screening\CreateScreeningDTO;
use App\Models\Screening;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ScreeningRepositoryInterface
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
    ): LengthAwarePaginator;

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
    ): LengthAwarePaginator;

    /**
     *  Creates a new session based on the transferred data.
     *
     * @param CreateScreeningDTO $dto
     * @return Screening
     */
    public function createScreening(CreateScreeningDTO $dto): Screening;
}
