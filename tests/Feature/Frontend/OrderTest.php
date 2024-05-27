<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Book\Http\Controllers\Frontend\OrderController;
use App\Domains\Book\Models\Book;
use App\Domains\Book\Models\Order;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\TestCase;
use Validator;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private $orderController;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderController = resolve(OrderController::class);
        $this->adminUser = User::factory()->create(['type' => 'admin']);
        $this->normalUser = User::factory()->create(['type' => 'user']);
        $this->book = Book::factory()->create(['quantity' => 5]);
        $this->adminOrders = Order::factory()->create(['book_id' => $this->book->id, 'user_id' => $this->adminUser->id, 'return_date' => now()->addMonth()]);
        $this->normalOrders = Order::factory()->create(['book_id' => $this->book->id, 'user_id' => $this->normalUser->id, 'return_date' => now()->addMonth()]);

    }

    public function test_orders_returns_orders_for_admin()
    {
        Auth::shouldReceive('user')->once()->andReturn($this->adminUser);

        $response = $this->orderController->orders();

        $this->assertCount(2, $response->getData()['orders']);
        $this->assertTrue($response->getData()['orders']->contains($this->adminOrders));
        $this->assertTrue($response->getData()['orders']->contains($this->normalOrders));
    }

    public function test_orders_returns_user_orders()
    {
        Auth::shouldReceive('user')->twice()->andReturn($this->normalUser);

        $response = $this->orderController->orders();

        $this->assertCount(1, $response->getData()['orders']);
        $this->assertFalse($response->getData()['orders']->contains($this->adminOrders));
        $this->assertTrue($response->getData()['orders']->contains($this->normalOrders));
    }

    public function test_store_method_creates_order()
    {
        $request = Request::create('/orders', 'GET', [
            'book_id' => $this->book->id,
            'user_id' => $this->adminUser->id,
        ]);

        $response = $this->orderController->store($request);


        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertDatabaseHas('orders', [
            'book_id' => $this->book->id,
            'user_id' => $this->normalUser->id,
        ]);
    }
}
