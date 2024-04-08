<?php

namespace App\Domains\Book\Services;

use App\Domains\Book\Models\Order;

class BookService
{
    public function orderBook($userId, $bookId)
    {
        $order = Order::create([
            'user_id' => $userId,
            'book_id' => $bookId
        ]);

        return $order;
    }
}
