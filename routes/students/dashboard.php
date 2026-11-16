<?php

use App\Http\Controllers\Students\StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Student dashboard route.
// Student portal route group.
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});
