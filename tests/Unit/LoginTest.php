<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }

    /** @test */
    public function it_can_login_with_valid_admin_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'user_type' => 'admin'
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_requires_valid_credentials_for_admin_login()
    {
        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'invalid-password',
            'user_type' => 'admin'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_can_login_with_valid_customer_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'user_type' => 'customer'
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_requires_valid_credentials_for_customer_login()
    {
        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'invalid-password',
            'user_type' => 'customer'
        ]);

        $response->assertSessionHasErrors('email');
    }
}

