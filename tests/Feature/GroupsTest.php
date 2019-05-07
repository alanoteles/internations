<?php

namespace Tests\Feature;

use App\Group;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupsTest extends TestCase
{

    use WithFaker;

    /** @test */
    public function group_created_successfully()
    {

        $payload    = ['email' => 'admin@email.com', 'password' => 'admin'];
        $user       = $this->json('POST', 'api/login', $payload)->getData()->data;
        $headers    = ['Authorization' => "Bearer " . $user->api_token];

        $payload    = ['name' => $this->faker->name];

        $this->json('POST', '/api/groups', $payload, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                    'name',
                    'updated_at',
                    'created_at',
                    'id'
                ]);
    }


    /** @test  */
    public function group_updated_successfully()
    {
        $payload    = ['email' => 'admin@email.com', 'password' => 'admin'];
        $user       = $this->json('POST', 'api/login', $payload)->getData()->data;
        $headers    = ['Authorization' => "Bearer " . $user->api_token];

        $group = factory(Group::class)->create([
            'name' => 'Testing Group'
        ]);
        $payload    = ['name' => $this->faker->name];

        $this->json('PUT', '/api/groups/' . $group->id, $payload, $headers)
                ->assertStatus(200)
                ->assertJsonStructure([
                        'id',
                        'name',
                        'updated_at',
                        'created_at',

                ]);
    }

    /** @test  */
    public function group_deleted_successfully()
    {
        $payload    = ['email' => 'admin@email.com', 'password' => 'admin'];
        $user       = $this->json('POST', 'api/login', $payload)->getData()->data;
        $headers    = ['Authorization' => "Bearer " . $user->api_token];

        $group = factory(Group::class)->create([
            'name' => 'Testing Group'
        ]);

        $this->json('DELETE', '/api/groups/' . $group->id, [], $headers)
            ->assertStatus(204);
    }


}
