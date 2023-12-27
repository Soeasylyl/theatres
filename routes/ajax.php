<?php

use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Admin\SeatController;
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

// Admin-panel routes
Route::prefix('/admin/theatres/{theatre}/halls/{hall}/seats')
    ->middleware([
        'auth',
        'isBlock',
        'AdminAccess',
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
