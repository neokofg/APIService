<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_register()
    {
        $response = $this->json('POST', '/api/auth/register', [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test'
        ]);
        $response->assertJson([
            "status" => true
        ]);
    }
    public function test_login()
    {
        User::factory()->create(['email' => 'test@gmail.com', 'password' => Hash::make('test')]);
        $response = $this->json('POST', 'api/auth/login', [
           'email' => 'test@gmail.com',
           'password' => 'test'
        ]);
        $response->assertJson([
            "status" => true
        ]);
    }

    public function test_invalid_login()
    {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'testInvalid@gmail.com',
            'password' => 'test'
        ]);
        $response->assertJson([
            "status" => false
        ]);
    }
}
