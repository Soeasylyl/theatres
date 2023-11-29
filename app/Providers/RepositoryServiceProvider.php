<?php

namespace App\Providers;

use App\Repositories\CinemaRepository;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Repositories\MovieRepository;
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
            CinemaRepositoryInterface::class,
            CinemaRepository::class
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
            MediaRepositoryInterface::class,
            MediaRepository::class
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
