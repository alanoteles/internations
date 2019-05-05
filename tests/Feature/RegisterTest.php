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
    public function user_registered_successfuly()
    {
        $payload = [
            'name'                  => $this->faker->firstName(),
            'email'                 => $this->faker->unique()->safeEmail(),
            'admin'                 => true,
            'password'              => bcrypt('secret')
        ];
        $payload['password_confirmation'] = $payload['password'];

        $this->json('post', '/api/register', $payload)
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
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson(

                    [
                        'name'      => ['The name field is required.'],
                        'email'     => ['The email field is required.'],
                        'password'  => ['The password field is required.'],
                    ]
            );
//            ->assertJson([
//            'message' => 'The given data was invalid.',
//            'errors' =>
//                [
//                    'name'      => ['The name field is required.'],
//                    'email'     => ['The email field is required.'],
//                    'password'  => ['The password field is required.'],
//                ]
//            ]);
    }


    /** @test */
    public function password_confirmation_required()
    {
        $payload = [
            'name'      => $this->faker->firstName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'admin'     => true,
            'password'  => bcrypt('secret')
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson(
                    [
                        'password' =>  ['The password confirmation does not match.'],
                    ]
            );
    }
}
