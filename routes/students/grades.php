<?php

use App\Http\Controllers\Students\StudentPortalGradeController;
use Illuminate\Support\Facades\Route;

// Student grades route.
// Student portal route group.
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/grades', [StudentPortalGradeController::class, 'index'])->name('grades');
});
