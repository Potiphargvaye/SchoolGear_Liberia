<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccessControl\UserController;

Route::middleware([
    'auth',
    'permission:view users'
])
    ->prefix('admin/access-control')
    ->name('admin.access-control.')
    ->group(function () {

        Route::prefix('users')
            ->name('users.')
            ->group(function () {

                Route::get('/', [UserController::class, 'index'])
                    ->name('index');

                Route::post('/', [UserController::class, 'store'])
                    ->middleware('permission:create users')
                    ->name('store');

                Route::get('/{user}', [UserController::class, 'show'])
                    ->name('show');

                Route::put('/{user}', [UserController::class, 'update'])
                    ->middleware('permission:edit users')
                    ->name('update');

                Route::delete('/{user}', [UserController::class, 'destroy'])
                    ->middleware('permission:delete users')
                    ->name('destroy');
            });
    });






