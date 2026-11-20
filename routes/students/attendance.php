<?php

use App\Http\Controllers\Students\StudentAttendanceController;
use Illuminate\Support\Facades\Route;

// Student attendance route.
// Student portal route group.
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('attendance');
});
