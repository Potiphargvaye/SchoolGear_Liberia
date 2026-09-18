<?php

use App\Http\Controllers\Admin\DocumentSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:manage document settings'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/settings/document-branding', [DocumentSettingsController::class, 'edit'])
            ->name('settings.document-branding');
    });
