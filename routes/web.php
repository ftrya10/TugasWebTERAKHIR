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
        ->name('countries.index');

    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');

    Route::get('/api/country-detail/{name}', 
        [CountryController::class, 'getCountryDetail'])
        ->name('api.country.detail');


    // World Bank API (GDP, Inflation, Population, Export, Import)
    Route::get('/api/economic/{code}', 
        [CountryController::class, 'getEconomicData'])
        ->name('api.economic');



    // Weather
    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather.index');

    Route::get('/weather/sync', [WeatherController::class, 'sync'])
        ->name('weather.sync');

    Route::get('/api/weather/{lat}/{lng}', 
        [WeatherController::class, 'getWeather'])
        ->name('api.weather');



    // Exchange Rate
    Route::get('/exchange-rate', [CurrencyController::class, 'index'])
        ->name('exchange-rate.index');

    Route::get('/exchange-rate/sync', [CurrencyController::class, 'sync'])
        ->name('exchange.sync');

    Route::get('/api/rates/{base?}', 
        [CurrencyController::class, 'getExchangeRates'])
        ->name('api.rates');



    // Global News
    Route::get('/global-news', [NewsController::class, 'index'])
        ->name('global-news.index');

    Route::get('/global-news/sync', [NewsController::class, 'sync'])
        ->name('news.sync');

    Route::get('/api/news', 
        [NewsController::class, 'getNews'])
        ->name('api.news');



    // Trade Analysis
    Route::get('/trade-analysis', [TradeController::class, 'index'])
        ->name('trade');



    // Port Map
    Route::get('/port-map', [PortController::class, 'index'])
        ->name('port.index');

    Route::get('/api/ports/{country}', 
        [PortController::class, 'getPortsByCountry'])
        ->name('api.ports');



    // Risk Analysis
    Route::get('/risk-analysis', [RiskController::class, 'index'])
        ->name('risk.index');

    Route::get('/risk-analysis/calculate', 
        [RiskController::class, 'calculate'])
        ->name('risk.calculate');



    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('favorites.index');

});


require __DIR__.'/auth.php';