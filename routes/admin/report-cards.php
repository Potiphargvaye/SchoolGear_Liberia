<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportCardController;

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/report-cards/{level?}', [ReportCardController::class, 'index'])
            ->middleware('permission:view report cards')
            ->name('report.cards.index');

        Route::get('/report-card/{level}/{enrollment}', [ReportCardController::class, 'print'])
            ->middleware('permission:view report cards')
            ->name('report.card.dynamic');

        Route::get('/report-cards/print-multiple', [ReportCardController::class, 'printMultiple'])
            ->middleware('permission:view report cards')
            ->name('report.cards.print-multiple');

        Route::delete('/report-card/student-grades/{enrollment}', [ReportCardController::class, 'deleteStudentGrades'])
            ->middleware('permission:delete student grades')
            ->name('student.grades.delete');
    });
