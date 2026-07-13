<?php

namespace App\Http\Controllers;

use App\Models\Country;

class RiskController extends Controller
{
    public function index()
    {
        $countries = Country::with('riskScore')->get();

        return view('pages.risk', compact('countries'));
    }
}