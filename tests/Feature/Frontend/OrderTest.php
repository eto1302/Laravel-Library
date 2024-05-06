<?php

namespace Tests\Feature\Frontend;

use App\Domains\Book\Http\Controllers\Frontend\OrderController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private $orderController;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderController = new OrderController();
    }

    public function test_orders_returns_orders_for_admin()
    {
        $adminUser = factory(User::class)->state('admin')->create();
        $orders = factory(Order::class, 5)->create();

        Auth::shouldReceive('user')->once()->andReturn($adminUser);

        $response = $this->get('/orders');

        $response->assertViewIs('frontend.order.orders')
            ->assertViewHas('orders', $orders);
    }

    public function test_orders_returns_user_orders()
    {
        $user = factory(User::class)->create();
        $userOrders = factory(Order::class, 3)->create(['user_id' => $user->id]);

        Auth::shouldReceive('user')->once()->andReturn($user);

        $response = $this->get('/orders');

        $response->assertViewIs('frontend.order.orders')
            ->assertViewHas('orders', $userOrders);
    }

    public function test_store_method_creates_order()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $request = new Request([
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);

        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Validator::make([], []));


        $controller = new OrderController();
        $response = $controller->store($request);


        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertDatabaseHas('orders', [
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);
    }
}
