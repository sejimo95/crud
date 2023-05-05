<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function api_v1_auth_register()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password(8)
        ];

        $response = $this->post(url('api/v1/auth/register'), ['data' => json_encode($data)]);
        $response->assertStatus(200);
    }
}
