<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_login()
    {
        $credentials = ['email' => 'admin@buckhill.co.uk', 'password' => 'admin'];

        $response = $this->postJson('/api/v1/user/login', $credentials);

        $response->assertStatus(200);
        $response->dump();
        $this->assertTrue(true);
    }
}
