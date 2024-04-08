<?php

/*
*
* Frontend Access Controllers
* All route names are prefixed with 'frontend.auth'.
 */

use \App\Domains\Book\Http\Controllers\Frontend\BookController;

Route::group(['as' => 'book.'], function () {
    Route::get('/books', [BookController::class, 'books'])->name('books');
});
