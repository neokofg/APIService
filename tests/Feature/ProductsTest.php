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

    private String $token;
    private Product $product;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        Product::factory()->count(10)->create();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('')->plainTextToken;
        $this->product = Product::inRandomOrder()->first();
    }

    public function test_index_products()
    {
        $response = $this->json('GET', '/api/product/index');
        $response->assertJson([
            "status" => true
        ]);
    }

    public function test_find_product()
    {
        $response = $this->json('GET', '/api/product/find', ['id' => $this->product->id]);
        $response->assertJson([
            "status" => true
        ]);
    }

    public function test_buy_product()
    {
        $response = $this->json('POST', '/api/product/buy',
            ['id' => $this->product->id],
            ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertJson([
            "status" => true
        ]);
    }

    public function test_update_product()
    {
        $this->product->user_id = $this->user->id;
        $this->product->save();
        $response = $this->json('PATCH', '/api/product/update',
            ['id' => $this->product->id, 'is_rentable' => true],
            ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertJson([
            "status" => true
        ]);
    }

    public function test_rent_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            "is_rentable" => true,
            "user_id" => $user->id
        ]);
        $response = $this->json('POST', '/api/product/rent',
            ['id' => $product->id, 'hours' => 4],
            ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertJson([
            "status" => true
        ]);
    }
}
