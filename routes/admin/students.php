<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;

Route::middleware(['auth', 'permission:manage students'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    });


Route::middleware(['auth', 'permission:view student details'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    });
