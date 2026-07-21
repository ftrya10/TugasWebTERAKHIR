<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\RiskService;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar semua negara yang valid untuk dropdown
        $countries = Country::whereNotNull('name')
                            ->where('name', '!=', '')
                            ->where('name', '!=', '-')
                            ->get();

        if ($countries->isEmpty()) {
            return \Inertia\Inertia::render('Compare/Index', [
                'countries' => [],
                'countryA' => null,
                'countryB' => null
            ]);
        }

        // Country A default: Negara pertama (misal Germany)
        $countryA_id = $request->country_a ?? $countries->first()?->id;
        
        // Country B default: Negara kedua (misal Australia)
        $countryB_id = $request->country_b ?? ($countries->skip(1)->first()?->id ?? $countryA_id);

        $countryA = Country::with(['weather', 'exchangeRate', 'news', 'riskScore'])->find($countryA_id);
        $countryB = Country::with(['weather', 'exchangeRate', 'news', 'riskScore'])->find($countryB_id);

        // Kalkulasi ulang Risk Score terpusat untuk Negara A secara aman
        if ($countryA && $countryA->riskScore) {
            $weatherScore = (float) ($countryA->riskScore->weather_score ?? 0);
            $inflationScore = (float) ($countryA->riskScore->inflation_score ?? 0);
            $exchangeScore = (float) ($countryA->riskScore->exchange_score ?? 0);
            $newsScore = (float) ($countryA->riskScore->news_score ?? 0);

            $countryA->riskScore->total_score = RiskService::calculateTotal(
                $weatherScore,
                $inflationScore,
                $exchangeScore,
                $newsScore
            );
            $countryA->riskScore->status = RiskService::getStatus($countryA->riskScore->total_score);
        }

        // Kalkulasi ulang Risk Score terpusat untuk Negara B secara aman
        if ($countryB && $countryB->riskScore) {
            $weatherScore = (float) ($countryB->riskScore->weather_score ?? 0);
            $inflationScore = (float) ($countryB->riskScore->inflation_score ?? 0);
            $exchangeScore = (float) ($countryB->riskScore->exchange_score ?? 0);
            $newsScore = (float) ($countryB->riskScore->news_score ?? 0);

            $countryB->riskScore->total_score = RiskService::calculateTotal(
                $weatherScore,
                $inflationScore,
                $exchangeScore,
                $newsScore
            );
            $countryB->riskScore->status = RiskService::getStatus($countryB->riskScore->total_score);
        }

        return \Inertia\Inertia::render('Compare/Index', [
            'countries' => $countries,
            'countryA' => $countryA,
            'countryB' => $countryB
        ]);
    }
}