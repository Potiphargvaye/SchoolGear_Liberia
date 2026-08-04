<?php

// app/Http/Controllers/AdminDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        return view('admin.dashboard'); // Changed from dashboard.admin to admin.dashboard
    }
}




