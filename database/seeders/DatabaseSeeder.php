<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            WeatherSeeder::class,
            ExchangeRateSeeder::class,
            NewsSeeder::class,
            RiskScoreSeeder::class,
        ]);
    }
}