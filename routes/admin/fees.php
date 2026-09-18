<?php

use App\Http\Controllers\Admin\FeeCategoryController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\FeeReceiptController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Fees Management — student-centered table, all actions inside
        // the Livewire component. No. store/update/destroy routes needed
        // here anymore; that logic lives in App\Livewire\Admin\Fees\Index.
        Route::get('/fees', [FeeController::class, 'index'])
            ->middleware('permission:manage fees')
            ->name('fees.index');

        // Fee Categories CRUD.
        Route::get('/fee-categories', [FeeCategoryController::class, 'index'])
            ->middleware('permission:manage fees')
            ->name('fee-categories.index');

        // Receipts — classic controller+Blade, not Livewire (static
        // printable/downloadable documents).
        Route::get('/fees/receipts/{payment}', [FeeReceiptController::class, 'show'])
            ->middleware('permission:view fee details')
            ->name('fees.receipts.show');

        Route::get('/fees/receipts/{payment}/download', [FeeReceiptController::class, 'downloadPdf'])
            ->middleware('permission:view fee details')
            ->name('fees.receipts.download');

        // Fee Statement (optional, per-student full history document).
        Route::get('/fees/statement/{student}', [FeeReceiptController::class, 'statement'])
            ->middleware('permission:view fee details')
            ->name('fees.statement');

        Route::get('/fees/statement/{student}/download', [FeeReceiptController::class, 'downloadStatementPdf'])
            ->middleware('permission:view fee details')
            ->name('fees.statement.download');
    });
