<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PortController extends Controller
{

    /**
     * Menampilkan halaman Port Map
     */
    public function index()
    {
        return view('pages.port');
    }



    /**
     * Ambil data pelabuhan dari Overpass API
     */
    public function getPortsByCountry($countryName)
    {
        try {


            $query = '[out:json][timeout:25];

            area["name"="' . $countryName . '"]->.searchArea;

            (
                node["harbour"](area.searchArea);
                way["harbour"](area.searchArea);
            );

            out center 10;';



            $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])
                ->timeout(60)
                ->asForm()
                ->post(
                    'https://overpass-api.de/api/interpreter',
                    [
                        'data' => $query
                    ]
                );



            if ($response->successful()) {


                return response()->json([

                    'status'=>'success',

                    'country'=>$countryName,

                    'ports'=>$response->json()['elements'] ?? []

                ]);

            }



            return response()->json([

                'status'=>'error',

                'message'=>'Overpass API gagal',

                'code'=>$response->status(),

                'response'=>$response->body()

            ],500);



        } catch(\Exception $e) {


            Log::error(
                'Port API Error: '.$e->getMessage()
            );


            return response()->json([

                'status'=>'error',

                'message'=>$e->getMessage()

            ],500);

        }
    }

}