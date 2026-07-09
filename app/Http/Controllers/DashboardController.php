<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua negara
        $countries = Country::all();

        // Ambil negara beserta relasinya
        if ($request->filled('country')) {
            $country = Country::with([
                'weather',
                'exchangeRate',
                'news',
                'riskScore'
            ])->findOrFail($request->country);
        } else {
            $country = Country::with([
                'weather',
                'exchangeRate',
                'news',
                'riskScore'
            ])->first();
        }

        return view('dashboard.index', compact('countries', 'country'));
    }
}