<?php

namespace App\Repositories\Interfaces;

use App\DTO\Theatres\CreateTheatreDTO;
use App\Models\Cinema;

interface TheatreRepositoryInterface
{
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
