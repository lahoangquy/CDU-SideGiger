<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_cannot_be_created_new_user_invalid_form_request()
    {
        $response = $this->postJson('/api/register', ['first_name' => 'John']);

        $response->assertStatus(422);
    }
}
