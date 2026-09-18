<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Dashboard routes
|--------------------------------------------------------------------------
| The admin dashboard now lives in the routes/admin directory (previously
| it sat inside routes/web.php). The academic-year filter posts here so
| every dashboard section re-queries against the selected year.
*/

Route::middleware(['auth', 'permission:view dashboard'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Academic Year filter — stores the selection in the session and
        // redirects back so the whole dashboard re-renders for that year.
        Route::post('/dashboard/academic-year', [DashboardController::class, 'setAcademicYear'])
            ->name('dashboard.set-year');
    });
