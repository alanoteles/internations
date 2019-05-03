<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    /** @test */
    public function check_if_user_was_properly_logged_out()
    {
        $user    = factory(User::class)->create([
            'email' => 'testuser@email.com',
            'admin' => true
            ]);

        $token   = $user->createToken();
        $headers = ["Authorization" => "Bearer $token"];


        $this->json('GET', 'api/groups', [], $headers)->assertStatus(200);
        $this->json('post', 'api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);


    }



    /** @test */
    public function check_if_user_was_logged_out()
    {
        $user   = factory(User::class)->create(['email' => 'testuser@email.com']);
        $token  = $user->createToken();
        $headers = ['Authentication' => "Bearer $token"];

        // Simulating logout
        $user->api_token = null;
        $user->save();

        $this->json('get', '/api/groups', [], $headers)->assertStatus(401);


    }
}
