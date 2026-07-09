<?php

namespace App\Http\Controllers;

use App\Models\Weather;

class WeatherController extends Controller
{
    public function index()
    {
        $weathers = Weather::with('country')->get();

        return view('pages.weather', compact('weathers'));
    }
}