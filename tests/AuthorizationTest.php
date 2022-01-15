<?php

use App\Models\Permission;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class AuthorizationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * can create a new role
     *
     * @return void
     */
    public function testCanCreateNewRole()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get all the permissions
        $permissions = Permission::all()->pluck('id');

        $this->json('POST', 'api/v1/roles/new', [
            'name' => 'Test',
            'description' => 'Test role',
            'permissions' => $permissions,
        ]);

        $this->response->assertStatus(201);
        $this->response->assertJson(['status' => 'success']);
        $this->seeInDatabase('roles', ['name' => 'Test']);

    }

    /**
     * only permissions that exist can be assigned
     *
     * @return void
     */
    public function testCannotCreateRoleWithWrongPermissions()
    {
        // seed a user
        $this->artisan('db:seed');

        $this->json('POST', 'api/v1/roles/new', [
            'name' => 'Test',
            'description' => 'Test role',
            'permissions' => [101, 99],
        ]);

        $this->response->assertStatus(422);
        $this->response->assertJson(
            ['message' => 'The given data was invalid.',
                'errors' => [
                    'permissions' => [
                        'The selected permissions is invalid.'
                    ]
                ]
            ]);

    }
}
