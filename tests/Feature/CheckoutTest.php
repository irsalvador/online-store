<?php

// tests/Feature/CheckoutTest.php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class CheckoutTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }

    /** @test */
    public function a_customer_can_checkout()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        Auth::logout();
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        Session::put('cart', [
            $product1->id => [
                'quantity' => 2,
                'name'     => $product1['name'],
                'price'    => $product1['price']
                ],
            $product2->id => [
                'quantity' => 1,
                'name'     => $product2['name'],
                'price'    => $product2['price']
            ],
        ]);

        $details = Session::get('cart');
        $totalPrice = ($details[$product1->id]['quantity'] * $details[$product1->id]['price']) + ($details[$product2->id]['quantity'] * $details[$product2->id]['price']);
        $response = $this->post(route('cart.checkout'));

        $response->assertStatus(200);

        $this->assertFalse(Session::has('cart'));

        $this->assertDatabaseHas('orders', [
            'id'           => Order::latest()->first()->id,
            'user_id'      => $customer->id,
            'total_amount' => $totalPrice,
            'shipped'      => 0,
            'cancelled'    => 0
        ]);
    }
}

