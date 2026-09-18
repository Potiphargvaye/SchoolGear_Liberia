<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SchoolRegistrationController extends Controller
{
    /**
     * Public School Owner self-registration page.
     * All logic lives in App\Livewire\Public\SchoolRegistration,
     * mirroring the field set and defaultsn used by the admi.n 
     * school-creation flow (App\Livewire\Admin\Schools\Index::storeSchool)..
     */
    public function create(): View
    {
        return view('public.register');
    }
}
