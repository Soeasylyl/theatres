<?php

namespace App\Repositories;

use App\DTO\Theatres\CreateTheatreDTO;
use App\Models\Cinema;
use App\Repositories\Interfaces\TheatreRepositoryInterface;

class TheatreRepository implements TheatreRepositoryInterface
{
    /**
     * Creates a new theater based on data from the CreateTheatreDTO object.
     *
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

    /**
     * Creates a new theater based on data from the CreateTheatreDTO object and binds the specified user to it.
     *
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatreAndAttachUser(CreateTheatreDTO $dto): Cinema
    {
        $cinema = Cinema::create([
            'name' => $dto->getName(),
            'address' => $dto->getAddress(),
            'description' => $dto->getDescription(),
        ]);

        $cinema->users()->attach($dto->getUser()->id);

        return $cinema;
    }
}
