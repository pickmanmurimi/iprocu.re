<?php

use App\Models\Permission;
use App\Models\Role;
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
     * can get a single role
     *
     * @return void
     */
    public function testCanGetSingleRole()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');
        $role = Role::first();

        $this->json('GET', 'api/v1/roles/show/' . $role->id);

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            ['name','description', 'created_at', 'updated_at', 'permissions']]);

    }


    /**
     * can get all roles
     *
     * @return void
     */
    public function testCanGetRoles()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');
        $this->json('GET', 'api/v1/roles/show/');

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            [['name','description', 'created_at', 'updated_at', 'permissions']]]);

    }

    /**
     * customers cannot create a new role
     *
     * @return void
     */
    public function testCustomersCannotCreateRoles()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'customer');

        // get all the permissions
        $permissions = Permission::all()->pluck('id');

        $this->json('POST', 'api/v1/roles/new', [
            'name' => 'Test',
            'description' => 'Test role',
            'permissions' => $permissions,
        ]);

        $this->response->assertStatus(403);
        $this->response->assertJson(["message" => "This action is unauthorized.",]);

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
        $this->loginAs(null, 'admin');

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

    /**
     * Role can be updated
     *
     * @return void
     */
    public function testCanUpdateRoles()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get role
        $role = Role::first();

        $this->json('PUT', 'api/v1/roles/update/' . $role->id, [
            'name' => 'Test',
            'description' => 'Test role',
            'permissions' => $role->permissions->pluck('id'),
        ]);

        $this->response->assertStatus(200);
        $this->response->assertJson(["message" => "Role updated",]);
        $this->seeInDatabase('roles', ['name' => 'Test']);

    }

    /**
     * Role can be updated
     *
     * @return void
     */
    public function testCanDeleteRoles()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get role
        $role = Role::first();

        $this->json('DELETE', 'api/v1/roles/delete/' . $role->id);

        $this->response->assertStatus(200);
        $this->response->assertJson(["message" => "Role deleted",]);
        $this->assertTrue( Role::find($role->id) === null);

    }
}
