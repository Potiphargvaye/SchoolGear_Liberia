<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DemoRequestsExport;
use App\Http\Controllers\Controller;
use App\Models\DemoRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DemoRequestExportController extends Controller
{
    /**
     * Route is already behind auth + EnsurePlatformAdmin.
     * Honors the same search / status filters as the admin list.
     */
    public function __invoke(Request $request)
    {
        $status = $request->query('status');

        if (! is_string($status) || ! array_key_exists($status, DemoRequest::STATUSES)) {
            $status = null;
        }

        $search = $request->query('search');
        $search = is_string($search) ? $search : null;

        return Excel::download(
            new DemoRequestsExport($search, $status),
            'schoolgear-demo-requests-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
