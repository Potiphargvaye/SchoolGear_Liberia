<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Grade → Teacher assignment (and, for Platform Admins, Grade CRUD).
     * All logic lives in App\Livewire\Admin\Grades\GradeManager.
     *
     * Lives in its own view namespace (grade-management) rather than
     * admin/grades, since that folder already holds the Grade Entry
     * module's views (select-grade, grade-entry).
     */
    public function manage(): View
    {
        return view('admin.grade-management.manage');
    }

    public function auditTrail(): View
    {
        return view('admin.grade-management.audit-trail');
    }
}
