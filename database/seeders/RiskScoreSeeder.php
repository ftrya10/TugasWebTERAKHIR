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

            $rawWeather = (float) ($weather?->weather_score ?? 3);
            $weatherScore = $rawWeather <= 10 ? $rawWeather * 10 : $rawWeather;

            $inflation = (float) ($country->inflation ?? 0);
            $inflationScore = min(100, max(0, $inflation * 12));

            $rawExchange = (float) ($exchange?->exchange_score ?? 3);
            $exchangeScore = $rawExchange <= 10 ? $rawExchange * 10 : $rawExchange;

            if ($news) {
                if ($news->sentiment === 'Negative') {
                    $newsScore = 80;
                } elseif ($news->sentiment === 'Neutral') {
                    $newsScore = 45;
                } else {
                    $newsScore = 15;
                }
            } else {
                $newsScore = 30;
            }

            $totalScore = \App\Services\RiskService::calculateTotal($weatherScore, $inflationScore, $exchangeScore, $newsScore);
            $statusStr = \App\Services\RiskService::getStatus($totalScore);
            $status = strtolower(explode(' ', $statusStr)[0]);

            RiskScore::updateOrCreate(
                ['country_id' => $country->id],
                [
                    'weather_score' => $weatherScore,
                    'inflation_score' => $inflationScore,
                    'exchange_score' => $exchangeScore,
                    'news_score' => $newsScore,
                    'total_score' => $totalScore,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}