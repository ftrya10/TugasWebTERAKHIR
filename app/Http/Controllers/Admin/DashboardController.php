<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     * Hak akses: Admin
     * - Kelola User
     * - Kelola Dataset Pelabuhan
     * - Kelola Artikel Analisis
     */
    public function index()
    {
        // Admin dashboard logic here
        // e.g. return view('admin.dashboard');
        
        return view('admin.dashboard'); // This would point to your admin view
    }
}
