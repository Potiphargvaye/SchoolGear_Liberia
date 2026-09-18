<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/subjects', [\App\Http\Controllers\Admin\SubjectController::class, 'index'])
            ->middleware('permission:manage academic subjects')
            ->name('subjects.index');
    });
