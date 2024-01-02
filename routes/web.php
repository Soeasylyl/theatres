<?php

use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeatController;
use App\Http\Controllers\Admin\SeatTypeController;
use App\Http\Controllers\Admin\ScreeningController;
use App\Http\Controllers\Admin\TheatreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('public.pages.home');

Route::prefix('afisha')->group(function () {
    Route::get('/{movie:slug}', [HomeController::class, 'show'])->name('user.show.movie');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.admin');
Route::post('/register', [RegisterController::class, 'register']);

// Admin-panel routes
Route::prefix('admin')->middleware(['auth', 'isBlock', 'AdminAccess'])->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // Screenings management
    Route::prefix('screenings')->group(function () {
        Route::get('/', [ScreeningController::class, 'index'])->name('screening.index');
        Route::get('/create', [ScreeningController::class, 'create'])->name('screening.create');
        Route::post('/', [ScreeningController::class, 'store'])->name('screening.store');
        Route::delete('{screening}/', [ScreeningController::class, 'destroy'])->name('screening.delete');
    });

    // Movies management
    Route::prefix('movies')->group(function () {
        // List all movies
        Route::get('/', [MovieController::class, 'index'])->name('movies');

        // Movie editing and deleting
        Route::middleware([
            'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::MODERATOR->value
        ])->group(function () {
            Route::get('{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
            Route::patch('{movie}/', [MovieController::class, 'update'])->name('movie.update');
            Route::delete('{movie}/', [MovieController::class, 'destroy'])->name('movie.delete');

            // Movie creating
            Route::get('/create', [MovieController::class, 'create'])->name('movie.create');
            Route::post('/', [MovieController::class, 'store'])->name('movie.store');
        });
    });

    // Theatre management
    Route::prefix('theatres')->group(function () {
        Route::get('/', [TheatreController::class, 'index'])->name('theatres');

        // Theatre CRUD
        Route::middleware([
            'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value
        ])->group(function () {
            Route::get('/create', [TheatreController::class, 'create'])->name('theatre.create');
            Route::post('/', [TheatreController::class, 'store'])->name('theatre.store');

            Route::middleware('CheckTheatreAccessMiddleware')->group(function () {
                Route::get('{theatre}/edit', [TheatreController::class, 'edit'])->name('theatre.edit');
                Route::patch('{theatre}/', [TheatreController::class, 'update'])->name('theatre.update');
                Route::delete('{theatre}/', [TheatreController::class, 'destroy'])->name('theatre.delete');

                //Seat Type CRUD
                Route::prefix('{theatre}/seat-types')->group(function () {
                    Route::post('/', [SeatTypeController::class, 'store'])->name('seat-type.create');
                    Route::patch('/', [SeatTypeController::class, 'update'])->name('seat-type.update');
                    Route::delete('/', [SeatTypeController::class, 'destroy'])->name('seat-type.delete');
                });

                //Hall CRUD
                Route::prefix('{theatre}/halls/')->group(function () {
                    Route::get('/', [HallController::class, 'create'])->name('hall.create');
                    Route::post('/', [HallController::class, 'store'])->name('hall.store');
                    Route::delete('/', [HallController::class, 'destroy'])->name('hall.delete');

                    Route::prefix('{hall}')->group(function () {
                        Route::get('/', [HallController::class, 'edit'])->name('hall.edit');
                        Route::patch('/', [HallController::class, 'update'])->name('hall.update');

                        Route::get('/seats', [SeatController::class, 'create'])->name('seat.create');
                    });
                });
            });
        });
    });

    // Users management
    Route::prefix('users')->middleware([
        'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value
    ])->group(function () {
        // List all users and user creation routes
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');

        // User editing routes
        Route::prefix('/')->middleware('CheckUserAccessMiddleware')->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])
                ->withoutMiddleware([
                    'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value
                ])
                ->name('user.edit');

            Route::patch('/{user}/', [UserController::class, 'update'])
                ->name('user.update');

            Route::patch('/{user}/password', [UserController::class, 'updatePassword'])
                ->name('user.updatePassword');

            Route::patch('/{user}/profiles', [UserController::class, 'updateProfile'])
                ->withoutMiddleware([
                    'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value
                ])
                ->name('user.updateProfile');

            Route::patch('/{user}/profile-password', [UserController::class, 'updatePasswordProfile'])
                ->withoutMiddleware([
                    'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value
                ])
                ->name('user.updatePasswordProfile');

            Route::patch('/{user}/roles', [UserController::class, 'updateRole'])
                ->name('user.updateRole');

            Route::patch('/{user}/cinemas', [UserController::class, 'updateCinemaAction'])
                ->name('user.updateCinemaAction');

            Route::delete('/{user}', [UserController::class, 'destroy'])
                ->name('user.delete');

            Route::patch('/{user}/block-users', [UserController::class, 'block'])
                ->name('user.block');
        });
    });
});
