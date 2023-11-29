<?php

namespace App\Repositories;

use App\DTO\Theatres\CreateTheatreDTO;
use App\Models\Cinema;
use App\Repositories\Interfaces\TheatreRepositoryInterface;

class TheatreRepository implements TheatreRepositoryInterface
{
    /**
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatre(CreateTheatreDTO $dto): Cinema
    {
        return Cinema::create([
           'name' => $dto->getName(),
           'address' => $dto->getAddress(),
           'description' => $dto->getDescription(),
        ]);
    }
}
