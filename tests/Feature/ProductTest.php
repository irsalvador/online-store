<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }

    /** @test */
    public function a_customer_cannot_create_a_product()
    {
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 100.00,
        ];

        $response = $this->post('/admin/products', $productData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', $productData);
    }

    /** @test */
    public function a_customer_cannot_update_a_product_created_by_an_admin()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product = Product::factory()->create();

        Auth::logout();
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'This is the updated product.',
            'price' => 150.00,
        ];

        $response = $this->put("/admin/products/{$product->id}", $updatedData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', $updatedData);
    }

    /** @test */
    public function a_customer_cannot_delete_a_product_created_by_an_admin()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product = Product::factory()->create();

        Auth::logout();
        $customer = User::factory()->create(['user_type' => 'customer']);
        Auth::login($customer);

        $response = $this->delete("/admin/products/{$product->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    /** @test */
    public function an_admin_can_create_a_product()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 100.00,
        ];

        $response = $this->post('/admin/products', $productData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function an_admin_can_update_a_product()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'This is the updated product.',
            'price' => 150.00,
        ];

        $response = $this->put("/admin/products/{$product->id}", $updatedData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function an_admin_can_delete_a_product()
    {
        $admin = User::factory()->create(['user_type' => 'admin']);
        Auth::login($admin);

        $product = Product::factory()->create();

        $response = $this->delete("/admin/products/{$product->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

