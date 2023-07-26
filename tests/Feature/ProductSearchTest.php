<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }

    /** @test */
    public function a_customer_can_search_for_products_by_name_or_description()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product1 = Product::factory()->create(['name' => 'Product A', 'description' => 'This is Product A']);
        $product2 = Product::factory()->create(['name' => 'Product B', 'description' => 'Description of Product B']);
        $product3 = Product::factory()->create(['name' => 'Test', 'description' => 'Test']);

        Auth::logout();
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $response = $this->get(route('home', ['search' => 'Product']));
        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertSee($product2->name);
        $response->assertSee($product1->description);
        $response->assertSee($product2->description);
        $response->assertDontSee($product3->name);
        $response->assertDontSee($product3->description);
    }

    /** @test */
    public function a_customer_cannot_search_for_products_by_name_or_description_in_admin_page()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product1 = Product::factory()->create(['name' => 'Product A', 'description' => 'This is Product A']);
        $product2 = Product::factory()->create(['name' => 'Product B', 'description' => 'Description of Product B']);
        $product3 = Product::factory()->create(['name' => 'Test', 'description' => 'Test']);

        Auth::logout();
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $response = $this->get(route('admin.products.index', ['search' => 'Product']));
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_search_for_products_by_name_or_description()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product1 = Product::factory()->create(['name' => 'Product A', 'description' => 'This is Product A']);
        $product2 = Product::factory()->create(['name' => 'Product B', 'description' => 'Description of Product B']);
        $product3 = Product::factory()->create(['name' => 'Test', 'description' => 'Test']);

        $response = $this->get(route('admin.products.index', ['search' => 'Product']));
        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertSee($product2->name);
        $response->assertSee($product1->description);
        $response->assertSee($product2->description);
        $response->assertDontSee($product3->name);
        $response->assertDontSee($product3->description);
    }
}


