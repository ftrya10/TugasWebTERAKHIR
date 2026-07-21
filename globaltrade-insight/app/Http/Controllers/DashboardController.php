<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\News;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD DATA UTAMA
        |--------------------------------------------------------------------------
        */

        $countries = Country::with([
            'weather',
            'exchangeRate',
            'riskScore',
            'ports'
        ])->get();

        $recentNews = News::with('country')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL USERS
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK NEGARA
        |--------------------------------------------------------------------------
        */

        $totalCountries = $countries->count();

        /*
        | Country model kamu tidak memiliki is_active.
        | Untuk sementara semua negara dianggap aktif.
        */

        $activeCountries = $totalCountries;

        /*
        |--------------------------------------------------------------------------
        | INFLASI
        |--------------------------------------------------------------------------
        */

        $averageInflation = $countries
            ->filter(function ($country) {
                return $country->inflation !== null;
            })
            ->avg(function ($country) {
                return (float) $country->inflation;
            }) ?? 0;

        /*
        |--------------------------------------------------------------------------
        | GDP
        |--------------------------------------------------------------------------
        */

        $highestGDP = $countries
            ->filter(function ($country) {
                return $country->gdp !== null;
            })
            ->max('gdp') ?? 0;

        $highestGDPCountry = $countries
            ->firstWhere('gdp', $highestGDP);

        /*
        |--------------------------------------------------------------------------
        | POPULASI
        |--------------------------------------------------------------------------
        */

        $totalPopulation = $countries->sum(function ($country) {
            return (int) ($country->population ?? 0);
        });

        /*
        |--------------------------------------------------------------------------
        | DATA PELABUHAN
        |--------------------------------------------------------------------------
        */

        $totalPorts = Port::count();

        $activePorts = Port::whereRaw(
            'LOWER(status) = ?',
            ['active']
        )->count();

        $congestedPorts = Port::whereIn(
            'status',
            [
                'congested',
                'delayed',
                'critical'
            ]
        )->count();

        /*
        |--------------------------------------------------------------------------
        | RISIKO CUACA
        |--------------------------------------------------------------------------
        */

        $weatherScores = $countries
            ->filter(function ($country) {
                return $country->weather
                    && $country->weather->weather_score !== null;
            })
            ->map(function ($country) {
                return (float) $country->weather->weather_score;
            });

        $averageWeatherScore = $weatherScores->avg() ?? 0;

        $weatherRisk = $weatherScores
            ->filter(function ($score) {
                return $score >= 70;
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RISIKO NILAI TUKAR
        |--------------------------------------------------------------------------
        */

        $exchangeScores = $countries
            ->filter(function ($country) {
                return $country->exchangeRate
                    && $country->exchangeRate->exchange_score !== null;
            })
            ->map(function ($country) {
                return (float) $country->exchangeRate->exchange_score;
            });

        $averageExchangeScore = $exchangeScores->avg() ?? 0;

        /*
        |--------------------------------------------------------------------------
        | RISIKO INFLASI
        |--------------------------------------------------------------------------
        */

        $inflationScores = $countries
            ->filter(function ($country) {
                return $country->riskScore
                    && $country->riskScore->inflation_score !== null;
            })
            ->map(function ($country) {
                return (float) $country->riskScore->inflation_score;
            });

        $averageInflationScore = $inflationScores->avg() ?? 0;

        /*
        |--------------------------------------------------------------------------
        | RISIKO GEOPOLITIK
        |--------------------------------------------------------------------------
        |
        | news_score digunakan sebagai indikator risiko geopolitik.
        |
        */

        $geopoliticalScores = $countries
            ->filter(function ($country) {
                return $country->riskScore
                    && $country->riskScore->news_score !== null;
            })
            ->map(function ($country) {
                return (float) $country->riskScore->news_score;
            });

        $averageGeopoliticalRisk =
            $geopoliticalScores->avg() ?? 0;

        /*
        |--------------------------------------------------------------------------
        | RISIKO PELABUHAN
        |--------------------------------------------------------------------------
        */

        $portCongestionScore = 0;

        if ($totalPorts > 0) {
            $portCongestionScore =
                ($congestedPorts / $totalPorts) * 100;
        }

        /*
        |--------------------------------------------------------------------------
        | RISIKO NEGARA
        |--------------------------------------------------------------------------
        */

        $riskScores = $countries
            ->filter(function ($country) {
                return $country->riskScore
                    && $country->riskScore->total_score !== null;
            })
            ->map(function ($country) {
                return (float) $country->riskScore->total_score;
            });

        $highRisk = $riskScores
            ->filter(function ($score) {
                return $score >= 70;
            })
            ->count();

        $mediumRisk = $riskScores
            ->filter(function ($score) {
                return $score >= 30 && $score < 70;
            })
            ->count();

        $lowRisk = $riskScores
            ->filter(function ($score) {
                return $score < 30;
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA RISIKO NEGARA
        |--------------------------------------------------------------------------
        */

        $averageRiskScore =
            $riskScores->avg() ?? 0;

        /*
        |--------------------------------------------------------------------------
        | SUPPLY CHAIN RISK SCORE
        |--------------------------------------------------------------------------
        |
        | Cuaca       = 20%
        | Nilai Tukar = 20%
        | Inflasi     = 20%
        | Geopolitik  = 25%
        | Pelabuhan   = 15%
        |
        */

        $supplyChainRiskScore =
            ($averageWeatherScore * 0.20) +
            ($averageExchangeScore * 0.20) +
            ($averageInflationScore * 0.20) +
            ($averageGeopoliticalRisk * 0.25) +
            ($portCongestionScore * 0.15);

        /*
        |--------------------------------------------------------------------------
        | STATUS RISIKO RANTAI PASOK
        |--------------------------------------------------------------------------
        */

        if ($supplyChainRiskScore >= 70) {
            $overallRisk = 'Critical';
        } elseif ($supplyChainRiskScore >= 50) {
            $overallRisk = 'High';
        } elseif ($supplyChainRiskScore >= 30) {
            $overallRisk = 'Medium';
        } else {
            $overallRisk = 'Low';
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTIK DASHBOARD
        |--------------------------------------------------------------------------
        */

        $stats = (object) [

            // Admin
            'total_users' => $totalUsers,

            // Negara
            'total_countries' => $totalCountries,
            'active_countries' => $activeCountries,

            // Ekonomi
            'average_inflation' =>
                round($averageInflation, 2),

            'average_inflation_score' =>
                round($averageInflationScore, 2),

            'highest_gdp' => $highestGDP,

            'highest_gdp_country' =>
                $highestGDPCountry->name ?? '-',

            'total_population' =>
                $totalPopulation,

            // Pelabuhan
            'total_ports' =>
                $totalPorts,

            'active_ports' =>
                $activePorts,

            'congested_ports' =>
                $congestedPorts,

            'port_congestion_score' =>
                round($portCongestionScore, 2),

            // Berita
            'total_articles' =>
                News::count(),

            // Risiko Negara
            'average_risk_score' =>
                round($averageRiskScore, 2),

            'high_risk' =>
                $highRisk,

            'medium_risk' =>
                $mediumRisk,

            'low_risk' =>
                $lowRisk,

            // Cuaca
            'weather_risk' =>
                $weatherRisk,

            'average_weather_score' =>
                round($averageWeatherScore, 2),

            // Nilai Tukar
            'average_exchange_score' =>
                round($averageExchangeScore, 2),

            // Geopolitik
            'average_geopolitical_risk' =>
                round($averageGeopoliticalRisk, 2),

            // Risiko Rantai Pasok
            'supply_chain_risk_score' =>
                round($supplyChainRiskScore, 2),

            'overall_risk' =>
                $overallRisk,
        ];

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'countries',
                'stats',
                'recentNews',
                'highRisk',
                'mediumRisk',
                'lowRisk'
            )
        );
    }
}