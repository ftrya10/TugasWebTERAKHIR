<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    /**
     * ============================================================
     * COUNTRY INTELLIGENCE CENTER
     * ============================================================
     */
    public function index()
    {
        $countries = Country::with([
            'weather',
            'exchangeRate',
            'riskScore',
        ])
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->where('name', '!=', '-')
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'pages.countries',
            compact('countries')
        );
    }


    /**
     * ============================================================
     * COUNTRY INTELLIGENCE DETAIL
     * ============================================================
     */
    public function show(Country $country)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD LOCAL DATABASE RELATIONS
        |--------------------------------------------------------------------------
        */

        $country->load([
            'weather',
            'exchangeRate',
            'riskScore',
            'news',
            'ports',
        ]);


        /*
        |--------------------------------------------------------------------------
        | REST COUNTRIES DATA
        |--------------------------------------------------------------------------
        */

        $countryDetail = $this->fetchCountryFromRestCountries(
            $country->name
        );


        /*
        |--------------------------------------------------------------------------
        | WORLD BANK ECONOMIC DATA
        |--------------------------------------------------------------------------
        */

        $economicData = $this->fetchEconomicData(
            $country->code
        );


        /*
        |--------------------------------------------------------------------------
        | MERGE DATABASE + API DATA
        |--------------------------------------------------------------------------
        */

        $countryData = [

            'name' =>
                $countryDetail['name']
                ?? $country->name,

            'official_name' =>
                $countryDetail['official_name']
                ?? $country->name,

            'region' =>
                $countryDetail['region']
                ?? $country->region
                ?? '-',

            'subregion' =>
                $countryDetail['subregion']
                ?? '-',

            'capital' =>
                $countryDetail['capital']
                ?? '-',

            'languages' =>
                $countryDetail['languages']
                ?? '-',

            'currencies' =>
                $countryDetail['currencies']
                ?? [],

            'population' =>
                $countryDetail['population']
                ?? $country->population
                ?? 0,

            'latlng' =>
                $countryDetail['latlng']
                ?? [
                    $country->latitude ?? 0,
                    $country->longitude ?? 0,
                ],

            'flag' =>
                $countryDetail['flag']
                ?? $country->flag
                ?? '',

            'gdp' =>
                $economicData['gdp']
                ?? $country->gdp
                ?? null,

            'inflation' =>
                $economicData['inflation']
                ?? $country->inflation
                ?? null,

            'unemployment' =>
                $economicData['unemployment']
                ?? null,

            'economic_year' =>
                $economicData['year']
                ?? null,
        ];


        /*
        |--------------------------------------------------------------------------
        | RISK DATA
        |--------------------------------------------------------------------------
        */

        $riskScore = $country->riskScore;


        /*
        |--------------------------------------------------------------------------
        | RISK STATUS
        |--------------------------------------------------------------------------
        */

        $riskStatus = 'Low';

        if ($riskScore) {

            $score = (float) (
                $riskScore->total_score ?? 0
            );

            if ($score >= 70) {
                $riskStatus = 'Critical';
            } elseif ($score >= 50) {
                $riskStatus = 'High';
            } elseif ($score >= 30) {
                $riskStatus = 'Medium';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | WEATHER DATA
        |--------------------------------------------------------------------------
        */

        $weather = $country->weather;


        /*
        |--------------------------------------------------------------------------
        | EXCHANGE DATA
        |--------------------------------------------------------------------------
        */

        $exchangeRate = $country->exchangeRate;


        /*
        |--------------------------------------------------------------------------
        | NEWS
        |--------------------------------------------------------------------------
        */

        $news = $country->news;


        /*
        |--------------------------------------------------------------------------
        | PORTS
        |--------------------------------------------------------------------------
        */

        $ports = $country->ports;


        /*
        |--------------------------------------------------------------------------
        | RETURN COUNTRY INTELLIGENCE PROFILE
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.country-detail',
            compact(
                'country',
                'countryData',
                'riskScore',
                'riskStatus',
                'weather',
                'exchangeRate',
                'news',
                'ports'
            )
        );
    }


    /**
     * ============================================================
     * REST COUNTRIES API
     * ============================================================
     */
    private function fetchCountryFromRestCountries(
        string $name
    ): ?array {

        try {

            $response = Http::retry(
                2,
                500
            )
                ->timeout(10)
                ->get(
                    'https://restcountries.com/v3.1/name/'
                    . urlencode($name)
                );


            if (
                !$response->successful()
            ) {
                return null;
            }


            $countryData =
                $response->json()[0]
                ?? null;


            if (
                !$countryData
            ) {
                return null;
            }


            return [

                'name' =>
                    $countryData['name']['common']
                    ?? $name,

                'official_name' =>
                    $countryData['name']['official']
                    ?? '-',

                'region' =>
                    $countryData['region']
                    ?? '-',

                'subregion' =>
                    $countryData['subregion']
                    ?? '-',

                'capital' =>
                    $countryData['capital'][0]
                    ?? '-',

                'languages' =>
                    isset(
                        $countryData['languages']
                    )
                        ? implode(
                            ', ',
                            $countryData['languages']
                        )
                        : '-',

                'currencies' =>
                    $countryData['currencies']
                    ?? [],

                'population' =>
                    $countryData['population']
                    ?? 0,

                'latlng' =>
                    $countryData['latlng']
                    ?? [0, 0],

                'flag' =>
                    $countryData['flags']['png']
                    ?? '',

            ];

        } catch (\Throwable $e) {

            Log::error(
                'REST Countries Error: '
                . $e->getMessage()
            );

            return null;
        }
    }


    /**
     * ============================================================
     * WORLD BANK ECONOMIC DATA
     * ============================================================
     */
    private function fetchEconomicData(
        ?string $countryCode
    ): array {

        if (
            empty($countryCode)
        ) {
            return [];
        }


        try {

            $year =
                date('Y') - 1;


            $indicators = [

                'gdp' =>
                    'NY.GDP.MKTP.CD',

                'inflation' =>
                    'FP.CPI.TOTL.ZG',

                'unemployment' =>
                    'SL.UEM.TOTL.ZS',

            ];


            $result = [

                'year' =>
                    $year,

                'gdp' =>
                    null,

                'inflation' =>
                    null,

                'unemployment' =>
                    null,

            ];


            foreach (
                $indicators
                as $key => $indicator
            ) {

                $response =
                    Http::retry(
                        2,
                        500
                    )
                        ->timeout(10)
                        ->get(
                            "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}",
                            [
                                'format' =>
                                    'json',

                                'per_page' =>
                                    1,

                                'date' =>
                                    $year,
                            ]
                        );


                if (
                    !$response->successful()
                ) {
                    continue;
                }


                $json =
                    $response->json();


                $result[$key] =
                    $json[1][0]['value']
                    ?? null;
            }


            return $result;

        } catch (\Throwable $e) {

            Log::error(
                'World Bank Error: '
                . $e->getMessage()
            );

            return [];
        }
    }


    /**
     * ============================================================
     * REST COUNTRY DETAIL API
     * ============================================================
     */
    public function getCountryDetail(
        $name
    ): JsonResponse {

        $data =
            $this->fetchCountryFromRestCountries(
                $name
            );


        if (
            !$data
        ) {

            return response()->json([
                'status' =>
                    'error',

                'message' =>
                    'Negara tidak ditemukan',
            ], 404);
        }


        return response()->json([

            'status' =>
                'success',

            'data' =>
                $data,

        ]);
    }


    /**
     * ============================================================
     * ECONOMIC DATA API
     * ============================================================
     */
    public function getEconomicData(
        $countryCode
    ): JsonResponse {

        $data =
            $this->fetchEconomicData(
                $countryCode
            );


        if (
            empty($data)
        ) {

            return response()->json([
                'status' =>
                    'error',

                'message' =>
                    'Data ekonomi tidak tersedia',
            ], 404);
        }


        return response()->json([

            'status' =>
                'success',

            'country' =>
                strtoupper(
                    $countryCode
                ),

            'year' =>
                $data['year']
                ?? null,

            'data' =>
                $data,

        ]);
    }
}
