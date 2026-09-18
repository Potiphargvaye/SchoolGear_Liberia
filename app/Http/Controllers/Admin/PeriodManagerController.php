<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PeriodManagerController extends Controller
{
    /**
     * Attendance Periods CRUD (1st Period, 2nd Period, etc.), school-scoped.
     * All logic lives in App\Livewire\Admin\Attendance\PeriodManager.
     */
    public function index(): View
    {
        return view('admin.attendance.periods');
    }
}
