<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = $user->createToken('')->plainTextToken;
    }

    public function test_get_user()
    {
        $response = $this->json('GET', '/api/user', [], ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertJson([
            "status" => true
        ]);
    }
}
