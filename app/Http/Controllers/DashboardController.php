<?php

namespace App\Http\Controllers;


use App\Models\Country;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function index(Request $request)
    {


        $countries = Country::all();


        $country = Country::first();


        if($request->country)
        {

            $country = Country::find($request->country);

        }


        return view('dashboard.index',

        compact(

            'countries',
            'country'

        ));

    }

}