<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PortController extends Controller
{
    /**
     * Menampilkan halaman Port Map.
     */
    public function index()
    {
        $countries = Country::orderBy('name')
            ->get();

        return view(
            'pages.port',
            compact('countries')
        );
    }

    /**
     * Mengambil data pelabuhan dari Overpass API.
     */
    public function getPortsByCountry(
        $countryName
    ) {
        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDASI NEGARA
            |--------------------------------------------------------------------------
            */

            $country = Country::where(
                'name',
                $countryName
            )->first();

            if (!$country) {

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'Negara tidak ditemukan'

                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | QUERY OVERPASS API
            |--------------------------------------------------------------------------
            */

            $query = '
                [out:json][timeout:25];

                area["name"="' .
                addslashes($countryName) .
                '"]->.searchArea;

                (
                    node["harbour"](area.searchArea);
                    way["harbour"](area.searchArea);
                );

                out center 10;
            ';

            /*
            |--------------------------------------------------------------------------
            | REQUEST API
            |--------------------------------------------------------------------------
            */

            $response = Http::withHeaders([

                'Accept' =>
                    'application/json',

                'Content-Type' =>
                    'application/x-www-form-urlencoded'

            ])
                ->timeout(60)
                ->asForm()
                ->post(
                    'https://overpass-api.de/api/interpreter',
                    [
                        'data' =>
                            $query
                    ]
                );

            /*
            |--------------------------------------------------------------------------
            | CEK RESPONSE
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                Log::error(
                    'Overpass API Error: ' .
                    $response->body()
                );

                return response()->json([

                    'status' =>
                        'error',

                    'message' =>
                        'Overpass API gagal',

                    'code' =>
                        $response->status()

                ], 500);
            }

            $elements =
                $response->json()['elements']
                ?? [];

            /*
            |--------------------------------------------------------------------------
            | SIMPAN DATA PELABUHAN
            |--------------------------------------------------------------------------
            */

            $savedPorts = [];

            foreach ($elements as $element) {

                $name =
                    $element['tags']['name']
                    ?? 'Unnamed Port';

                /*
                | Tentukan koordinat.
                */

                $latitude =
                    $element['lat']
                    ?? $element['center']['lat']
                    ?? null;

                $longitude =
                    $element['lon']
                    ?? $element['center']['lon']
                    ?? null;

                /*
                | Lewati data tanpa koordinat.
                */

                if (
                    $latitude === null ||
                    $longitude === null
                ) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | SIMPAN / UPDATE PELABUHAN
                |--------------------------------------------------------------------------
                */

                $port =
                    Port::updateOrCreate(

                        [
                            'country_id' =>
                                $country->id,

                            'name' =>
                                $name
                        ],

                        [

                            'city' =>
                                $element['tags']['addr:city']
                                ?? null,

                            'latitude' =>
                                $latitude,

                            'longitude' =>
                                $longitude,

                            /*
                            | Status awal.
                            | Nanti dapat diubah melalui
                            | Admin Port Dataset.
                            */

                            'status' =>
                                'active',

                            'description' =>
                                $element['tags']['description']
                                ?? null
                        ]
                    );

                $savedPorts[] =
                    $port;
            }

            /*
            |--------------------------------------------------------------------------
            | RETURN RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    'success',

                'country' =>
                    $countryName,

                'total' =>
                    count($savedPorts),

                'ports' =>
                    $savedPorts

            ]);

        } catch (\Exception $e) {

            Log::error(
                'Port API Error: ' .
                $e->getMessage()
            );

            return response()->json([

                'status' =>
                    'error',

                'message' =>
                    'Gagal mengambil data pelabuhan'

            ], 500);
        }
    }

    /**
     * Mengubah status pelabuhan.
     *
     * Status yang diperbolehkan:
     * active
     * congested
     * delayed
     * critical
     */
    public function updateStatus(
        Request $request,
        Port $port
    ) {
        $validated =
            $request->validate([

                'status' => [
                    'required',
                    'in:active,congested,delayed,critical'
                ]

            ]);

        $port->update([
            'status' =>
                $validated['status']
        ]);

        return response()->json([

            'status' =>
                'success',

            'message' =>
                'Status pelabuhan berhasil diperbarui',

            'port' =>
                $port

        ]);
    }
}