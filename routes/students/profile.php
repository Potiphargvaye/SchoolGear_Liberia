<?php

use App\Http\Controllers\Students\StudentProfileController;
use Illuminate\Support\Facades\Route;

// Student profile and password routes.
// Student portal route group.
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/profile', [StudentProfileController::class, 'show'])->name('profile');
    Route::put('/profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
});
