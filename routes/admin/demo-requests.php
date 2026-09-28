<?php

use App\Http\Controllers\Admin\DemoRequestExportController;
use App\Http\Middleware\EnsurePlatformAdmin;
use Illuminate\Support\Facades\Route;

// Platform/Super Admin only (school_id === null).
Route::middleware(['auth', EnsurePlatformAdmin::class])
    ->prefix('admin/demo-requests')
    ->name('admin.demo-requests.')
    ->group(function () {
        Route::view('/', 'admin.demo-requests.index')->name('index');
        Route::get('/export', DemoRequestExportController::class)->name('export');
    });
