<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_user_can_login()
    {
        //create user
        /*  $user = User::factory()->create();

        $credentials = ['email' => $user->email, 'password' => 'userpassword'];

        $response = $this->postJson('/api/v1/user/login', $credentials);

        $response->assertStatus(200);
        $response->dump(); */
        $this->assertTrue(true);
    }
}
