<?php

/*
*
* Frontend Access Controllers
* All route names are prefixed with 'frontend.auth'.
 */

use \App\Domains\Book\Http\Controllers\Frontend\BookOrderController;

Route::group(['as' => 'orders.'], function () {
    Route::get('/orders', [BookOrderController::class, 'orders'])->name('orders');
});
