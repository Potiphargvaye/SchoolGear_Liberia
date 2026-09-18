<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DocumentSettingsController extends Controller
{
    public function edit(): View
    {
        $this->authorize('manage document settings');

        return view('admin.settings.document-branding');
    }
}
