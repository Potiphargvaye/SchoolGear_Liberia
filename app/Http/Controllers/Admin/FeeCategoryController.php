<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FeeCategoryController extends Controller
{
    /**
     * Fee Categories CRUD — lets categories be added/renamed/deactivated
     * without touching code, per the requirement to not hardcode them.
     * All logic lives in App\Livewire\Admin\FeeCategories\Index.
     *
     * Gated on the same 'manage fees' permission as the main Fees page —
     * no new permission introduced.
     */
    public function index(): View
    {
        $this->authorize('manage fees');

        return view('admin.fee-categories.index');
    }
}
