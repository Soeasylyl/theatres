<?php

use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Ajax\Admin\MovieController;
use App\Http\Controllers\Ajax\Admin\ScreeningController;
use App\Http\Controllers\Ajax\Admin\SeatController;
use App\Http\Controllers\Ajax\Public\BookingController;
use App\Http\Controllers\Ajax\Public\HomeController;
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

// Public routes
Route::prefix('afisha')->group(function () {
    Route::prefix('/{movie:slug}')->group(function () {
        Route::get('/get-screenings', [HomeController::class, 'getScreenings'])
            ->name('public.show.screenings');

        Route::prefix('/{screening}/get-screenings-times')->group(function () {
            Route::get('/', [HomeController::class, 'getScreeningsTime'])
                ->name('public.get.screenings.time');
        });
    });
});

Route::prefix('theatres/{theatre}/halls/{hall}/screenings/{screening}')->group(function () {
    Route::get('/booking-map', [BookingController::class, 'generateBookingMap'])
        ->name('generate-booking-map');
    Route::get('/check-booking-seats', [BookingController::class, 'checkBookingSeats'])
        ->name('check-booking-seats');
});


// Admin-panel routes
Route::prefix('admin/')
    ->middleware([
        'auth',
        'isBlock',
        'AdminAccess'
    ])->group(function () {

        Route::prefix('screenings')->group(function () {
            Route::get('/get-halls', [ScreeningController::class, 'getHalls'])->name('screening.get-halls');
        });

        Route::prefix('movies')->group(function () {
            Route::get('/get-movies', [MovieController::class, 'getMovies'])->name('movie.get-movies');
        });

        Route::prefix('theatres/{theatre}/halls/{hall}/seats')
            ->middleware([
                'role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value,
                'CheckTheatreAccessMiddleware'
            ])->group(function () {
                Route::get('/map', [SeatController::class, 'generateMap'])->name('generateMap.create');
                Route::get('/undoing-location-check', [SeatController::class, 'check'])->name('seat.check');
                Route::post('/', [SeatController::class, 'store'])->name('seat.store');

                Route::prefix('{seat}/')->group(function () {
                    Route::patch('/', [SeatController::class, 'update'])->name('seat.update');
                    Route::delete('/', [SeatController::class, 'destroy'])->name('seat.delete');
                });
            });
    });
