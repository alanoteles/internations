<?php

namespace Tests\Feature\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /** @test */
    public function requires_email_and_password()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' =>
                [
                    'email'     => ['The email field is required.'],
                    'password'  => ['The password field is required.'],
                ]
            ]);
    }


    /** @test */
    public function user_logins_successfuly()
    {

        $user = factory(User::class)->create();

        $payload = ['email' => 'admin@email.com', 'password' => 'admin'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'admin',
                    'api_token',
                    'created_at',
                    'updated_at'
                ],
            ]);

    }
}
