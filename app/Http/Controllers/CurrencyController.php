<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyController extends Controller
{
    /**
     * Menampilkan halaman Exchange Rate
     */
    public function index()
{
    $countries = \App\Models\Country::with('exchangeRate')->get();

    return view('pages.exchange', compact('countries'));
}

    /**
     * Ambil kurs mata uang real-time
     */
    public function getExchangeRates($baseCurrency = 'USD')
    {
        try {
            $apiKey = env('EXCHANGERATE_API_KEY');
            
            $url = $apiKey && $apiKey !== 'ISI_API_KEY_EXCHANGERATE_KAMU'
                ? "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}"
                : "https://open.er-api.com/v6/latest/{$baseCurrency}";

            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'base' => $baseCurrency,
                    'rates' => $response->json()['rates'] ?? []
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data kurs'
            ], 500);

        } catch (\Exception $e) {

            Log::error('ExchangeRate Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}