<?php

namespace App\Domains\Book\Services;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Models\Book;
use App\Domains\Book\Models\Order;

class BookService
{
    public function orderBook($userId, $bookId): string | Order
    {
        $book = Book::findOrFail($bookId);

        if ($book->quantity === 0) {
            return "Sorry, this book is out of stock.";
        }

        $book->decrement('quantity');

        $user = User::findOrFail($userId);

        $order = new Order();
        $order->book_id = $book->id;
        $order->user_id = $user->id;
        $order->return_date = now()->addMonth();
        $order->save();

        return $order;
    }

    public function returnBook($orderId, $userId) : string | Order
    {
        $order = Order::findOrFail($orderId);
        error_log('Order User ID: ' . $order->user->id . ', Type: ' . gettype($order->user->id));
        error_log('Passed User ID: ' . $userId . ', Type: ' . gettype($userId));
        if((string) $order->user->id != $userId) {
            return "You are not allowed to return this book.";
        }

        $order->book->increment('quantity');

        $order->delete();

        return $order;
    }
}
