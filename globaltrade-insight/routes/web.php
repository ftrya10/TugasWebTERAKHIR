<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('dashboard');

})->name('logout');


/*
|--------------------------------------------------------------------------
| MAIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN INTELLIGENCE CENTER
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            AdminController::class,
            'dashboard'
        ])->name('dashboard');

        Route::get('/users', [
            AdminController::class,
            'users'
        ])->name('users');

        Route::get('/ports', [
            AdminController::class,
            'ports'
        ])->name('ports');

        Route::get('/articles', [
            AdminController::class,
            'articles'
        ])->name('articles');

    });


/*
|--------------------------------------------------------------------------
| RISK INTELLIGENCE
|--------------------------------------------------------------------------
|
| URL:
|
| /risk
| /risk/country/1
| /risk/api
|
*/

Route::prefix('risk')
    ->name('risk.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Risk Intelligence Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/', [
            RiskController::class,
            'index'
        ])->name('index');


        /*
        |----------------------------------------------------------------------
        | Risk Intelligence API
        |----------------------------------------------------------------------
        */

        Route::get('/api', [
            RiskController::class,
            'api'
        ])->name('api');


        /*
        |----------------------------------------------------------------------
        | Country Risk Intelligence Detail
        |----------------------------------------------------------------------
        */

        Route::get('/country/{countryId}', [
            RiskController::class,
            'show'
        ])->name('show');

    });


/*
|--------------------------------------------------------------------------
| COUNTRY INTELLIGENCE CENTER
|--------------------------------------------------------------------------
*/

Route::prefix('countries')
    ->name('countries.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Country Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/', [
            CountryController::class,
            'index'
        ])->name('index');


        /*
        |----------------------------------------------------------------------
        | Country Profile API
        |----------------------------------------------------------------------
        */

        Route::get('/api/detail/{name}', [
            CountryController::class,
            'getCountryDetail'
        ])->name('api.detail');


        /*
        |----------------------------------------------------------------------
        | Economic Intelligence API
        |----------------------------------------------------------------------
        */

        Route::get('/api/economic/{countryCode}', [
            CountryController::class,
            'getEconomicData'
        ])->name('api.economic');


        /*
        |----------------------------------------------------------------------
        | Country Detail
        |----------------------------------------------------------------------
        */

        Route::get('/{country}', [
            CountryController::class,
            'show'
        ])->name('show');

    });


/*
|--------------------------------------------------------------------------
| WEATHER INTELLIGENCE
|--------------------------------------------------------------------------
*/

Route::prefix('weather')
    ->name('weather.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Weather Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/', [
            WeatherController::class,
            'index'
        ])->name('index');


        /*
        |----------------------------------------------------------------------
        | Current Weather API
        |----------------------------------------------------------------------
        */

        Route::get('/api/{lat}/{lng}', [
            WeatherController::class,
            'getWeather'
        ])->name('api');


        /*
        |----------------------------------------------------------------------
        | Weather Sync
        |----------------------------------------------------------------------
        */

        Route::get('/sync', [
            WeatherController::class,
            'sync'
        ])->name('sync');


        /*
        |----------------------------------------------------------------------
        | Weather Country Detail
        |----------------------------------------------------------------------
        */

        Route::get('/{countryId}', [
            WeatherController::class,
            'show'
        ])->name('show');

    });


/*
|--------------------------------------------------------------------------
| CURRENCY INTELLIGENCE
|--------------------------------------------------------------------------
*/

Route::prefix('exchange')
    ->name('exchange.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Currency Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/', [
            CurrencyController::class,
            'index'
        ])->name('index');


        /*
        |----------------------------------------------------------------------
        | Exchange Rate API
        |----------------------------------------------------------------------
        */

        Route::get('/api/{baseCurrency?}', [
            CurrencyController::class,
            'getExchangeRates'
        ])->name('api');

    });


/*
|--------------------------------------------------------------------------
| NEWS INTELLIGENCE
|--------------------------------------------------------------------------
*/

Route::prefix('news')
    ->name('news.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Global News Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/', [
            NewsController::class,
            'index'
        ])->name('index');


        /*
        |----------------------------------------------------------------------
        | GNews API
        |----------------------------------------------------------------------
        */

        Route::get('/api', [
            NewsController::class,
            'getNews'
        ])->name('api');


        /*
        |----------------------------------------------------------------------
        | News Detail
        |----------------------------------------------------------------------
        */

        Route::get('/{id}', [
            NewsController::class,
            'show'
        ])->name('show');

    });


/*
|--------------------------------------------------------------------------
| PORT INTELLIGENCE
|--------------------------------------------------------------------------
*/

Route::prefix('ports')
    ->name('ports.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Global Port Intelligence Map
        |----------------------------------------------------------------------
        */

        Route::get('/', [
            PortController::class,
            'index'
        ])->name('index');


        /*
        |----------------------------------------------------------------------
        | Search Ports By Country
        |----------------------------------------------------------------------
        */

        Route::get('/api/country/{countryName}', [
            PortController::class,
            'getPortsByCountry'
        ])->name('api.country');


        /*
        |----------------------------------------------------------------------
        | Port Detail
        |----------------------------------------------------------------------
        */

        Route::get('/{id}', [
            PortController::class,
            'show'
        ])->name('show');

    });


/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/

Route::fallback(function () {

    return redirect()->route('dashboard');

});
