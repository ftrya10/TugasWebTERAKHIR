<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weather;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weather::insert([

            [
                'country_id' => 1,
                'temperature' => '18°C',
                'condition' => 'Cloudy',
                'weather_score' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 2,
                'temperature' => '30°C',
                'condition' => 'Sunny',
                'weather_score' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 3,
                'temperature' => '32°C',
                'condition' => 'Rainy',
                'weather_score' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 4,
                'temperature' => '22°C',
                'condition' => 'Sunny',
                'weather_score' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}