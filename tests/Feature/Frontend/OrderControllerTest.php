<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Models\Book;
use App\Domains\Book\Models\Order;
use App\Domains\Book\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected BookService $bookService;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookService = $this->createMock(BookService::class);
    }

    public function testOrdersAsAdmin()
    {
        $admin = User::factory()->create(['type' => 'admin']);
        $user = User::factory()->create(['type' => 'user']);
        $book = Book::factory()->create();
        $this->be($admin);

        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'book_id' => $book->id,
                'user_id' => $admin->id,
                'return_date' => now()->addMonth(),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
                'return_date' => now()->addMonth(),
            ]);
        }



        $response = $this->actingAs($admin)->get(route('frontend.order.orders'));

        $response->assertStatus(200);

        $response->assertViewHas('orders', function ($viewOrders) {
            return $viewOrders->total() === 10;
        });
    }

    public function testOrdersAsUser()
    {
        $admin = User::factory()->create(['type' => 'admin']);
        $user = User::factory()->create(['type' => 'user']);
        $book = Book::factory()->create();
        $this->be($user);

        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'book_id' => $book->id,
                'user_id' => $admin->id,
                'return_date' => now()->addMonth(),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
                'return_date' => now()->addMonth(),
            ]);
        }

        $response = $this->actingAs($user)->get(route('frontend.order.orders'));

        $response->assertStatus(200);

        $response->assertViewHas('orders', function ($viewOrders) {
            return $viewOrders->total() === 5;
        });
    }


    public function testStoreWithValidData()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->bookService->method('orderBook')->willReturn(new Order([
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]));

        $this->app->instance(BookService::class, $this->bookService);

        $response = $this->actingAs($user)->post(route('frontend.order.store'), [
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('flash_success', __('Order was successfully placed.'));
    }

    public function testStoreOutOfStock()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->bookService->method('orderBook')->willreturn(null);

        $this->app->instance(BookService::class, $this->bookService);

        $response = $this->actingAs($user)->post(route('frontend.order.store'), [
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['order_id' => 'Book is out of stock.']);
    }

    public function testStoreWithInvalidData()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('frontend.order.store'), [
            'book_id' => null,
            'user_id' => null,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['book_id', 'user_id']);
    }

    public function testReturnWithValidData()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $order = Order::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'return_date' => now()->addMonth(),
        ]);

        $this->bookService->method('returnBook')->willReturn($order);

        $this->app->instance(BookService::class, $this->bookService);

        $response = $this->actingAs($user)->post(route('frontend.order.return'), [
            'order_id' => $order->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('flash_success', __('Book was successfully returned.'));
    }

    public function testReturnWithInvalidData()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('frontend.order.return'), [
            'order_id' => null,
            'user_id' => null,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['order_id', 'user_id']);
    }

    public function testReturnNotAllowed()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();


        $order = Order::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'return_date' => now()->addMonth(),
        ]);


        $this->bookService->method('returnBook')->willreturn(null);

        $this->app->instance(BookService::class, $this->bookService);

        $response = $this->actingAs($user)->post(route('frontend.order.return'), [
            'order_id' => $order->id,
            'user_id' => $user->id,
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['order_id' => 'You are not allowed to return this book.']);
    }

}
