<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function entry()
    {
        return view('admin.attendance.entry');
    }
    public function summary()
    {
        return view('admin.attendance.summary');
    }
    public function history()
    {
        return view('admin.attendance.history');
    }
    public function reports()
    {
        return view('admin.attendance.reports');
    }
}
