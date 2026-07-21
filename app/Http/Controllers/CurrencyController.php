<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyController extends Controller
{
    /**
     * Menampilkan halaman Exchange Rate.
     */
    public function index()
    {
        $countries = \App\Models\Country::with('exchangeRate')
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->where('name', '!=', '-')
            ->get();

        return \Inertia\Inertia::render('Currency/Index', [
            'countries' => $countries
        ]);
    }

    /**
     * Mengambil kurs mata uang real-time.
     *
     * Contoh:
     * /api/exchange-rates/USD
     */
    public function getExchangeRates(
        $baseCurrency = 'USD'
    ) {
        try {

            $apiKey = env(
                'EXCHANGERATE_API_KEY'
            );

            /*
            |--------------------------------------------------------------------------
            | PILIH API
            |--------------------------------------------------------------------------
            */

            if (
                $apiKey &&
                $apiKey !==
                'ISI_API_KEY_EXCHANGERATE_KAMU'
            ) {

                $url =
                    "https://v6.exchangerate-api.com/v6/" .
                    "{$apiKey}/latest/" .
                    strtoupper($baseCurrency);

            } else {

                $url =
                    "https://open.er-api.com/v6/latest/" .
                    strtoupper($baseCurrency);
            }

            /*
            |--------------------------------------------------------------------------
            | REQUEST API
            |--------------------------------------------------------------------------
            */

            $response = Http::timeout(10)
                ->get($url);

            /*
            |--------------------------------------------------------------------------
            | CEK RESPONSE
            |--------------------------------------------------------------------------
            */

            if (
                !$response->successful()
            ) {

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'Gagal mengambil data kurs'

                ], 500);
            }

            $data =
                $response->json();

            $rates =
                $data['rates']
                ?? [];

            /*
            |--------------------------------------------------------------------------
            | RETURN DATA
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    'success',

                'base' =>
                    strtoupper($baseCurrency),

                'rates' =>
                    $rates,

                'updated_at' =>
                    now()->toDateTimeString()

            ]);

        } catch (\Exception $e) {

            Log::error(
                'ExchangeRate Error: ' .
                $e->getMessage()
            );

            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'Gagal mengambil data nilai tukar'

            ], 500);
        }
    }
}