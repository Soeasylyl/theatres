<?php

namespace App\Repositories\Interfaces;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\UpdateTheatreDTO;
use App\Models\Cinema;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TheatreRepositoryInterface
{
    /**
     * Get all cinemas
     *
     * @return LengthAwarePaginator
     */
    public function getCinemasPaginateList(): LengthAwarePaginator;

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @param string|null $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getTheatresPaginateList(?string $searchTerm, ?array $relations = []): LengthAwarePaginator;

    /**
     * Gets a filtered list of movie theaters to which the specified user belongs.
     *
     * @param User $authUser
     * @param string|null $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getFilteredTheatresByProducer(User $authUser, ?string $searchTerm, ?array $relations = []): LengthAwarePaginator;

    /**
     * Creates a new theater based on data from the CreateTheatreDTO object.
     *
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatre(CreateTheatreDTO $dto): Cinema;

    /**
     * Retrieves a theater object by its ID, or throws an exception if the theater is not found.
     *
     * @param int $theatreId
     * @param array|null $relations
     * @return Cinema
     */
    public function getTheatreByIdOrFail(int $theatreId, ?array $relations = []): Cinema;

    /**
     *  Update the information of a cinema (theatre) entity based on the provided UpdateTheatreDTO.
     *
     * @param Cinema $theatre
     * @param UpdateTheatreDTO $dto
     * @return Cinema
     */
    public function updateTheatreInfo(Cinema $theatre, UpdateTheatreDTO $dto): Cinema;
}
