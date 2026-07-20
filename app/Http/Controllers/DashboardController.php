<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Services\RiskService;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil daftar negara yang valid (hanya yang memiliki koordinat untuk peta)
        $countries = Country::whereNotNull('name')
                            ->where('name', '!=', '')
                            ->where('name', '!=', '-')
                            ->whereNotNull('latitude')  // Penting agar peta tidak error
                            ->whereNotNull('longitude') // Penting agar peta tidak error
                            ->orderBy('name', 'asc')
                            ->with(['weather', 'exchangeRate', 'news', 'riskScore'])
                            ->get();

        // Cek jika tidak ada negara sama sekali di database
        if ($countries->isEmpty()) {
            return view('dashboard', ['countries' => null, 'country' => null]);
        }

        // 2. Ambil negara yang dipilih (default: negara pertama dari koleksi)
        $selectedCountryId = $request->get('country');
        $country = $countries->firstWhere('id', $selectedCountryId) ?? $countries->first();

        // 3. Kalkulasi ulang skor risiko jika relasi riskScore ada
        if ($country && $country->riskScore) {
            $country->riskScore->total_score = RiskService::calculateTotal(
                $country->riskScore->weather_score ?? 0,
                $country->riskScore->inflation_score ?? 0,
                $country->riskScore->exchange_score ?? 0,
                $country->riskScore->news_score ?? 0
            );
            
            $country->riskScore->status = RiskService::getStatus($country->riskScore->total_score);
        }

        return view('dashboard', compact('countries', 'country'));
    }
}