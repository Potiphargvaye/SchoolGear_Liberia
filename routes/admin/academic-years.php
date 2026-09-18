<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AcademicYearController;

Route::middleware([
    'auth',
    'permission:manage academic years',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/academic-years', [AcademicYearController::class, 'index'])
            ->name('academic-years.index');
    });
