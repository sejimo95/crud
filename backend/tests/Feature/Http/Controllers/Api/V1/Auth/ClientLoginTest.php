<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientLoginTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function api_v1_auth_client_login()
    {
        $data = [
            'email' => 'client@gmail.com',
            'password' => '12345678'
        ];
        $response = $this->post(url('api/v1/auth/client-login'), ['data' => json_encode($data)]);
        $response->assertStatus(200);
    }
}
