<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }

    /** @test */
    public function a_customer_cannot_mark_an_order_as_shipped()
    {
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $cart['1'] = [
            'quantity' => 1,
            'name'     => 'test',
            'price'    => 1.00
        ];

        $order = Order::factory()->create([
            'order_details' => serialize($cart),
            'total_amount'  => 1.00
        ]);

        $response = $this->put(route('admin.orders.markAsShipped', ['order_id' => $order->id]));
        $response->assertStatus(403);

        $this->assertDatabaseHas('orders', [
            'id'      => $order->id,
            'shipped' => 0
        ]);
    }

    /** @test */
    public function an_admin_can_mark_an_order_as_shipped()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $cart['1'] = [
            'quantity' => 1,
            'name'     => 'test',
            'price'    => 1.00
        ];

        $order = Order::factory()->create([
            'order_details' => serialize($cart),
            'total_amount'  => 1.00
        ]);

        $response = $this->put(route('admin.orders.markAsShipped', ['order_id' => $order->id]));
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id'      => $order->id,
            'shipped' => 1
        ]);
    }

    /** @test */
    public function a_customer_cannot_cancel_an_order()
    {
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $cart['1'] = [
            'quantity' => 1,
            'name'     => 'test',
            'price'    => 1.00
        ];

        $order = Order::factory()->create([
            'order_details' => serialize($cart),
            'total_amount'  => 1.00
        ]);

        $response = $this->put(route('admin.orders.cancel', ['order_id' => $order->id]));
        $response->assertStatus(403);

        $this->assertDatabaseHas('orders', [
            'id'        => $order->id,
            'cancelled' => 0,
        ]);
    }

    /** @test */
    public function an_admin_can_cancel_an_order()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $cart['1'] = [
            'quantity' => 1,
            'name'     => 'test',
            'price'    => 1.00
        ];

        $order = Order::factory()->create([
            'order_details' => serialize($cart),
            'total_amount'  => 1.00
        ]);

        $response = $this->put(route('admin.orders.cancel', ['order_id' => $order->id]));
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id'        => $order->id,
            'cancelled' => 1,
        ]);
    }
}

