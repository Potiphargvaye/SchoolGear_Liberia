<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:is-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/profile', 'admin.profile')->name('profile');
    });
