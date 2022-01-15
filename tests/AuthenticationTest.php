<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanLogin()
    {
        // seed a user
        /** @var User $user */
        $user = User::factory()->count(1)->create()->first();

        $this->json('POST', 'api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['token', 'success']);

    }
}
