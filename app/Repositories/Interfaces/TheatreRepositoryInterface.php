<?php

namespace App\Repositories\Interfaces;

use App\DTO\Theatres\CreateTheatreDTO;
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
     * Creates a new theater based on data from the CreateTheatreDTO object and binds the specified user to it.
     *
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatreAndAttachUser(CreateTheatreDTO $dto): Cinema;
}
