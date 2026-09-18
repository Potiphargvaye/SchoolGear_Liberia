<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    /**
     * Academic Years — school-scoped calendar management.
     * All CRUD logic lives in App\Livewire\Admin\AcademicYears\Index.
     */
    public function index(): View
    {
        $this->authorize('manage academic years');

        return view('admin.academic-years.index');
    }
}
