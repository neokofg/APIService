<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Product::factory()->count(10)->create();
        $user = User::factory()->create();
        $this->token = $user->createToken('')->plainTextToken;
    }

    public function test_index_products()
    {
        $response = $this->json('POST', '/api/product/index', [], ['Authorization' => 'Bearer '. $this->token]);
        $response->assertJson([
            "status" => true
        ]);
    }
}
