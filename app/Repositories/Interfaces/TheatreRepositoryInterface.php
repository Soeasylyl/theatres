<?php

namespace App\Repositories\Interfaces;

use App\DTO\Theatres\CreateTheatreDTO;
use App\Models\Cinema;

interface TheatreRepositoryInterface
{
    /**
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatre(CreateTheatreDTO $dto): Cinema;
}
