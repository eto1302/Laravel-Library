<?php

namespace App\Domains\Book\Services;

use App\Domains\Book\Models\Book;

class BookService
{
    public function orderBook($userId, $bookId)
    {
        $bookOrder = BookOrder::create([
            'user_id' => $userId,
            'book_id' => $bookId
        ]);

        return $bookOrder;
    }
}
