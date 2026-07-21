<?php

namespace App\Http\Controllers;

use App\Models\Country;

class TradeController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Filter agar baris kosong tidak masuk ke tabel Trade Analysis
        $countries = Country::whereNotNull('name')
                            ->where('name', '!=', '')
                            ->where('name', '!=', '-')
                            ->with('riskScore')
                            ->get();

        return view('pages.trade', compact('countries'));
    }
}