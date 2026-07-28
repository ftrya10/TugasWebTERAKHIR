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
                $weatherScore = (float) ($country->weather->weather_score ?? 25);
                $inflationScore = min(100, max(0, ((float) ($country->inflation ?? 0)) * 8));
                $exchangeScore = (float) (optional($country->exchangeRate)->exchange_score ?? 30);
                $newsScore = 40;

                $totalRisk = $country->riskScore->total_score ?? RiskService::calculateTotal($weatherScore, $inflationScore, $exchangeScore, $newsScore);
                $status = RiskService::getStatus($totalRisk);

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
