<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SchoolController extends Controller
{
    /**
     * Schools CRUD — School / Tenant Foundation (Phase 2).
     * All logic lives in App\Livewire\Admin\Schools\Index.
     *
     * Gated on 'view schools'. Create/Edit/Delete are enforced inside
     * the Livewire component itself (against 'create schools',
     * 'edit schools', 'delete schools'), same pattern as Fee Categories.
     */
    public function index(): View
    {
        $this->authorize('view schools');

        return view('admin.schools.index');
    }
}
