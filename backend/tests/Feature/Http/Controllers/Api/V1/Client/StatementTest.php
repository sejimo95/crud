<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Client;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatementTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function api_v1_client_statement_index()
    {
        $user = User::first();
        $response = $this->actingAs($user)->get(url('api/v1/panel/client/statement'));
        $response->assertStatus(200);
    }

    /** @test */
    public function api_v1_client_statement_store()
    {
        $data = [
            'name' => $this->faker->name,
            'date' => $this->faker->dateTime
        ];

        $user = User::first();
        $response = $this->actingAs($user)->post(url('api/v1/panel/client/statement'), $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function api_v1_client_statement_update()
    {
        $user = User::first();
        $data = [
            'name' => $this->faker->name,
            'date' => $this->faker->dateTime
        ];

        // store
        $response = $this->actingAs($user)->post(url('api/v1/panel/client/statement'), [
            'name' => 'test_name',
            'date' => '2020-02-20'
        ]);
        $content = $response->decodeResponseJson();
        $statementId = $content['statement']['id'];

        // update
        $response = $this->actingAs($user)->patch(url("api/v1/panel/client/statement/$statementId"), $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function api_v1_client_statement_destroy()
    {
        $user = User::first();

        // store
        $response = $this->actingAs($user)->post(url('api/v1/panel/client/statement'), [
            'name' => 'test_name',
            'date' => '2020-02-20'
        ]);
        $content = $response->decodeResponseJson();
        $statementId = $content['statement']['id'];

        // destroy
        $response = $this->actingAs($user)->delete(url("api/v1/panel/client/statement/$statementId"));
        $response->assertStatus(200);
    }

}
