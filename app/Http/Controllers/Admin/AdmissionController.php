<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage admissions');

        return view('admin.admissions.index');
    }
}
