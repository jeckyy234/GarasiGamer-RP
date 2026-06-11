<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PsTypeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RentalController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/get-available-units/{psTypeId}', [RentalController::class, 'getAvailableUnits'])
    ->name('rentals.get-units');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PS Types management
    Route::resource('ps-types', PsTypeController::class)->except(['show', 'edit', 'create']);
    Route::get('/ps-types', [PsTypeController::class, 'index'])->name('ps-types.index');

    // Games management
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

    // Rentals
    Route::get('/rental/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rental', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/history', [RentalController::class, 'history'])->name('rentals.history');
    Route::patch('/rental/{rental}/return', [RentalController::class, 'return'])->name('rentals.return');
    Route::get('/get-price', [RentalController::class, 'getPrice'])->name('rentals.get-price');
});

Route::get('/', function () {
    return redirect('/admin/dashboard');
})->middleware('auth');

Route::get('/get-available-units/{psTypeId}', [RentalController::class, 'getAvailableUnits'])
    ->name('admin.rentals.get-units');

    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... route lain yang sudah ada ...

    Route::get('/get-available-units/{psTypeId}', [RentalController::class, 'getAvailableUnits'])
        ->name('rentals.get-units');

    // Route resource untuk rental
    Route::get('/rental/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rental', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/history', [RentalController::class, 'history'])->name('rentals.history');
    Route::patch('/rental/{rental}/return', [RentalController::class, 'return'])->name('rentals.return');
});
