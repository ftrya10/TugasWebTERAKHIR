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

        // Country A default: Negara pertama (misal Germany)
        $countryA_id = $request->country_a ?? $countries->first()->id ?? null;
        
        // Country B default: Negara kedua (misal Australia)
        $countryB_id = $request->country_b ?? ($countries->skip(1)->first()->id ?? $countryA_id);

        $countryA = Country::with(['weather', 'exchangeRate', 'news', 'riskScore'])->find($countryA_id);
        $countryB = Country::with(['weather', 'exchangeRate', 'news', 'riskScore'])->find($countryB_id);

        // Kalkulasi ulang Risk Score terpusat untuk Negara A
        if ($countryA && $countryA->riskScore) {
            $countryA->riskScore->total_score = RiskService::calculateTotal(
                $countryA->riskScore->weather_score,
                $countryA->riskScore->inflation_score,
                $countryA->riskScore->exchange_score,
                $countryA->riskScore->news_score
            );
            $countryA->riskScore->status = RiskService::getStatus($countryA->riskScore->total_score);
        }

        // Kalkulasi ulang Risk Score terpusat untuk Negara B
        if ($countryB && $countryB->riskScore) {
            $countryB->riskScore->total_score = RiskService::calculateTotal(
                $countryB->riskScore->weather_score,
                $countryB->riskScore->inflation_score,
                $countryB->riskScore->exchange_score,
                $countryB->riskScore->news_score
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