<?php

/*
*
* Frontend Access Controllers
* All route names are prefixed with 'frontend.auth'.
 */

use \App\Domains\Book\Http\Controllers\Frontend\BookController;

Route::group(['as' => 'books.'], function () {
    Route::get('/books', [BookController::class, 'books'])->name('books');
    Route::get('/books/author/{authorName}', [BookController::class, 'booksByAuthor'])->name('author');
});
