<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    use WithFaker;

    /** @test */
    public function user_registered_successfully()
    {

        $payload    = ['email' => 'admin@email.com', 'password' => 'admin'];
        $user       = $this->json('POST', 'api/login', $payload)->getData()->data;
        $headers    = ['Authorization' => "Bearer " . $user->api_token];

        $payload = [
            'name'                  => $this->faker->firstName(),
            'email'                 => $this->faker->unique()->safeEmail(),
            'admin'                 => true,
            'password'              => bcrypt('secret')
        ];
        $payload['password_confirmation'] = $payload['password'];

        $this->json('post', '/api/users', $payload, $headers)
                    ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'admin',
                    'updated_at',
                    'created_at',
                    'id',
                    'api_token',
                ],
            ]);
    }


    /** @test */
    public function name_email_and_password_required()
    {
        $payload    = ['email' => 'admin@email.com', 'password' => 'admin'];
        $user       = $this->json('POST', 'api/login', $payload)->getData()->data;
        $headers    = ['Authorization' => "Bearer " . $user->api_token];

        $this->json('post', '/api/users', [], $headers)
            ->assertStatus(422)
            ->assertJson(

                    [
                        'name'      => ['The name field is required.'],
                        'email'     => ['The email field is required.'],
                        'password'  => ['The password field is required.'],
                    ]
            );
    }


    /** @test */
    public function password_confirmation_required()
    {
        $payload    = ['email' => 'admin@email.com', 'password' => 'admin'];
        $user       = $this->json('POST', 'api/login', $payload)->getData()->data;
        $headers    = ['Authorization' => "Bearer " . $user->api_token];

        $payload = [
            'name'      => $this->faker->firstName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'admin'     => true,
            'password'  => bcrypt('secret')
        ];

        $this->json('post', '/api/users', $payload, $headers)
            ->assertStatus(422)
            ->assertJson(
                    [
                        'password' =>  ['The password confirmation does not match.'],
                    ]
            );
    }
}
