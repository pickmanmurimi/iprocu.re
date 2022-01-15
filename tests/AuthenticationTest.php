<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanLoginViaOauth()
    {
        // seed a user
        /** @var User $user */
        $user = User::factory()->count(1)->create()->first();
        $this->setUpPassport();

        $this->json('POST', 'api/v1/oauth/token', [
                'client_secret' => config('oauth.users.client_secret'),
                'grant_type' => 'password',
                'client_id' => config('oauth.users.client_id'),
                'username' => $user->email,
                'password' => 'secret',
        ]);

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(
            [
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);

    }

    /**
     * set up passport oauth
     */
    private function setUpPassport()
    {
        // set up passport
        $client = new ClientRepository();
        $client = $client->createPasswordGrantClient(null, 'Lumen Password Grant Client',
            'http://localhost', 'users');

        config(['oauth.login_url' => env('OAUTH_URL')]);
        config(['oauth.users.client_id'=> $client->id]);
        config(['oauth.users.client_secret' => $client->secret] );
    }
}
