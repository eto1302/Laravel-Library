<?php

namespace App\Domains\Book\Services;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Models\Book;
use App\Domains\Book\Models\Order;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function orderBook(int $userId, int $bookId): ?Order
    {
        return DB::transaction(function () use ($userId, $bookId) {
            $book = Book::query()->lockForUpdate()->findOrFail($bookId);

            if ($book->quantity === 0) {
                return null;
            }


            $book->decrement('quantity');

            $user = User::findOrFail($userId);

            $order = new Order();
            $order->book_id = $book->id;
            $order->user_id = $user->id;
            $order->return_date = now()->addMonth();
            $order->save();

            return $order;
        });
    }

    public function returnBook(int $orderId, int $userId): ?Order
    {
        return DB::transaction(function () use ($orderId, $userId) {
            $order = Order::findOrFail($orderId);
            if ((string)$order->user->id != $userId) {
                return null;
            }

            $order->book->increment('quantity');

            $order->delete();

            return $order;
        });
    }
}
