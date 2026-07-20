<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::insert([

            [
                'name' => 'Germany',
                'code' => 'DEU',
                'flag' => null,
                'region' => 'Europe',
                'gdp' => '$4.7 Trillion',
                'inflation' => 2.4,
                'population' => '84 Million',
                'currency' => 'EUR',
                'latitude' => 51.1657,
                'longitude' => 10.4515,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'China',
                'code' => 'CHN',
                'flag' => null,
                'region' => 'Asia',
                'gdp' => '$18 Trillion',
                'inflation' => 0.7,
                'population' => '1.4 Billion',
                'currency' => 'CNY',
                'latitude' => 35.8617,
                'longitude' => 104.1954,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Indonesia',
                'code' => 'IDN',
                'flag' => null,
                'region' => 'Asia',
                'gdp' => '$1.5 Trillion',
                'inflation' => 3.2,
                'population' => '280 Million',
                'currency' => 'IDR',
                'latitude' => -2.5489,
                'longitude' => 118.0149,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Australia',
                'code' => 'AUS',
                'flag' => null,
                'region' => 'Oceania',
                'gdp' => '$1.8 Trillion',
                'inflation' => 2.9,
                'population' => '27 Million',
                'currency' => 'AUD',
                'latitude' => -25.2744,
                'longitude' => 133.7751,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}