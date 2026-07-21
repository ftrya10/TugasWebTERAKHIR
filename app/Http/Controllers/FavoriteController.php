<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $watchlist = Watchlist::with(['country.exchangeRate', 'country.riskScore', 'country.weather'])
            ->where('user_id', Auth::id())
            ->get()
            ->pluck('country');

        $countries = Country::whereNotNull('name')
            ->where('name', '!=', '')
            ->where('name', '!=', '-')
            ->with('exchangeRate', 'riskScore', 'weather')
            ->orderBy('name')
            ->get();

        $watchlistIds = Watchlist::where('user_id', Auth::id())->pluck('country_id')->toArray();

        return \Inertia\Inertia::render('Favorites/Index', [
            'watchlist' => $watchlist,
            'countries' => $countries,
            'watchlistIds' => $watchlistIds,
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate(['country_id' => 'required|exists:countries,id']);

        $userId = Auth::id();
        $countryId = $request->country_id;

        $existing = Watchlist::where('user_id', $userId)
            ->where('country_id', $countryId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed', 'country_id' => $countryId]);
        } else {
            Watchlist::create(['user_id' => $userId, 'country_id' => $countryId]);
            return response()->json(['status' => 'added', 'country_id' => $countryId]);
        }
    }
}