<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\TheatreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\public\HomeController;
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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.admin');
Route::post('/register', [RegisterController::class, 'register']);

Route::prefix('afisha')->group(function () {
    Route::get('/{movie:slug}', [MovieController::class, 'show'])->name('user.show.movie');
});

Route::prefix('admin')->middleware(['auth', 'AdminAccess'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('admin.movies');
    });

    Route::prefix('theatres')->group(function () {
        Route::get('/', [TheatreController::class, 'index'])->name('admin.theatres');
    });

    Route::prefix('users')->middleware(['permission:' . \App\Enums\PermissionsUsersEnum::MANAGE_USERS->value])->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('users');

        Route::get('/create', [UserController::class, 'showAddForm'])
            ->name('users.create');

        Route::post('/create', [UserController::class, 'create']);

        Route::prefix('/')->middleware('CheckUserAccessMiddleware')->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])
                ->where('user', '[0-9]+')
                ->name('user.edit');

            Route::put('/{user}/update', [UserController::class, 'update'])
                ->where('user', '[0-9]+')
                ->name('user.update');

            Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])
                ->where('user', '[0-9]+')
                ->name('user.updatePassword');

            Route::put('/{user}/update-profile', [UserController::class, 'updateProfile'])
                ->where('user', '[0-9]+')
                ->name('user.updateProfile');

            Route::put('/{user}/update-password-profile', [UserController::class, 'updatePasswordProfile'])
                ->where('user', '[0-9]+')
                ->name('user.updatePasswordProfile');

            Route::put('/{user}/update-role', [UserController::class, 'updateRole'])
                ->where('user', '[0-9]+')
                ->name('user.updateRole');

            Route::put('/{user}/update-cinema', [UserController::class, 'updateCinemaAction'])
                ->where('user', '[0-9]+')
                ->name('user.updateCinemaAction');

            Route::delete('/{user}', [UserController::class, 'delete'])
                ->where('user', '[0-9]+')
                ->name('user.delete');
        });
    });
});
