<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FeeController extends Controller
{
    /**
     * Fees Management — student-centered table with category tabs.
     * All search/filter/assign/payment/history logic lives in
     * App\Livewire\Admin\Fees\Index; this method's only job is
     * authorizing the route and rendering the wrapper view.
     *
     * Everything that used to live here (store, updatePayment, destroy,
     * update, getFeeDetails, getFeeEditData) has moved into the Livewire
     * component and the FeeAssignment/FeePayment models — see
     * app/Livewire/Admin/Fees/Index.php.
     */
    public function index(): View
    {
        $this->authorize('manage fees');

        return view('admin.fees.index');
    }
}
