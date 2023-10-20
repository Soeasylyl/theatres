<?php

namespace App\Repositories;



use App\Models\Cinema;
use App\Repositories\Interfaces\CinemaRepositoryInterface;


class CinemaRepository implements CinemaRepositoryInterface
{
    /*
     * Obtaining information about all users except authorized and super administrator
     */
    public function getAllCinemas()
    {
         return Cinema::all();
    }
}
