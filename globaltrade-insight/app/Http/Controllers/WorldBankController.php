<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorldBankController extends Controller
{
    public function sync()
    {
        $countries = Country::all();


        foreach ($countries as $country) {

            try {


                $gdp = $this->getWorldBankData(
                    $country->code,
                    'NY.GDP.MKTP.CD'
                );


                $inflation = $this->getWorldBankData(
                    $country->code,
                    'FP.CPI.TOTL.ZG'
                );



                $country->update([

                    'gdp' => $gdp,

                    'inflation' => $inflation

                ]);



            } catch (\Exception $e) {


                Log::error(
                    "WorldBank gagal {$country->name}: "
                    .$e->getMessage()
                );


                continue;

            }

        }



        return back()->with(
            'success',
            'GDP dan Inflation berhasil diperbarui'
        );

    }



    private function getWorldBankData($countryCode, $indicator)
    {

        $response = Http::retry(3, 1000)
            ->timeout(15)
            ->get(
                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}",
                [
                    'format' => 'json',
                    'per_page' => 10
                ]
            );


        if (!$response->successful()) {

            return null;

        }


        $data = $response->json();



        if (!isset($data[1])) {

            return null;

        }



        foreach ($data[1] as $row) {


            if (
                isset($row['value']) &&
                $row['value'] !== null
            ) {

                return $row['value'];

            }

        }



        return null;

    }
}