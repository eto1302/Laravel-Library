<?php

namespace Tests\Services;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Models\Book;
use App\Domains\Book\Models\Order;
use App\Domains\Book\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $book;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->book = Book::factory()->create(['quantity' => 5]);
        $this->bookService =  new BookService();
    }

    public function test_successful_order()
    {
        $order = $this->bookService->orderBook($this->user->id, $this->book->id);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($this->user->id, $order->user_id);
        $this->assertEquals($this->book->id, $order->book_id);
        $this->assertTrue($this->user->orders->contains($order));
        $this->assertTrue($this->book->orders->contains($order));

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('books', 26);
        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'quantity' => 4,
        ]);
        $this->assertDatabaseHas('orders', [
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'return_date' => now()->addMonth()
        ]);
    }

    public function test_failed_order_quantity()
    {
        $emptyBook = Book::factory()->create(['quantity' => 0]);
        $order = $this->bookService->orderBook($this->user->id, $emptyBook->id);

        $this->assertNull($order, 'Order should be null');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('books', 27);
        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'quantity' => 5,
        ]);
        $this->assertDatabaseHas('books', [
            'id' => $emptyBook->id,
            'quantity' => 0,
        ]);
        $this->assertDatabaseMissing('orders', [
            'book_id' => $this->book->id,
            'user_id' => $this->user->id,
            'return_date' => now()->addMonth()
        ]);
    }

    public function test_successful_return()
    {
        $order = Order::factory()->create(['book_id' => $this->book->id, 'user_id' => $this->user->id, 'return_date' => now()->addMonth()]);
        $returned = $this->bookService->returnBook($order->id, $this->user->id);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertInstanceOf(Order::class, $returned);
        $this->assertEquals($this->user->id, $returned->user_id);
        $this->assertEquals($this->book->id, $returned->book_id);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('books', 26);
        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'quantity' => 6,
        ]);

        $this->assertDatabaseMissing('orders', [
            'book_id' => $order->book_id,
            'user_id' => $order->user_id,
            'return_date' => $order->return_date
        ]);
    }

    public function test_failed_return_unauthorized()
    {
        $newUser = User::factory()->create();
        $order = Order::factory()->create(['book_id' => $this->book->id, 'user_id' => $this->user->id, 'return_date' => now()->addMonth()]);
        $returned = $this->bookService->returnBook($order->id, $newUser->id);

        $this->assertNull($returned, 'Order should be null');

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('books', 26);

        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('orders', [
            'book_id' => $order->book_id,
            'user_id' => $order->user_id,
            'return_date' => $order->return_date
        ]);
    }
}
