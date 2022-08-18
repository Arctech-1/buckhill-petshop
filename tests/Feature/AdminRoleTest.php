<?php

namespace Tests\Feature;

use App\Models\JwtTokens;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRoleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_user_can_access_user_route()
    {
        $adminToken = JwtTokens::where(['user_id' => 1, 'last_used_at' => null])->first();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $adminToken->unique_id
        ])->get('/api/v1/user/check');

        $response->assertForbidden();
        $response->dump();
    }
}
