<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function test_store_user_success(): void
    {
        $data = [
            'name' => 'John Fredy',
            'email' => 'johnfre@gmail.com',
            'image_path' => '',
            'password' => '1234'
        ];

        $response = $this->postJson(route('users.store'), $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User Created Successfully'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johnfre@gmail.com'
        ]);
    }

    public function test_store_user_fail_email(): void
    {
        $data = [
            'name' => 'Juan',
            'email' => 'juan',
            'image_path' => '',
            'password' => '1234'
        ];

        $response = $this->postJson(route('users.store'), $data);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => [
                    'email' => [
                        'The email must be a valid email address.'
                    ]
                ]
            ]);
    }
}
