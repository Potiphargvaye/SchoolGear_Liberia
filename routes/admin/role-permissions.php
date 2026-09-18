<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccessControl\RolePermissionController;


Route::middleware(['auth', 'permission:manage permissions'])
    ->prefix('admin/access-control')
    ->name('admin.access-control.')
    ->group(function () {


        Route::prefix('role-permissions')
            ->name('role-permissions.')
            ->group(function () {


                Route::get('/', 
                    [RolePermissionController::class, 'index']
                )->name('index');


                Route::get('/{role}/edit',
                    [RolePermissionController::class, 'edit']
                )->name('edit');


                Route::put('/{role}',
                    [RolePermissionController::class, 'update']
                )->name('update');


            });

    });