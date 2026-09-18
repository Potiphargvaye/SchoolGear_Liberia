<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage students');

        return view('admin.students.index');
    }

    public function show(Student $student): View
    {
        $this->authorize('view student details');

        if ($student->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        return view('admin.students.profile', compact('student'));
    }
}
