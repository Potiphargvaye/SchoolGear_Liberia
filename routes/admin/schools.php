<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchoolController;

Route::middleware([
    'auth',
    'permission:view schools',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/schools', [SchoolController::class, 'index'])
            ->name('schools.index');
    });
