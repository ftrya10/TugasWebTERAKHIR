<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::redirect('/', '/dashboard');


Route::middleware(['auth'])->group(function(){


    // Dashboard utama
    Route::get('/dashboard',
        [DashboardController::class,'index']
    )->name('dashboard');


    // Menu Countries
    Route::view('/countries', 'pages.countries')
        ->name('countries');


    // Menu Trade Analysis
    Route::view('/trade-analysis', 'pages.trade')
        ->name('trade');


    // Menu Weather
    Route::view('/weather', 'pages.weather')
        ->name('weather');


    // Menu Exchange Rate
    Route::view('/exchange-rate', 'pages.exchange')
        ->name('exchange');


    // Menu Global News
    Route::view('/global-news', 'pages.news')
        ->name('news');


    // Menu Port Map
    Route::view('/port-map', 'pages.port')
        ->name('port');


    // Menu Risk Analysis
    Route::view('/risk-analysis', 'pages.risk')
        ->name('risk');


    // Menu Favorites
    Route::view('/favorites', 'pages.favorites')
        ->name('favorites');


});


require __DIR__.'/auth.php';