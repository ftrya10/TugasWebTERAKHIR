<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\RiskService;
use Inertia\Inertia;

class RiskPredictionController extends Controller
{
    public function index()
    {
        $countries = Country::whereNotNull('name')
            ->where('name', '!=', '')
            ->where('name', '!=', '-')
            ->with(['riskScore', 'weather', 'exchangeRate', 'news'])
            ->orderBy('name')
            ->get()
            ->map(function ($country) {
                $rawWeather = (float) ($country->weather->weather_score ?? 3);
                $weatherScore = $rawWeather <= 10 ? $rawWeather * 10 : $rawWeather;

                $inflation = (float) ($country->inflation ?? 0);
                $inflationScore = min(100, max(0, $inflation * 12));

                $rawExchange = (float) (optional($country->exchangeRate)->exchange_score ?? 3);
                $exchangeScore = $rawExchange <= 10 ? $rawExchange * 10 : $rawExchange;

                $firstNews = $country->news->first();
                if ($firstNews) {
                    if ($firstNews->sentiment === 'Negative') {
                        $newsScore = 80;
                    } elseif ($firstNews->sentiment === 'Neutral') {
                        $newsScore = 45;
                    } else {
                        $newsScore = 15;
                    }
                } else {
                    $newsScore = 30;
                }

                $totalRisk = RiskService::calculateTotal($weatherScore, $inflationScore, $exchangeScore, $newsScore);
                $status = RiskService::getStatus($totalRisk);

                if ($country->riskScore) {
                    $country->riskScore->update([
                        'weather_score' => $weatherScore,
                        'inflation_score' => $inflationScore,
                        'exchange_score' => $exchangeScore,
                        'news_score' => $newsScore,
                        'total_score' => $totalRisk,
                        'status' => strtolower(explode(' ', $status)[0]),
                    ]);
                }

                return [
                    'id' => $country->id,
                    'name' => $country->name,
                    'code' => $country->code,
                    'flag' => $country->flag,
                    'region' => $country->region,
                    'total_risk' => $totalRisk,
                    'status' => $status,
                    'breakdown' => [
                        'weather' => round($weatherScore, 1),
                        'inflation' => round($inflationScore, 1),
                        'exchange' => round($exchangeScore, 1),
                        'news' => round($newsScore, 1),
                    ],
                ];
            });

        $summary = [
            'total_countries' => $countries->count(),
            'average_risk' => round($countries->avg('total_risk') ?? 0, 1),
            'high_risk' => $countries->where('status', 'High Risk')->count(),
            'medium_risk' => $countries->where('status', 'Medium Risk')->count(),
            'low_risk' => $countries->where('status', 'Low Risk')->count(),
        ];

        return Inertia::render('Risk/Index', [
            'countries' => $countries,
            'summary' => $summary,
        ]);
    }
}
