<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class DemoRequestController extends Controller
{
    public function create()
    {
        return view('public.book-demo');
    }
}
