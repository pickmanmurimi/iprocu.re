<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * can create a new role
     *
     * @return void
     */
    public function testCanCreateNewUser()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get role
        $role = Role::inRandomOrder()->first();

        $this->json('POST', 'api/v1/users/new', [
            'first_name' => 'Test First name',
            'last_name' => 'Test Last name',
            'email' => 'test@gmail.com',
            'phone_number' => '+254701145285',
            'role' => $role->id,
        ]);

        $this->response->assertStatus(201);
        $this->response->assertJson(['status' => 'success']);
        $this->seeInDatabase('users', ['email' => 'test@gmail.com']);

    }


    /**
     * can get a single role
     *
     * @return void
     */
    public function testCanGetSingleUser()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');
        $user = User::first();

        $this->json('GET', 'api/v1/users/show/' . $user->id);

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            ['firstName', 'lastName', 'phoneNumber', 'email', 'roles', 'created_at', 'updated_at',]]);

    }


    /**
     * can get all users
     *
     * @return void
     */
    public function testCanGetUsers()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');
        $this->json('GET', 'api/v1/users/show/');

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            [['firstName', 'lastName', 'phoneNumber', 'email', 'roles', 'created_at', 'updated_at',]]]);

    }

    /**
     * customers cannot create a new user
     *
     * @return void
     */
    public function testCustomersCannotCreateUsers()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'customer');

        // get role
        $role = Role::inRandomOrder()->first();

        $this->json('POST', 'api/v1/users/new', [
                'first_name' => 'Test First name',
                'last_name' => 'Test Last name',
                'email' => 'test@gmail.com',
                'phone_number' => '+254701145285',
                'role' => $role->id,
            ]
        );

        $this->response->assertStatus(403);
        $this->response->assertJson(["message" => "This action is unauthorized.",]);
    }

    /**
     * User can be updated
     *
     * @return void
     */
    public function testCanUpdateUser()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get role
        $user = User::first();

        $this->json('PUT', 'api/v1/users/update/' . $user->id, [
            'first_name' => 'Test First name',
            'last_name' => 'Test Last name',
            'email' => 'test@gmail.com',
            'phone_number' => '+254701145285',
            'role' => Role::first()->id,
        ]);

        $this->response->assertStatus(200);
        $this->response->assertJson(["message" => "Role updated",]);
        $this->seeInDatabase('users', ['email' => 'test@gmail.com']);

    }

    /**
     * User can be updated
     *
     * @return void
     */
    public function testCanDeleteUsers()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get user
        $user = User::first();

        $this->json('DELETE', 'api/v1/users/delete/' . $user->id);

        $this->response->assertStatus(200);
        $this->response->assertJson(["message" => "User deleted",]);
        $this->assertTrue(User::find($user->id) === null);

    }
}
