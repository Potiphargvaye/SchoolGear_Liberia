<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentFee;
use Illuminate\Support\Facades\DB;
use App\Models\Student; // <--- import Student here


class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
{
    // Users stats (unchanged)
    $totalUsers    = User::count();
    $totalTeachers = User::where('role', 'teacher')->count();
    $totalStudents = User::where('role', 'student')->count();
    $totalAdmins   = User::where('role', 'admin')->count();


    // Students Statistics counts
$totalStudents = Student::count();
// Students by status
$totalCandidates = Student::where('status', 'candidate')->count();
$totalAdmitted = Student::where('status', 'admitted')->count();
$totalRegistered = Student::where('status', 'registered')->count();
$totalActive = Student::where('status', 'active')->count();
$totalDropout = Student::where('status', 'dropout')->count();
$totalCompleted = Student::where('status', 'completed')->count();

    // 🔹 Get selected academic year from session
    $selected_year = session('dashboard_academic_year', '');

    // 🔹 Base fees query (same logic as FeesController)
    $baseQuery = StudentFee::query();

    if (!empty($selected_year) && $selected_year !== 'all') {
        $baseQuery->where('academic_year', $selected_year);
    }

    // 🔹 Fees stats
    // Fees stats
    $stats = (clone $baseQuery)->select(
        DB::raw('COALESCE(SUM(amount), 0) as total_fees_due'),
        DB::raw('COALESCE(SUM(paid_amount), 0) as total_fees_collected'),
        DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count"),
        DB::raw("SUM(CASE WHEN status = 'partial' THEN 1 ELSE 0 END) as partial_count"),
        DB::raw("SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count"),
        DB::raw("SUM(CASE WHEN status = 'overdue' THEN 1 ELSE 0 END) as overdue_count"),
        DB::raw('COUNT(*) as total_records')
    )->first();

    // 🔹 Normalize cents → dollars
    $remaining_fees_due = ($stats->total_fees_due - $stats->total_fees_collected) / 100;
        $totalFeesCollected = $stats->total_fees_collected / 100;
        $totalFeesDue = $stats->total_fees_due / 100;

 
    // Fetch recent 5 transactions
    $recentTransactions = StudentFee::with('student')
        ->orderBy('payment_date', 'desc') // latest payments first
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalUsers',
            'totalTeachers',
            'totalStudents',
            'totalAdmins',
            'stats',
            'remaining_fees_due',
            'totalFeesCollected',
            'totalFeesDue',
            'selected_year',
                'totalStudents',
                'totalCandidates',
                'totalAdmitted',
                'totalRegistered',
                'totalRegistered',
                 'totalDropout',
                  'totalCompleted',
                  'totalActive',
                  'recentTransactions'




    ));
}
}