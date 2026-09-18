<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    /**
     * Enrollments — owns all academic-status lifecycle actions
     * (promote, graduate, transfer, suspend, expel, reactivate).
     * Students module stays a basic identity record (edit/delete only).
     */
    public function index(): View
    {
        $this->authorize('manage enrollments');

        return view('admin.enrollments.index');
    }
}
