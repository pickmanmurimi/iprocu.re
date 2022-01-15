<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A user can login
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
        $this->response->assertJsonStructure(
            [
                'access_token',
                'token_type',
                'expires_in',
            ]);

    }

    /**
     * Logging out
     *
     * @return void
     */
    public function testUserCanLogOut()
    {
        $this->loginAs();

        $this->json('POST', 'api/v1/auth/logout');

        $this->response->assertStatus(200);
        $this->response->assertJson(
            [
                'status' => 'success',
                'message' => 'Successfully logged out'
            ]);

    }

    /**
     * get authenticated user credentials
     *
     * @return void
     */
    public function testGetLoggedInUserCredentials()
    {
        $this->loginAs();

        $this->json('GET', 'api/v1/auth/me');

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(
            ['firstName','lastName','email','phoneNumber','created_at', 'updated_at']);

    }
}
