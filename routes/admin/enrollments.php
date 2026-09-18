<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EnrollmentController;

Route::middleware(['auth', 'permission:manage enrollments'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    });
