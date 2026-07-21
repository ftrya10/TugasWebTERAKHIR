<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the User Dashboard (Global Supply Chain).
     * Hak akses: User
     * - Global Country Dashboard (Livewire: GlobalDashboard)
     * - Favorite Monitoring List (Watchlists)
     */
    public function index()
    {
        // Render the main Livewire layout
        return view('layouts.app'); 
        // Note: The actual dashboard logic is handled via the GlobalDashboard Livewire component.
        // You could also render the component directly via route.
    }
}
