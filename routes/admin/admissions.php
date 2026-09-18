<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdmissionController;

Route::middleware(['auth', 'permission:manage admissions'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
    });
