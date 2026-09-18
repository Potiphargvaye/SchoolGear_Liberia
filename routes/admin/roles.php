<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccessControl\RoleController;

Route::middleware(['auth', 'permission:manage roles'])
    ->prefix('admin/access-control')
    ->name('admin.access-control.')
    ->group(function () {

        Route::prefix('roles')
            ->name('roles.')
            ->group(function () {

                Route::get('/', [RoleController::class, 'index'])
                    ->name('index');

                Route::get('/create', [RoleController::class, 'create'])
                    ->name('create');

                Route::post('/', [RoleController::class, 'store'])
                    ->name('store');

                Route::get('/{role}/edit', [RoleController::class, 'edit'])
                    ->name('edit');

                Route::put('/{role}', [RoleController::class, 'update'])
                    ->name('update');

                Route::delete('/{role}', [RoleController::class, 'destroy'])
                    ->name('destroy');
            });

    });