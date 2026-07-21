<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/countries', [\App\Http\Controllers\CountryController::class, 'index'])->name('countries.index');
    Route::get('/countries/{country}', [\App\Http\Controllers\CountryController::class, 'show'])->name('countries.show');
    
    Route::get('/compare', [\App\Http\Controllers\CompareController::class, 'index'])->name('compare');
    
    Route::get('/ports', [\App\Http\Controllers\PortController::class, 'index'])->name('ports.index');
    
    Route::get('/currency', [\App\Http\Controllers\CurrencyController::class, 'index'])->name('currency.index');
    
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Articles (User-facing: read-only)
    Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Admin Articles CRUD
    Route::get('/articles', [\App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('articles.index');
    Route::post('/articles', [\App\Http\Controllers\Admin\ArticleController::class, 'store'])->name('articles.store');
    Route::put('/articles/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'destroy'])->name('articles.destroy');
});

require __DIR__.'/auth.php';
