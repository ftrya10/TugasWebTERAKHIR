<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * Menampilkan halaman Weather.
     */
    public function index()
    {
        $weathers = Weather::with('country')
            ->latest()
            ->get();

        return view(
            'pages.weather',
            compact('weathers')
        );
    }

    /**
     * Ambil data cuaca berdasarkan
     * latitude dan longitude.
     */
    public function getWeather(
        $lat,
        $lng
    ) {
        try {

            $response = Http::timeout(10)
                ->get(
                    'https://api.open-meteo.com/v1/forecast',
                    [

                        'latitude' =>
                            $lat,

                        'longitude' =>
                            $lng,

                        'current' => implode(',', [

                            'temperature_2m',
                            'relative_humidity_2m',
                            'rain',
                            'wind_speed_10m'

                        ])

                    ]
                );

            if (!$response->successful()) {

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'Gagal mengambil data cuaca'

                ], 500);
            }

            $current =
                $response->json()['current']
                ?? [];

            return response()->json([

                'status' =>
                    'success',

                'data' =>
                    $current

            ]);

        } catch (\Exception $e) {

            Log::error(
                'Open-Meteo Error: ' .
                $e->getMessage()
            );

            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'Gagal mengambil data cuaca'

            ], 500);
        }
    }

    /**
     * Sinkronisasi data cuaca
     * untuk seluruh negara.
     */
    public function sync()
    {
        $countries = Country::whereNotNull(
                'latitude'
            )
            ->whereNotNull(
                'longitude'
            )
            ->get();

        $successCount = 0;

        $failedCount = 0;

        foreach ($countries as $country) {

            try {

                $response =
                    Http::timeout(10)
                    ->get(
                        'https://api.open-meteo.com/v1/forecast',
                        [

                            'latitude' =>
                                $country->latitude,

                            'longitude' =>
                                $country->longitude,

                            'current' => implode(',', [

                                'temperature_2m',
                                'relative_humidity_2m',
                                'rain',
                                'wind_speed_10m'

                            ])

                        ]
                    );

                if (!$response->successful()) {

                    $failedCount++;

                    continue;
                }

                $current =
                    $response->json()['current']
                    ?? [];

                /*
                |--------------------------------------------------------------------------
                | DATA CUACA
                |--------------------------------------------------------------------------
                */

                $temperature =
                    (float) (
                        $current['temperature_2m']
                        ?? 0
                    );

                $humidity =
                    (float) (
                        $current['relative_humidity_2m']
                        ?? 0
                    );

                $rain =
                    (float) (
                        $current['rain']
                        ?? 0
                    );

                $windSpeed =
                    (float) (
                        $current['wind_speed_10m']
                        ?? 0
                    );

                /*
                |--------------------------------------------------------------------------
                | HITUNG WEATHER SCORE
                |--------------------------------------------------------------------------
                |
                | Skor 0 = risiko rendah
                | Skor 100 = risiko tinggi
                |
                */

                $weatherScore = 0;

                /*
                | Hujan
                */

                if ($rain >= 20) {

                    $weatherScore += 40;

                } elseif ($rain >= 5) {

                    $weatherScore += 20;
                }

                /*
                | Angin
                */

                if ($windSpeed >= 60) {

                    $weatherScore += 40;

                } elseif ($windSpeed >= 30) {

                    $weatherScore += 20;
                }

                /*
                | Kelembapan sangat tinggi
                */

                if ($humidity >= 90) {

                    $weatherScore += 20;
                }

                /*
                | Batasi skor 0 - 100
                */

                $weatherScore =
                    min(
                        100,
                        $weatherScore
                    );

                /*
                |--------------------------------------------------------------------------
                | SIMPAN DATA WEATHER
                |--------------------------------------------------------------------------
                */

                Weather::updateOrCreate(

                    [
                        'country_id' =>
                            $country->id
                    ],

                    [

                        'temperature' =>
                            $temperature,

                        'condition' =>
                            $this->getWeatherCondition(
                                $rain,
                                $windSpeed
                            ),

                        'weather_score' =>
                            $weatherScore

                    ]
                );

                $successCount++;

            } catch (\Exception $e) {

                $failedCount++;

                Log::error(

                    'Weather Sync Error: ' .
                    $country->name .
                    ' - ' .
                    $e->getMessage()

                );
            }
        }

        return redirect()
            ->route('weather.index')
            ->with(
                'success',
                "Weather berhasil diperbarui. " .
                "Berhasil: {$successCount}, " .
                "Gagal: {$failedCount}"
            );
    }

    /**
     * Menentukan kondisi cuaca sederhana.
     */
    private function getWeatherCondition(
        $rain,
        $windSpeed
    ) {
        if ($windSpeed >= 60) {

            return 'Storm';

        }

        if ($rain >= 20) {

            return 'Heavy Rain';

        }

        if ($rain >= 5) {

            return 'Rain';

        }

        if ($windSpeed >= 30) {

            return 'Strong Wind';

        }

        return 'Normal';
    }
}