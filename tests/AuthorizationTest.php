<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class AuthorizationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreateNewRole()
    {
        // seed a user
        /** @var User $user */

        $this->json('POST', 'api/v1/roles/new', [
            'name' => 'Test',
            'description' => 'Test role',
            'permissions' => [1,2,3],
        ]);

        $this->response->assertStatus(201);
        $this->response->assertJson(
            [
                'status' => true
            ]);
        $this->seeInDatabase('users',['email' => 'email@gmail.com']);

    }
}
