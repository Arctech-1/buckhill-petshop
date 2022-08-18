<?php

namespace Tests\Feature;

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
    public function test_example()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYnVja2hpbGwtcGV0c2hvcC50ZXN0IiwidXVpZCI6IjE5YzM2MWE0LTZlYWEtNGQ3NC05ODkxLTZjYjgyZjBjNDQ3OCIsImlhdCI6MTY2MDg0ODgzMC4yNzg3MzIsImV4cCI6MTY2MDg1MjQzMC4yNzg3MzJ9.DuYxGkbsNeaV2bCwSpLzPE6kS7NVliZ_j7bEoPjyBLc';

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/v1/user/check');

        $response->assertForbidden();
        $response->dump();
    }
}
