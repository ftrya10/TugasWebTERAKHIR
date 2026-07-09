<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\FavoriteController;

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Countries
    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries');

    // Trade Analysis
    Route::get('/trade-analysis', [TradeController::class, 'index'])
        ->name('trade');

    // Weather
    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather');

    // Exchange Rate
    Route::get('/exchange-rate', [CurrencyController::class, 'index'])
        ->name('exchange');

    // Global News
    Route::get('/global-news', [NewsController::class, 'index'])
        ->name('news');

    // Port Map
    Route::get('/port-map', [PortController::class, 'index'])
        ->name('port');

    // Risk Analysis
    Route::get('/risk-analysis', [RiskController::class, 'index'])
        ->name('risk');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('favorites');

});

require __DIR__.'/auth.php';