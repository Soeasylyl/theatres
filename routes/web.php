<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
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

Route::get('/',[HomeController::class, 'index'])->name( 'public.pages.home');

Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.admin');
Route::post('/register', [RegisterController::class, 'register']);

Route::prefix('afisha')->group(function (){
    Route::get('/{slug}', [MovieController::class, 'show'])->name('user.show.movie');
});

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
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');

        Route::get('/create', [UserController::class, 'showAddForm'])->name('users.create');
        Route::post('/create', [UserController::class, 'createUser']);

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

        Route::put('/{user}/update-cinema', [UserController::class, 'updateCinema'])
            ->where('user', '[0-9]+')
            ->name('user.updateCinema');

        Route::delete('/{user}', [UserController::class, 'delete'])
            ->where('user', '[0-9]+')
            ->name('user.delete');
    });
});
