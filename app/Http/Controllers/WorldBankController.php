<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class WorldBankController extends Controller
{

    public function sync()
    {

        $countries = Country::all();


        foreach($countries as $country)
        {


            // GDP API World Bank
            $gdpResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$country->code}/indicator/NY.GDP.MKTP.CD?format=json"
            );


            if(
                $gdpResponse->successful() &&
                isset($gdpResponse->json()[1][0]['value'])
            ){

                $gdp = $gdpResponse->json()[1][0]['value'];

            }else{

                $gdp = null;

            }



            // Inflation API World Bank
            $inflationResponse = Http::get(
                "https://api.worldbank.org/v2/country/{$country->code}/indicator/FP.CPI.TOTL.ZG?format=json"
            );


            if(
                $inflationResponse->successful() &&
                isset($inflationResponse->json()[1][0]['value'])
            ){

                $inflation =
                $inflationResponse->json()[1][0]['value'];

            }else{

                $inflation = null;

            }



            $country->update([

                'gdp' => $gdp,

                'inflation' => $inflation

            ]);


        }


        return back()->with(
            'success',
            'GDP dan Inflation berhasil diperbarui'
        );


    }

}