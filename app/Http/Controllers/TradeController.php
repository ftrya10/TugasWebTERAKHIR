<?php

namespace App\Http\Controllers;

use App\Models\Country;

class TradeController extends Controller
{
    public function index()
    {
        $countries = Country::with('riskScore')->get();

        return view('pages.trade', compact('countries'));
    }
}