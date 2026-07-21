<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'currency' => 'IDR',
                'region' => 'Asia',
                'flag' => 'https://flagcdn.com/w320/id.png',
                'latitude' => -0.7893,
                'longitude' => 113.9213,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'currency' => 'CNY',
                'region' => 'Asia',
                'flag' => 'https://flagcdn.com/w320/cn.png',
                'latitude' => 35.8617,
                'longitude' => 104.1954,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'Germany',
                'code' => 'DE',
                'currency' => 'EUR',
                'region' => 'Europe',
                'flag' => 'https://flagcdn.com/w320/de.png',
                'latitude' => 51.1657,
                'longitude' => 10.4515,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'Australia',
                'code' => 'AU',
                'currency' => 'AUD',
                'region' => 'Oceania',
                'flag' => 'https://flagcdn.com/w320/au.png',
                'latitude' => -25.2744,
                'longitude' => 133.7751,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'currency' => 'USD',
                'region' => 'Americas',
                'flag' => 'https://flagcdn.com/w320/us.png',
                'latitude' => 37.0902,
                'longitude' => -95.7129,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'Japan',
                'code' => 'JP',
                'currency' => 'JPY',
                'region' => 'Asia',
                'flag' => 'https://flagcdn.com/w320/jp.png',
                'latitude' => 36.2048,
                'longitude' => 138.2529,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'Singapore',
                'code' => 'SG',
                'currency' => 'SGD',
                'region' => 'Asia',
                'flag' => 'https://flagcdn.com/w320/sg.png',
                'latitude' => 1.3521,
                'longitude' => 103.8198,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'currency' => 'GBP',
                'region' => 'Europe',
                'flag' => 'https://flagcdn.com/w320/gb.png',
                'latitude' => 55.3781,
                'longitude' => -3.4360,
                'gdp' => 0,
                'inflation' => 0,
                'population' => 0,
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
