<?php

/*
*
* Frontend Access Controllers
* All route names are prefixed with 'frontend.auth'.
 */

use \App\Domains\Book\Http\Controllers\Frontend\OrderController;

Route::group(['as' => 'order.', 'middleware' => 'auth'], function () {
    Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('store');
});
