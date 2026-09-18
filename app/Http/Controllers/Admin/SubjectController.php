<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SubjectController extends Controller
{
    /**
     * Subject CRUD + Teacher assignment.
     * All logic lives in App\Livewire\Admin\Subjects\SubjectManager.
     */
    public function index(): View
    {
        return view('admin.subjects.index');
    }
}
