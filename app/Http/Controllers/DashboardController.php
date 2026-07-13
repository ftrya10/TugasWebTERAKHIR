<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->country ?? 'Germany';

        return view('dashboard', compact('country'));
    }
}