<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }

    /** @test */
    public function a_product_can_be_added_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('cart.add'), ['product_id' => $product->id]);

        $response->assertStatus(200);

        $this->assertTrue(Session::has('cart'));
        $cart = Session::get('cart');
        $this->assertTrue(isset($cart[$product->id]));
        $this->assertEquals(1, $cart[$product->id]['quantity']);
    }

    /** @test */
    public function an_item_can_be_removed_from_cart()
    {
        $product = Product::factory()->create();

        Session::put('cart', [$product->id => ['quantity' => 1]]);

        $response = $this->delete(route('cart.item.clear', ['product_id' => $product->id]));
        $response->assertStatus(200);

        $this->assertTrue(Session::has('cart'));
        $cart = Session::get('cart');
        $this->assertFalse(isset($cart[$product->id]));
    }

    /** @test */
    public function the_cart_can_be_cleared()
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();
        Session::put('cart', [
            $product1->id => ['quantity' => 2],
            $product2->id => ['quantity' => 1],
        ]);

        $response = $this->post(route('cart.clear'));
        $response->assertStatus(200);

        $this->assertFalse(Session::has('cart'));
    }
}

