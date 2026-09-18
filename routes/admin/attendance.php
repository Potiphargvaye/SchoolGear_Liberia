<?php

use App\Http\Controllers\Admin\AttendanceController;
use Illuminate\Support\Facades\Route; #
use App\Http\Controllers\Admin\PeriodManagerController;

Route::middleware(['auth'])->prefix('admin/attendance')->group(function () {
    Route::get('/', [AttendanceController::class, 'entry'])->middleware('permission:mark attendance')->name('attendance.entry');
    Route::get('/summary', [AttendanceController::class, 'summary'])->middleware('permission:mark attendance')->name('attendance.summary');
    Route::get('/history', [AttendanceController::class, 'history'])->middleware('permission:mark attendance')->name('attendance.history');
    Route::get('/reports', [AttendanceController::class, 'reports'])->middleware('permission:mark attendance')->name('attendance.reports');
    Route::get('/periods', [PeriodManagerController::class, 'index'])->middleware('permission:manage periods')->name('attendance.periods');
});
