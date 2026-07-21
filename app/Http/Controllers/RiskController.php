<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;
use Illuminate\Http\JsonResponse;

class RiskController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RISK INTELLIGENCE CENTER
    |--------------------------------------------------------------------------
    |
    | Risk Formula:
    |
    | Weather         = 20%
    | Inflation       = 20%
    | Exchange Rate   = 20%
    | News Sentiment  = 25%
    | Port Congestion = 15%
    |
    | Total = 100%
    |
    */

    /**
     * Risk Intelligence Dashboard
     */
    public function index()
    {
        $countries = $this->getCountries();

        /*
        |--------------------------------------------------------------------------
        | CALCULATE ALL RISK SCORES
        |--------------------------------------------------------------------------
        */

        foreach ($countries as $country) {
            $this->calculateRiskScore($country);
        }

        /*
        |--------------------------------------------------------------------------
        | RELOAD LATEST RISK DATA
        |--------------------------------------------------------------------------
        */

        $countries = $this->getCountries();

        /*
        |--------------------------------------------------------------------------
        | RISK SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalCountries = $countries->count();

        $lowRisk = $countries
            ->filter(fn ($country) =>
                $this->getRiskScore($country) < 30
            )
            ->count();

        $mediumRisk = $countries
            ->filter(fn ($country) =>
                $this->getRiskScore($country) >= 30 &&
                $this->getRiskScore($country) < 50
            )
            ->count();

        $highRisk = $countries
            ->filter(fn ($country) =>
                $this->getRiskScore($country) >= 50 &&
                $this->getRiskScore($country) < 70
            )
            ->count();

        $criticalRisk = $countries
            ->filter(fn ($country) =>
                $this->getRiskScore($country) >= 70
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | AVERAGE RISK
        |--------------------------------------------------------------------------
        */

        $averageRisk = round(
            $countries->avg(
                fn ($country) => $this->getRiskScore($country)
            ) ?? 0,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | HIGHEST RISK COUNTRY
        |--------------------------------------------------------------------------
        */

        $highestRiskCountry = $countries
            ->sortByDesc(
                fn ($country) => $this->getRiskScore($country)
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | TOP 10 RISK COUNTRIES
        |--------------------------------------------------------------------------
        */

        $topCountries = $countries
            ->sortByDesc(
                fn ($country) => $this->getRiskScore($country)
            )
            ->take(10)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | GLOBAL INSIGHT
        |--------------------------------------------------------------------------
        */

        $globalInsight = $this->generateGlobalInsight(
            $averageRisk,
            $highestRiskCountry,
            $criticalRisk,
            $highRisk
        );

        return view(
            'risk.index',
            compact(
                'countries',
                'totalCountries',
                'lowRisk',
                'mediumRisk',
                'highRisk',
                'criticalRisk',
                'averageRisk',
                'highestRiskCountry',
                'topCountries',
                'globalInsight'
            )
        );
    }


    /**
     * Risk Detail Country
     */
    public function show($countryId)
    {
        $country = Country::with([
            'riskScore',
            'weather',
            'exchangeRate',
            'news',
            'ports',
        ])->findOrFail($countryId);

        /*
        |--------------------------------------------------------------------------
        | RECALCULATE RISK
        |--------------------------------------------------------------------------
        */

        $this->calculateRiskScore($country);

        /*
        |--------------------------------------------------------------------------
        | RELOAD LATEST DATA
        |--------------------------------------------------------------------------
        */

        $country->load([
            'riskScore',
            'weather',
            'exchangeRate',
            'news',
            'ports',
        ]);

        $riskScore = $country->riskScore;

        /*
        |--------------------------------------------------------------------------
        | RISK BREAKDOWN
        |--------------------------------------------------------------------------
        */

        $riskBreakdown = [
            'weather' => (float) ($riskScore->weather_score ?? 0),
            'inflation' => (float) ($riskScore->inflation_score ?? 0),
            'exchange' => (float) ($riskScore->exchange_score ?? 0),
            'news' => (float) ($riskScore->news_score ?? 0),
            'ports' => (float) ($riskScore->port_score ?? 0),
        ];

        /*
        |--------------------------------------------------------------------------
        | COUNTRY INSIGHTS
        |--------------------------------------------------------------------------
        */

        $insights = $this->generateCountryInsights(
            $country,
            $riskBreakdown
        );

        return view(
            'risk.show',
            compact(
                'country',
                'riskBreakdown',
                'insights'
            )
        );
    }


    /**
     * Risk Analytics API
     *
     * Digunakan oleh:
     * - Chart.js
     * - AJAX
     * - Dashboard Analytics
     */
    public function api(): JsonResponse
    {
        $countries = $this->getCountries();

        /*
        |--------------------------------------------------------------------------
        | MAKE SURE RISK DATA EXISTS
        |--------------------------------------------------------------------------
        */

        foreach ($countries as $country) {
            $this->calculateRiskScore($country);
        }

        /*
        |--------------------------------------------------------------------------
        | RELOAD RISK DATA
        |--------------------------------------------------------------------------
        */

        $countries = $this->getCountries();

        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA
        |--------------------------------------------------------------------------
        */

        $data = $countries->map(function ($country) {

            $score = $this->getRiskScore($country);

            return [
                'id' => $country->id,
                'name' => $country->name,
                'code' => $country->code,
                'score' => $score,

                /*
                | Status menggunakan lowercase agar sesuai ENUM database.
                */
                'status' => $this->getRiskStatus($score),

                'color' => $this->getRiskColor($score),

                'breakdown' => [
                    'weather' => (float) (
                        optional($country->riskScore)->weather_score ?? 0
                    ),

                    'inflation' => (float) (
                        optional($country->riskScore)->inflation_score ?? 0
                    ),

                    'exchange' => (float) (
                        optional($country->riskScore)->exchange_score ?? 0
                    ),

                    'news' => (float) (
                        optional($country->riskScore)->news_score ?? 0
                    ),

                    'ports' => (float) (
                        optional($country->riskScore)->port_score ?? 0
                    ),
                ],
            ];
        });

        return response()->json([
            'status' => 'success',

            'data' => $data,

            'summary' => [
                'total_countries' => $countries->count(),

                'average_risk' => round(
                    $countries->avg(
                        fn ($country) => $this->getRiskScore($country)
                    ) ?? 0,
                    2
                ),

                'low' => $countries
                    ->filter(
                        fn ($country) =>
                            $this->getRiskScore($country) < 30
                    )
                    ->count(),

                'medium' => $countries
                    ->filter(
                        fn ($country) =>
                            $this->getRiskScore($country) >= 30 &&
                            $this->getRiskScore($country) < 50
                    )
                    ->count(),

                'high' => $countries
                    ->filter(
                        fn ($country) =>
                            $this->getRiskScore($country) >= 50 &&
                            $this->getRiskScore($country) < 70
                    )
                    ->count(),

                'critical' => $countries
                    ->filter(
                        fn ($country) =>
                            $this->getRiskScore($country) >= 70
                    )
                    ->count(),
            ],
        ]);
    }


    /**
     * Get Countries
     */
    private function getCountries()
    {
        return Country::with([
            'riskScore',
            'weather',
            'exchangeRate',
            'news',
            'ports',
        ])
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->get();
    }


    /**
     * Calculate Risk Score
     */
    private function calculateRiskScore(
        Country $country
    ): RiskScore {

        /*
        |--------------------------------------------------------------------------
        | WEATHER SCORE
        |--------------------------------------------------------------------------
        */

        $weatherScore = $this->normalizeScore(
            optional($country->weather)->weather_score
        );

        /*
        |--------------------------------------------------------------------------
        | EXCHANGE RATE SCORE
        |--------------------------------------------------------------------------
        */

        $exchangeScore = $this->normalizeScore(
            optional($country->exchangeRate)->exchange_score
        );

        /*
        |--------------------------------------------------------------------------
        | INFLATION SCORE
        |--------------------------------------------------------------------------
        */

        $inflationScore = $this->calculateInflationScore(
            $country->inflation
        );

        /*
        |--------------------------------------------------------------------------
        | NEWS SCORE
        |--------------------------------------------------------------------------
        */

        $newsScore = $this->calculateNewsScore(
            $country
        );

        /*
        |--------------------------------------------------------------------------
        | PORT CONGESTION SCORE
        |--------------------------------------------------------------------------
        */

        $portScore = $this->calculatePortScore(
            $country
        );

        /*
        |--------------------------------------------------------------------------
        | FINAL RISK SCORE
        |--------------------------------------------------------------------------
        |
        | Weather         = 20%
        | Inflation       = 20%
        | Exchange Rate   = 20%
        | News Sentiment  = 25%
        | Port Congestion = 15%
        |
        */

        $totalScore =

            ($weatherScore * 0.20) +

            ($inflationScore * 0.20) +

            ($exchangeScore * 0.20) +

            ($newsScore * 0.25) +

            ($portScore * 0.15);

        $totalScore = round(
            min(
                100,
                max(
                    0,
                    $totalScore
                )
            ),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Database menyimpan:
        |
        | low
        | medium
        | high
        | critical
        |
        */

        $status = $this->getRiskStatus(
            $totalScore
        );

        /*
        |--------------------------------------------------------------------------
        | SAVE RISK SCORE
        |--------------------------------------------------------------------------
        */

        return RiskScore::updateOrCreate(
            [
                'country_id' => $country->id,
            ],
            [
                'weather_score' => $weatherScore,
                'inflation_score' => $inflationScore,
                'exchange_score' => $exchangeScore,
                'news_score' => $newsScore,
                'port_score' => $portScore,
                'total_score' => $totalScore,
                'status' => $status,
            ]
        );
    }


    /**
     * Calculate News Risk
     */
    private function calculateNewsScore(
        Country $country
    ): float {

        $news = $country->news;

        if (
            !$news ||
            $news->isEmpty()
        ) {
            return 0;
        }

        $scores = $news
            ->pluck('news_score')
            ->filter(
                fn ($score) => is_numeric($score)
            );

        if ($scores->isEmpty()) {
            return 0;
        }

        return $this->normalizeScore(
            $scores->avg()
        );
    }


    /**
     * Calculate Port Risk
     */
    private function calculatePortScore(
        Country $country
    ): float {

        $ports = $country->ports;

        if (
            !$ports ||
            $ports->isEmpty()
        ) {
            return 0;
        }

        $totalPorts = $ports->count();

        $congestedPorts = $ports
            ->filter(function ($port) {

                $status = strtolower(
                    trim(
                        $port->status ?? ''
                    )
                );

                return in_array(
                    $status,
                    [
                        'congested',
                        'delayed',
                        'critical',
                    ],
                    true
                );
            })
            ->count();

        if ($totalPorts <= 0) {
            return 0;
        }

        return round(
            (
                $congestedPorts /
                $totalPorts
            ) * 100,
            2
        );
    }


    /**
     * Calculate Inflation Risk
     */
    private function calculateInflationScore(
        $inflation
    ): float {

        $inflation = (float) (
            $inflation ?? 0
        );

        if ($inflation >= 20) {
            return 100;
        }

        if ($inflation >= 10) {
            return 80;
        }

        if ($inflation >= 5) {
            return 60;
        }

        if ($inflation >= 3) {
            return 40;
        }

        if ($inflation > 0) {
            return 20;
        }

        return 0;
    }


    /**
     * Normalize Risk Score
     */
    private function normalizeScore(
        $score
    ): float {

        $score = (float) (
            $score ?? 0
        );

        return round(
            min(
                100,
                max(
                    0,
                    $score
                )
            ),
            2
        );
    }


    /**
     * Get Risk Score
     */
    private function getRiskScore(
        Country $country
    ): float {

        return (float) (
            optional(
                $country->riskScore
            )->total_score ?? 0
        );
    }


    /**
     * Get Risk Status
     *
     * IMPORTANT:
     * Return value harus lowercase karena
     * database menggunakan enum:
     *
     * low
     * medium
     * high
     * critical
     */
    private function getRiskStatus(
        float $score
    ): string {

        if ($score >= 70) {
            return 'critical';
        }

        if ($score >= 50) {
            return 'high';
        }

        if ($score >= 30) {
            return 'medium';
        }

        return 'low Risk';
    }


    /**
     * Get Risk Color
     */
    private function getRiskColor(
        float $score
    ): string {

        if ($score >= 70) {
            return 'critical';
        }

        if ($score >= 50) {
            return 'high';
        }

        if ($score >= 30) {
            return 'medium';
        }

        return 'low';
    }


    /**
     * Generate Global Insight
     */
    private function generateGlobalInsight(
        float $averageRisk,
        $highestRiskCountry,
        int $criticalRisk,
        int $highRisk
    ): string {

        if ($criticalRisk > 0) {

            return "Critical supply chain exposure detected. "
                . $criticalRisk
                . " country/countries require immediate monitoring.";
        }

        if ($highRisk > 0) {

            return "Elevated supply chain risk detected across "
                . $highRisk
                . " high-risk country/countries. "
                . "Review weather, currency, inflation, and port conditions.";
        }

        if ($averageRisk >= 30) {

            return "Global supply chain risk is currently moderate. "
                . "Continuous monitoring is recommended.";
        }

        if ($highestRiskCountry) {

            return "Global risk remains relatively low. "
                . "Highest exposure is currently associated with "
                . $highestRiskCountry->name
                . ".";
        }

        return "No significant supply chain risk data is currently available.";
    }


    /**
     * Generate Country Insights
     */
    private function generateCountryInsights(
        Country $country,
        array $riskBreakdown
    ): array {

        $insights = [];

        $maxFactor = collect(
            $riskBreakdown
        )
            ->sortDesc()
            ->keys()
            ->first();

        $factorNames = [
            'weather' =>
                'Weather conditions',

            'inflation' =>
                'Inflation pressure',

            'exchange' =>
                'Currency volatility',

            'news' =>
                'News and geopolitical sentiment',

            'ports' =>
                'Port congestion',
        ];

        if ($maxFactor) {

            $insights[] =
                $factorNames[$maxFactor]
                . ' is currently the largest contributor to supply chain risk.';
        }

        if (
            $riskBreakdown['ports'] >= 50
        ) {

            $insights[] =
                'Port congestion is elevated. '
                . 'Logistics and shipping operations should be monitored closely.';
        }

        if (
            $riskBreakdown['weather'] >= 50
        ) {

            $insights[] =
                'Severe weather conditions may disrupt logistics and transportation.';
        }

        if (
            $riskBreakdown['inflation'] >= 60
        ) {

            $insights[] =
                'High inflation may increase operational and supply chain costs.';
        }

        if (
            $riskBreakdown['exchange'] >= 60
        ) {

            $insights[] =
                'Currency volatility may increase international trade costs.';
        }

        if (
            $riskBreakdown['news'] >= 60
        ) {

            $insights[] =
                'Negative news sentiment may indicate geopolitical or trade-related disruption risks.';
        }

        if (empty($insights)) {

            $insights[] =
                'No major supply chain risk driver has been detected.';
        }

        return $insights;
    }
}
