<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
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


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('movies');
//        Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
//        Route::delete('/{movie}', [MovieController::class, 'delete'])->name('movie.delete');
//        Route::get('/create', [MovieController::class, 'create'])->name('movie.create');
//        Route::post('/ ', [MovieController::class, 'store'])->name('movie.store');
//        Route::get('/{movie}', [MovieController::class, 'show'])->name('movie.show');
//        Route::put('/{movie}', [MovieController::class, 'update'])->name('movie.update');
    });

    Route::prefix('theatres')->group(function () {
        Route::get('/', [TheatreController::class, 'index'])->name('theatres');
//        Route::get('/create', [TheatreController::class, 'create'])->name('theatre.create');
//        Route::post('/ ', [TheatreController::class, 'store'])->name('theatre.store');
//        Route::get('/{movie}', [TheatreController::class, 'show'])->name('theatre.show');
//        Route::get('/{movie}/edit', [TheatreController::class, 'edit'])->name('theatre.edit');
//        Route::put('/{movie}', [TheatreController::class, 'update'])->name('theatre.update');
//        Route::delete('/{movie}', [TheatreController::class, 'delete'])->name('theatre.delete');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [AdminProfileController::class, 'profile'])->name('admin.profile');
        Route::put('/', [AdminProfileController::class, 'updateInfo'])->name('admin.profile.updateInfo');
        Route::put('/', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.updat$userRole = Auth::user()->roles->first();ePassword');
        Route::delete('/', [AdminProfileController::class, 'deleteProfile'])->name('admin.profile.delete');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}/update-info', [UserController::class, 'updateInfo'])->name('user.updateInfo');
        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
        Route::put('/{user}/update-role', [UserController::class, 'updateRole'])->name('user.updateRole');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('user.delete');
//        Route::get('/create', [UserController::class, 'create'])->name('user.create');
//        Route::post('/ ', [UserController::class, 'store'])->name('user.store');
//        Route::get('/{movie}', [UserController::class, 'show'])->name('user.show');
        //        Route::get('/{column}/{direction}', [UserController::class, 'sort'])->name('users.sort');

    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles');
//        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
//        Route::post('/ ', [RoleController::class, 'store'])->name('role.store');
//        Route::get('/{movie}', [RoleController::class, 'show'])->name('role.show');
//        Route::get('/{movie}/edit', [RoleController::class, 'edit'])->name('role.edit');
//        Route::put('/{movie}', [RoleController::class, 'update'])->name('role.update');
//        Route::delete('/{movie}', [RoleController::class, 'delete'])->name('role.delete');
    });


});

//Route::get('/dashboard', function () {
//    return view('admin.pages.dashboard');
//});
