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
     *
     * Menampilkan daftar negara yang tersedia.
     */
    public function index()
    {
        $countries = Country::with([
            'weather',
            'exchangeRate',
            'riskScore',
        ])
            ->whereNotNull('name')
            ->where('name', '!=', '-')
            ->where('name', '!=', '')
            ->orderBy('name', 'asc')
            ->get();

        return \Inertia\Inertia::render('Countries/Index', [
            'countries' => $countries
        ]);
    }

    public function show(Country $country)
    {
        $country->load([
            'weather',
            'exchangeRate',
            'riskScore',
            'news',
            'ports',
        ]);

        return \Inertia\Inertia::render('Countries/Show', [
            'country' => $country
        ]);
    }


    /**
     * ============================================================
     * REST COUNTRIES API
     * ============================================================
     *
     * Mengambil informasi lengkap negara.
     */
    public function getCountryDetail(
        $name
    ): JsonResponse {

        try {

            $response = Http::retry(
                3,
                500
            )
                ->timeout(15)
                ->acceptJson()
                ->get(
                    'https://restcountries.com/v3.1/name/'
                    . urlencode($name),
                    [
                        'fullText' => 'false',
                    ]
                );

            if (!$response->successful()) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Negara tidak ditemukan.',
                ], 404);
            }


            $countries = $response->json();

            $countryData = $countries[0] ?? null;


            if (!$countryData) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Data negara kosong.',
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | COUNTRY NAME
            |--------------------------------------------------------------------------
            */

            $commonName =
                $countryData['name']['common']
                ?? $name;

            $officialName =
                $countryData['name']['official']
                ?? '-';


            /*
            |--------------------------------------------------------------------------
            | CURRENCIES
            |--------------------------------------------------------------------------
            */

            $currencies = [];

            if (
                isset($countryData['currencies'])
                && is_array($countryData['currencies'])
            ) {

                foreach (
                    $countryData['currencies']
                    as $code => $currency
                ) {

                    $currencies[] = [

                        'code' =>
                            $code,

                        'name' =>
                            $currency['name']
                            ?? '-',

                        'symbol' =>
                            $currency['symbol']
                            ?? '-',

                    ];
                }
            }


            /*
            |--------------------------------------------------------------------------
            | LANGUAGES
            |--------------------------------------------------------------------------
            */

            $languages = [];

            if (
                isset($countryData['languages'])
                && is_array($countryData['languages'])
            ) {

                $languages =
                    array_values(
                        $countryData['languages']
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | CAPITAL
            |--------------------------------------------------------------------------
            */

            $capital =
                $countryData['capital'][0]
                ?? '-';


            /*
            |--------------------------------------------------------------------------
            | TIMEZONES
            |--------------------------------------------------------------------------
            */

            $timezones =
                $countryData['timezones']
                ?? [];


            /*
            |--------------------------------------------------------------------------
            | BORDERS
            |--------------------------------------------------------------------------
            */

            $borders =
                $countryData['borders']
                ?? [];


            /*
            |--------------------------------------------------------------------------
            | FLAG
            |--------------------------------------------------------------------------
            */

            $flag = [

                'png' =>
                    $countryData['flags']['png']
                    ?? '',

                'svg' =>
                    $countryData['flags']['svg']
                    ?? '',

                'alt' =>
                    $countryData['flags']['alt']
                    ?? $commonName,

            ];


            /*
            |--------------------------------------------------------------------------
            | LOCATION
            |--------------------------------------------------------------------------
            */

            $latlng =
                $countryData['latlng']
                ?? [0, 0];


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    'success',

                'data' => [

                    /*
                    |--------------------------------------------------------------------------
                    | BASIC PROFILE
                    |--------------------------------------------------------------------------
                    */

                    'name' =>
                        $commonName,

                    'official_name' =>
                        $officialName,

                    'cca2' =>
                        $countryData['cca2']
                        ?? null,

                    'cca3' =>
                        $countryData['cca3']
                        ?? null,

                    'region' =>
                        $countryData['region']
                        ?? '-',

                    'subregion' =>
                        $countryData['subregion']
                        ?? '-',

                    'capital' =>
                        $capital,


                    /*
                    |--------------------------------------------------------------------------
                    | DEMOGRAPHICS
                    |--------------------------------------------------------------------------
                    */

                    'population' =>
                        $countryData['population']
                        ?? 0,

                    'area' =>
                        $countryData['area']
                        ?? 0,

                    'independent' =>
                        $countryData['independent']
                        ?? null,

                    'un_member' =>
                        $countryData['unMember']
                        ?? null,


                    /*
                    |--------------------------------------------------------------------------
                    | CULTURE
                    |--------------------------------------------------------------------------
                    */

                    'languages' =>
                        $languages,

                    'languages_text' =>
                        !empty($languages)
                            ? implode(
                                ', ',
                                $languages
                            )
                            : '-',


                    /*
                    |--------------------------------------------------------------------------
                    | ECONOMY
                    |--------------------------------------------------------------------------
                    */

                    'currencies' =>
                        $currencies,

                    'currency_codes' =>
                        array_column(
                            $currencies,
                            'code'
                        ),


                    /*
                    |--------------------------------------------------------------------------
                    | GEOGRAPHY
                    |--------------------------------------------------------------------------
                    */

                    'latlng' =>
                        $latlng,

                    'latitude' =>
                        $latlng[0]
                        ?? 0,

                    'longitude' =>
                        $latlng[1]
                        ?? 0,

                    'borders' =>
                        $borders,


                    /*
                    |--------------------------------------------------------------------------
                    | TIME
                    |--------------------------------------------------------------------------
                    */

                    'timezones' =>
                        $timezones,


                    /*
                    |--------------------------------------------------------------------------
                    | FLAG
                    |--------------------------------------------------------------------------
                    */

                    'flag' =>
                        $flag,


                    /*
                    |--------------------------------------------------------------------------
                    | MAP
                    |--------------------------------------------------------------------------
                    */

                    'maps' => [

                        'google' =>
                            $countryData['maps']['googleMaps']
                            ?? null,

                        'openstreetmap' =>
                            $countryData['maps']['openStreetMaps']
                            ?? null,

                    ],

                ],

            ]);

        } catch (\Throwable $e) {

            Log::error(
                'REST Countries API Error',
                [
                    'country' =>
                        $name,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'REST Countries API gagal diakses.',

            ], 500);
        }
    }


    /**
     * ============================================================
     * ECONOMIC INTELLIGENCE
     * ============================================================
     *
     * World Bank:
     *
     * GDP
     * Inflation
     * Unemployment
     */
    public function getEconomicData(
        $countryCode
    ): JsonResponse {

        try {

            $countryCode =
                strtoupper(
                    trim($countryCode)
                );


            /*
            |--------------------------------------------------------------------------
            | TAHUN TERBARU
            |--------------------------------------------------------------------------
            */

            $year =
                date('Y') - 1;


            /*
            |--------------------------------------------------------------------------
            | WORLD BANK INDICATORS
            |--------------------------------------------------------------------------
            */

            $indicators = [

                'gdp' =>
                    'NY.GDP.MKTP.CD',

                'gdp_per_capita' =>
                    'NY.GDP.PCAP.CD',

                'inflation' =>
                    'FP.CPI.TOTL.ZG',

                'unemployment' =>
                    'SL.UEM.TOTL.ZS',

                'population' =>
                    'SP.POP.TOTL',

            ];


            $result = [];


            /*
            |--------------------------------------------------------------------------
            | GET DATA
            |--------------------------------------------------------------------------
            */

            foreach (
                $indicators
                as $key => $indicator
            ) {

                try {

                    $response = Http::retry(
                        3,
                        500
                    )
                        ->timeout(15)
                        ->acceptJson()
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
                        $response->successful()
                    ) {

                        $json =
                            $response->json();

                        $result[$key] =
                            $json[1][0]['value']
                            ?? null;

                    } else {

                        $result[$key] =
                            null;
                    }

                } catch (\Throwable $e) {

                    Log::warning(
                        'World Bank Indicator Error',
                        [
                            'indicator' =>
                                $indicator,

                            'country' =>
                                $countryCode,

                            'error' =>
                                $e->getMessage(),
                        ]
                    );

                    $result[$key] =
                        null;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    'success',

                'country' =>
                    $countryCode,

                'year' =>
                    $year,

                'data' => [

                    'gdp' =>
                        $result['gdp']
                        ?? null,

                    'gdp_per_capita' =>
                        $result['gdp_per_capita']
                        ?? null,

                    'inflation' =>
                        $result['inflation']
                        ?? null,

                    'unemployment' =>
                        $result['unemployment']
                        ?? null,

                    'population' =>
                        $result['population']
                        ?? null,

                ],

            ]);

        } catch (\Throwable $e) {

            Log::error(
                'World Bank API Error',
                [
                    'country' =>
                        $countryCode,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'World Bank API gagal diakses.',

            ], 500);
        }
    }
}