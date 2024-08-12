<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_login_user_success(): void
    {
        $data =[
            'email' => 'melissa@gmail.com',
            'password' => '1234'
        ];

        $user = User::factory()->create([
            'name' => 'Melissa',
            'image_path' => '',
            'email' => 'melissa@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        $response = $this->postJson(route('auth.login'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User logged in successfully',
                'access_token'=> true,
                'token_type' => 'Bearer',
                'expiresIn' => 3600
            ]);

        $token = $response->json('access_token');

        $this->assertNotNull($token);

    }

    public function test_login_user_fail(): void
    {
        $data =[
            'email' => 'mel@gmail.com',
            'password' => '123'
        ];

        $user = User::factory()->create([
            'name' => 'Melissa',
            'image_path' => '',
            'email' => 'melissa@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        $response = $this->postJson(route('auth.login'), $data);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid login Crendentials',
            ]);

    }

    public function test_login_user_name_required(): void
    {
        $data =[
            'email' => '',
            'password' => '1234'
        ];

        $user = User::factory()->create([
            'name' => 'Felipe',
            'image_path' => '',
            'email' => 'felipe@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        $response = $this->postJson(route('auth.login'), $data);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => [
                    'email' => [
                        'The email field is required.'
                    ]
                ]
            ]);

    }
}
