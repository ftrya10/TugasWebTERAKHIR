<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{

    /**
     * Display a listing of the countries.
     */
    public function index()
    {
        $countries = Country::with(['weather', 'exchangeRate', 'riskScore'])
            ->whereNotNull('name')
            ->where('name', '!=', '-')
            ->where('name', '!=', '')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.countries', compact('countries'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return response()->json(
            $country->load(['weather', 'exchangeRate', 'news', 'riskScore'])
        );
    }


    /**
     * Ambil profil negara dari REST Countries API.
     */
    public function getCountryDetail($name)
    {
        try {

            $response = Http::timeout(5)
                ->get("https://restcountries.com/v3.1/name/{$name}");


            if ($response->successful()) {

                $countryData = $response->json()[0] ?? null;


                return response()->json([

                    'status' => 'success',

                    'data' => [

                        'name' => $countryData['name']['common'] ?? $name,

                        'region' => $countryData['region'] ?? '-',

                        'subregion' => $countryData['subregion'] ?? '-',

                        'languages' => isset($countryData['languages'])
                            ? implode(', ', $countryData['languages'])
                            : '-',


                        'currencies' => $countryData['currencies'] ?? [],

                        'latlng' => $countryData['latlng'] ?? [0,0],

                        'flag' => $countryData['flags']['png'] ?? '',

                    ],

                ]);

            }


            return response()->json([

                'status'=>'error',

                'message'=>'Negara tidak ditemukan'

            ],404);


        } catch (\Exception $e) {


            Log::error('REST Countries Error: '.$e->getMessage());


            return response()->json([

                'status'=>'error',

                'message'=>$e->getMessage()

            ],500);

        }
    }



    /**
     * Ambil data ekonomi dari World Bank API
     */
    public function getEconomicData($countryCode)
    {
        try {


            // GDP
            $gdp = Http::timeout(10)->get(
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/NY.GDP.MKTP.CD?format=json"
            )->json();



            // Inflasi
            $inflation = Http::timeout(10)->get(
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/FP.CPI.TOTL.ZG?format=json"
            )->json();



            // Populasi
            $population = Http::timeout(10)->get(
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/SP.POP.TOTL?format=json"
            )->json();



            // Export
            $export = Http::timeout(10)->get(
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/TX.VAL.MRCH.CD.WT?format=json"
            )->json();



            // Import
            $import = Http::timeout(10)->get(
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/TM.VAL.MRCH.CD.WT?format=json"
            )->json();



            return response()->json([

                'status'=>'success',

                'country_code'=>$countryCode,

                'GDP'=>$gdp[1][0]['value'] ?? 0,

                'Inflation'=>$inflation[1][0]['value'] ?? 0,

                'Population'=>$population[1][0]['value'] ?? 0,

                'Export'=>$export[1][0]['value'] ?? 0,

                'Import'=>$import[1][0]['value'] ?? 0,

            ]);



        } catch(\Exception $e) {


            Log::error('World Bank Error: '.$e->getMessage());


            return response()->json([

                'status'=>'error',

                'message'=>$e->getMessage()

            ],500);

        }
    }

}