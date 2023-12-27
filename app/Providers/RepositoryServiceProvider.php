<?php

namespace App\Providers;

use App\Repositories\HallRepository;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\SeatRepositoryInterface;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;
use App\Repositories\Interfaces\ScreeningRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MovieRepository;
use App\Repositories\SeatRepository;
use App\Repositories\SeatTypeRepository;
use App\Repositories\ScreeningRepository;
use App\Repositories\TheatreRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            MovieRepositoryInterface::class,
            MovieRepository::class
        );

        $this->app->bind(
            TheatreRepositoryInterface::class,
            TheatreRepository::class
        );

        $this->app->bind(
            SeatTypeRepositoryInterface::class,
            SeatTypeRepository::class
        );

        $this->app->bind(
            HallRepositoryInterface::class,
            HallRepository::class
        );

        $this->app->bind(
            SeatRepositoryInterface::class,
            SeatRepository::class
        );

        $this->app->bind(
            ScreeningRepositoryInterface::class,
            ScreeningRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
