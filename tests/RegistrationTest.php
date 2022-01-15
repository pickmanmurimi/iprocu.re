<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanRegister()
    {
        // seed a user
        /** @var User $user */

        $this->json('POST', 'api/v1/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone_number' => '+254700007511',
            'email' => 'email@gmail.com',
            'password' => 'secret',
        ]);

        $this->response->assertStatus(201);
        $this->response->assertJson(
            [
                'status' => true
            ]);
        $this->seeInDatabase('users',['email' => 'email@gmail.com']);

    }
}
