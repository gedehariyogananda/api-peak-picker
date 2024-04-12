<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'login')->name('loginPost');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware('authenticated')->group(function () {
    // Dashboard Route
    Route::middleware('auth-roles:admin')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });



        // datas users campains payments
        // Route::controller(PaymentController::class)
        //     ->prefix('data-history-payment')
        //     ->name('payment.')
        //     ->group(function () {
        //         Route::get('/{campain}/get-datas', 'index')->name('index');
        //     });
    });
});
