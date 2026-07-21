<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\News;
use App\Models\RiskScore;
use App\Models\Weather;
use Illuminate\Database\Seeder;

class RiskScoreSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Country::all() as $country) {

            $weather = Weather::where('country_id', $country->id)->first();
            $exchange = ExchangeRate::where('country_id', $country->id)->first();
            $news = News::where('country_id', $country->id)->first();

            $weatherScore = $weather?->weather_score ?? 0;
            $exchangeScore = $exchange?->exchange_score ?? 0;
            $newsScore = $news?->news_score ?? 0;

            // Karena inflation masih 0 di CountrySeeder
            $inflationScore = rand(1, 5);

            $totalScore = $weatherScore + $exchangeScore + $newsScore + $inflationScore;

            if ($totalScore <= 15) {
                $status = 'low';
            } elseif ($totalScore <= 25) {
                $status = 'medium';
            } else {
                $status = 'high';
            }

            RiskScore::create([
                'country_id' => $country->id,
                'weather_score' => $weatherScore,
                'inflation_score' => $inflationScore,
                'exchange_score' => $exchangeScore,
                'news_score' => $newsScore,
                'total_score' => $totalScore,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}