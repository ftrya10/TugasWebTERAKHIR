<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Weather;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    public function run(): void
    {
        $weatherData = [
            [
                'code' => 'ID',
                'temperature' => 30.0,
                'condition' => 'Windy',
                'weather_score' => 7,
            ],
            [
                'code' => 'CN',
                'temperature' => 25.0,
                'condition' => 'Clear',
                'weather_score' => 3,
            ],
            [
                'code' => 'DE',
                'temperature' => 18.0,
                'condition' => 'Cloudy',
                'weather_score' => 4,
            ],
            [
                'code' => 'AU',
                'temperature' => 22.0,
                'condition' => 'Sunny',
                'weather_score' => 2,
            ],
            [
                'code' => 'US',
                'temperature' => 20.0,
                'condition' => 'Clear',
                'weather_score' => 3,
            ],
            [
                'code' => 'JP',
                'temperature' => 24.0,
                'condition' => 'Rainy',
                'weather_score' => 5,
            ],
            [
                'code' => 'SG',
                'temperature' => 31.0,
                'condition' => 'Thunderstorm',
                'weather_score' => 8,
            ],
            [
                'code' => 'GB',
                'temperature' => 15.0,
                'condition' => 'Cloudy',
                'weather_score' => 4,
            ],
        ];

        foreach ($weatherData as $data) {
            $country = Country::where('code', $data['code'])->first();

            if ($country) {
                Weather::updateOrCreate(
                    [
                        'country_id' => $country->id,
                    ],
                    [
                        'temperature' => $data['temperature'],
                        'condition' => $data['condition'],
                        'weather_score' => $data['weather_score'],
                    ]
                );
            }
        }
    }
}
