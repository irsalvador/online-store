<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase {
        RefreshDatabase::refreshDatabase as baseRefreshDatabase;
    }
    /** @test */
    public function it_can_create_a_new_admin_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'user_type' => 'admin'
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('admin', $user->user_type);
    }

    /** @test */
    public function it_can_create_a_new_customer_user()
    {
        $userData = [
            'name' => 'John Doe Jr',
            'email' => 'johnjr@example.com',
            'password' => 'password123',
            'user_type' => 'customer'
        ];

        $user = User::create($userData);

        $this->assertEquals('John Doe Jr', $user->name);
        $this->assertEquals('johnjr@example.com', $user->email);
        $this->assertEquals('customer', $user->user_type);
    }

    /** @test */
    public function it_requires_a_name_and_email()
    {
        $userData = [
            'password' => 'password123',
        ];

        $this->expectException(\Illuminate\Database\QueryException::class);
        User::create($userData);
    }
}

