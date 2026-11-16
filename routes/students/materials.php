<?php

use App\Http\Controllers\Students\StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Student learning materials route.
// Student portal route group.
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/materials', [StudentDashboardController::class, 'materials'])->name('materials');
});
