<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoritController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserPurchasedController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'getAllProduct');
    Route::get('/{id}', 'getProductById');
    Route::get('/category/tenda', 'getProductCategoryTenda');
    Route::get('/category/alat-camping', 'getProductCategoryAlatCamping');
    Route::get('/category/lainnya', 'getProductCategoryLainnya');
});

Route::controller(FavoritController::class)->prefix('favorit')->group(function () {
    Route::post('/', 'setFavoritProductUser');
    Route::get('/', 'getFavoritProductUser');
    Route::delete('/{id}', 'deleteFavoritProductUser');
});

Route::controller(UserPurchasedController::class)->prefix('purchased')->group(function () {
    Route::post('/masuk-keranjang', 'insertKeranjang');
    Route::get('/keranjang', 'getKeranjang');
    Route::post('/keranjang/{id}/tambah', 'tambahSatuBarang');
    Route::delete('/keranjang/{id}/hapus', 'hapusSatuBarang');
    Route::patch('/keranjang/checkout', 'checkoutKeranjang');

    // menampilkan riwayat 
    Route::get('/riwayat', 'getRiwayatPembelian');
});
