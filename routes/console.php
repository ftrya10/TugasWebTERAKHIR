<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\UpdateExchangeRates;
use App\Jobs\UpdateWeatherData;
use App\Jobs\UpdateNewsData;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new UpdateExchangeRates)->everyMinute();
Schedule::job(new UpdateWeatherData)->everyTwoMinutes();
Schedule::job(new UpdateNewsData)->everyFiveMinutes();
