<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    /**
     * Menampilkan halaman Global News
     */
    public function index()
    {
        $countries = Country::all();

        return view('pages.news', compact('countries'));
    }


    /**
     * Ambil berita ekonomi/logistik berdasarkan keyword
     */
    public function getNews(Request $request)
    {
        try {

            $keyword = $request->query('q', 'trade economy');
            $apiKey = env('GNEWS_API_KEY');


            if (!$apiKey || $apiKey === 'ISI_API_KEY_GNEWS_KAMU') {

                return response()->json([
                    'status' => 'error',
                    'message' => 'GNews API Key belum diisi di .env'
                ], 400);

            }


            $response = Http::timeout(5)->get('https://gnews.io/api/v4/search', [

                'q' => $keyword,
                'lang' => 'en',
                'max' => 5,
                'apikey' => $apiKey

            ]);


            if ($response->successful()) {

                return response()->json([

                    'status' => 'success',
                    'articles' => $response->json()['articles'] ?? []

                ]);

            }


            return response()->json([

                'status' => 'error',
                'message' => 'Gagal mengambil berita'

            ], 500);


        } catch (\Exception $e) {


            Log::error('GNews Error: '.$e->getMessage());


            return response()->json([

                'status' => 'error',
                'message' => $e->getMessage()

            ], 500);

        }
    }
}