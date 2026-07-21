<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    /**
     * Menampilkan halaman Global News.
     */
    public function index()
    {
        $countries = Country::orderBy('name')
            ->get();

        return view(
            'pages.news',
            compact('countries')
        );
    }

    /**
     * Mengambil berita ekonomi, perdagangan,
     * logistik, dan geopolitik.
     */
    public function getNews(Request $request)
    {
        try {

            $keyword = $request->query(
                'q',
                'global trade OR supply chain OR geopolitics OR logistics'
            );

            $apiKey = env(
                'GNEWS_API_KEY'
            );

            /*
            |--------------------------------------------------------------------------
            | CEK API KEY
            |--------------------------------------------------------------------------
            */

            if (
                !$apiKey ||
                $apiKey ===
                'ISI_API_KEY_GNEWS_KAMU'
            ) {

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'GNews API Key belum diisi di .env'

                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | REQUEST GNEWS API
            |--------------------------------------------------------------------------
            */

            $response = Http::timeout(10)
                ->get(
                    'https://gnews.io/api/v4/search',
                    [

                        'q' =>
                            $keyword,

                        'lang' =>
                            'en',

                        'max' =>
                            10,

                        'sortby' =>
                            'publishedAt',

                        'apikey' =>
                            $apiKey
                    ]
                );

            /*
            |--------------------------------------------------------------------------
            | CEK RESPONSE API
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                Log::error(
                    'GNews API Error: ' .
                    $response->body()
                );

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'Gagal mengambil berita dari GNews API'

                ], 500);
            }

            $articles =
                $response->json()['articles']
                ?? [];

            /*
            |--------------------------------------------------------------------------
            | RETURN DATA BERITA
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    'success',

                'total' =>
                    count($articles),

                'articles' =>
                    $articles

            ]);

        } catch (\Exception $e) {

            Log::error(
                'GNews Error: ' .
                $e->getMessage()
            );

            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'Terjadi kesalahan saat mengambil berita'

            ], 500);
        }
    }

    /**
     * Mengambil berita berdasarkan negara.
     */
    public function getCountryNews(
        Request $request,
        Country $country
    ) {
        try {

            $apiKey =
                env('GNEWS_API_KEY');

            if (
                !$apiKey ||
                $apiKey ===
                'ISI_API_KEY_GNEWS_KAMU'
            ) {

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'GNews API Key belum diisi'

                ], 400);
            }

            $keyword =
                $country->name .
                ' trade OR economy OR geopolitics';

            $response = Http::timeout(10)
                ->get(
                    'https://gnews.io/api/v4/search',
                    [

                        'q' =>
                            $keyword,

                        'lang' =>
                            'en',

                        'max' =>
                            10,

                        'sortby' =>
                            'publishedAt',

                        'apikey' =>
                            $apiKey
                    ]
                );

            if (!$response->successful()) {

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'Gagal mengambil berita negara'

                ], 500);
            }

            return response()->json([

                'status' =>
                    'success',

                'country' =>
                    $country->name,

                'articles' =>
                    $response->json()['articles']
                    ?? []

            ]);

        } catch (\Exception $e) {

            Log::error(
                'Country News Error: ' .
                $e->getMessage()
            );

            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'Gagal mengambil berita negara'

            ], 500);
        }
    }
}