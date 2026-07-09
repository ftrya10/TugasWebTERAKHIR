<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskScore;

class RiskScoreSeeder extends Seeder
{
    public function run(): void
    {
        RiskScore::insert([

            [
                'country_id' => 1,
                'weather_score' => 5,
                'inflation_score' => 2,
                'exchange_score' => 4,
                'news_score' => 3,
                'total_score' => 14,
                'status' => 'Low Risk',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 2,
                'weather_score' => 8,
                'inflation_score' => 1,
                'exchange_score' => 8,
                'news_score' => 7,
                'total_score' => 24,
                'status' => 'Medium Risk',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 3,
                'weather_score' => 10,
                'inflation_score' => 3,
                'exchange_score' => 10,
                'news_score' => 10,
                'total_score' => 33,
                'status' => 'High Risk',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'country_id' => 4,
                'weather_score' => 4,
                'inflation_score' => 2,
                'exchange_score' => 5,
                'news_score' => 2,
                'total_score' => 13,
                'status' => 'Low Risk',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}