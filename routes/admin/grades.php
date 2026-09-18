<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentGradeController;


Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/grades/create', [StudentGradeController::class, 'create'])
            ->middleware('permission:enter student grades')
            ->name('grades.entry');

        Route::get('/grades/load', [StudentGradeController::class, 'load'])
            ->middleware('permission:enter student grades')
            ->name('grades.load');

        Route::post('/grades/store', [StudentGradeController::class, 'store'])
            ->middleware('permission:enter student grades')
            ->name('grades.store');

        Route::post('/grades/lock', [StudentGradeController::class, 'lockSemester'])
            ->middleware('permission:lock & unlock grade submission')
            ->name('grades.lock');


        Route::get('/grades/manage', [\App\Http\Controllers\Admin\GradeController::class, 'manage'])
            ->middleware('permission:manage grades|assign grade teachers')
            ->name('grades.manage');

        Route::get('/grades/audit-trail', [\App\Http\Controllers\Admin\GradeController::class, 'auditTrail'])
            ->middleware('permission:view grade audit trail')
            ->name('grades.audit-trail');
    });
