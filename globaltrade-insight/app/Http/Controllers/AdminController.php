<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Country;
use App\Models\Port;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        // Total users
        $totalUsers = User::count();

        // Total countries
        $totalCountries = Country::count();

        // Total ports
        $totalPorts = Port::count();

        // Active / operational ports
        $activePorts = Port::whereRaw(
            'LOWER(status) IN (?, ?)',
            ['operational', 'active']
        )->count();

        // Congested / delayed / critical ports
        $congestedPorts = Port::whereRaw(
            'LOWER(status) IN (?, ?, ?)',
            ['congested', 'delayed', 'critical']
        )->count();

        // Total analysis articles
        $articles = Article::count();

        // Latest users
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCountries',
            'totalPorts',
            'activePorts',
            'congestedPorts',
            'articles',
            'recentUsers'
        ));
    }

    /**
     * Manage Users
     */
    public function users()
    {
        $users = User::latest()
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    /**
     * Manage Ports
     */
    public function ports()
    {
        $ports = Port::with('country')
            ->latest()
            ->paginate(10);

        return view('admin.ports', compact('ports'));
    }

    /**
     * Manage Articles
     */
    public function articles()
    {
        $articles = Article::latest()
            ->paginate(10);

        return view('admin.articles', compact('articles'));
    }
}
