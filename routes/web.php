<?php

use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MovieController;
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
    Route::get('/{movie}', [HomeController::class, 'show'])->name('user.show.movie');
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

    // Movies management
    Route::prefix('movies')->group(function () {
        // List all movies
        Route::get('/', [MovieController::class, 'index'])->name('movies');

        // Movie editing and deleting
        Route::prefix('/')->middleware(['role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::MODERATOR->value])->group(function () {
            Route::get('{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
            Route::patch('{movie}/update', [MovieController::class, 'update'])->name('movie.update');
            Route::delete('{movie}',[MovieController::class, 'delete'])->name('movie.delete');

            // Movie creating
            Route::get('/create',[MovieController::class, 'show'])->name('movie.create');
            Route::post('/create',[MovieController::class, 'create']);
        });
    });

    // Theatre management
    Route::prefix('theatres')->group(function () {
        Route::get('/', [TheatreController::class, 'index'])->name('admin.theatres');
    });

    // Users management
    Route::prefix('users')->middleware(['role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value])->group(function () {
        // List all users and user creation routes
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'show'])->name('users.create');
        Route::post('/create', [UserController::class, 'create']);

        // User editing routes
        Route::prefix('/')->middleware('CheckUserAccessMiddleware')->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])
                ->withoutMiddleware(['role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value])
                ->name('user.edit');

            Route::patch('/{user}/update', [UserController::class, 'update'])
                ->name('user.update');

            Route::patch('/{user}/update-password', [UserController::class, 'updatePassword'])
                ->name('user.updatePassword');

            Route::patch('/{user}/update-profile', [UserController::class, 'updateProfile'])
                ->withoutMiddleware(['role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value])
                ->name('user.updateProfile');

            Route::patch('/{user}/update-password-profile', [UserController::class, 'updatePasswordProfile'])
                ->withoutMiddleware(['role:' . RolesUsersEnum::SUPER_ADMIN->value . '|' . RolesUsersEnum::CINEMA_ADMIN->value])
                ->name('user.updatePasswordProfile');

            Route::patch('/{user}/update-role', [UserController::class, 'updateRole'])
                ->name('user.updateRole');

            Route::patch('/{user}/update-cinema', [UserController::class, 'updateCinemaAction'])
                ->name('user.updateCinemaAction');

            Route::delete('/{user}', [UserController::class, 'delete'])
                ->name('user.delete');

            Route::patch('/{user}/block-user', [UserController::class, 'block'])
                ->name('user.block');
        });
    });
});
