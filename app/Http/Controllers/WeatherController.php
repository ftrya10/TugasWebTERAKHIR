<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{

    /**
     * Menampilkan halaman Weather
     */
    public function index()
    {
        $weathers = Weather::with('country')->get();

        return view('pages.weather', compact('weathers'));
    }


    /**
     * Ambil data cuaca berdasarkan latitude dan longitude
     */
    public function getWeather($lat, $lng)
    {
        try {

            $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [

                'latitude' => $lat,

                'longitude' => $lng,

                'current' => [
                    'temperature_2m',
                    'relative_humidity_2m',
                    'rain',
                    'wind_speed_10m'
                ],

            ]);


            if ($response->successful()) {

                return response()->json([

                    'status' => 'success',

                    'data' => $response->json()['current'] ?? []

                ]);

            }


            return response()->json([

                'status' => 'error',

                'message' => 'Gagal mengambil data cuaca'

            ], 500);


        } catch (\Exception $e) {


            Log::error('Open-Meteo Error: '.$e->getMessage());


            return response()->json([

                'status' => 'error',

                'message' => $e->getMessage()

            ], 500);

        }
    }


    /**
     * Sinkronisasi data weather
     */
    public function sync()
    {
        return redirect()
            ->route('weather.index')
            ->with('success', 'Weather berhasil diperbarui');
    }

}