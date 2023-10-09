<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TheatreController;
use App\Http\Controllers\Admin\UserController;
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

Route::view('/', 'welcome');

Auth::routes();

Route::prefix('admin')->middleware('AdminAccess')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('admin.movies');
    });

    Route::prefix('theatres')->group(function () {
        Route::get('/', [TheatreController::class, 'index'])->name('admin.theatres');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [AdminProfileController::class, 'profile'])->name('admin.profile');
        Route::put('/update-info', [AdminProfileController::class, 'updateInfo'])->name('admin.profile.updateInfo');
        Route::put('/update-password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.updatePassword');
        Route::delete('/', [AdminProfileController::class, 'deleteProfile'])->name('admin.profile.delete');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');

        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->where('user', '[0-9]+')
            ->name('user.edit');

        Route::put('/{user}/update-info', [UserController::class, 'updateInfo'])
            ->where('user', '[0-9]+')
            ->name('user.updateInfo');

        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])
            ->where('user', '[0-9]+')
            ->name('user.updatePassword');

        Route::put('/{user}/update-role', [UserController::class, 'updateRole'])
            ->where('user', '[0-9]+')
            ->name('user.updateRole');

        Route::delete('/{user}', [UserController::class, 'delete'])
            ->where('user', '[0-9]+')
            ->name('user.delete');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles');
    });
});
