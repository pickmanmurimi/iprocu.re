<?php

use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * can create a new product
     *
     * @return void
     */
    public function testCanCreateNewProduct()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        $this->json('POST', 'api/v1/products/new', [
            'name' => 'Test name',
            'description' => 'Test description',
            'type' => 'Test type',
            'category' => 'Test category',
            'price' => 100.99,
            'quantity' => 5,
            'manufacturer' => 'Test manufacturer',
            'distributor' => 'Test distributor',
        ]);

        $this->response->assertStatus(201);
        $this->response->assertJson(['status' => 'success']);
        $this->seeInDatabase('products', ['name' => 'Test name']);

    }

    /**
     * customer can create a new product
     *
     * @return void
     */
    public function testCustomerCanCreateNewProduct()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'customer');

        $this->json('POST', 'api/v1/products/new', [
            'name' => 'Test name',
            'description' => 'Test description',
            'type' => 'Test type',
            'category' => 'Test category',
            'price' => 100.99,
            'quantity' => 5,
            'manufacturer' => 'Test manufacturer',
            'distributor' => 'Test distributor',
        ]);

        $this->response->assertStatus(201);
        $this->response->assertJson(['status' => 'success']);
        $this->seeInDatabase('products', ['name' => 'Test name']);

    }


    /**
     * can get a single product
     *
     * @return void
     */
    public function testCanGetSingleProduct()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');
        $product = Product::first();

        $this->json('GET', 'api/v1/products/show/' . $product->id);

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            ['name', 'description', 'type', 'category', 'price', 'quantity', 'manufacturer', 'distributor',]]);

    }


    /**
     * can get all users
     *
     * @return void
     */
    public function testCanGetProducts()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');
        $this->json('GET', 'api/v1/products/show/');

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            [['name', 'description', 'type', 'category', 'price', 'quantity', 'manufacturer', 'distributor',]]]);

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
     * Role can be updated
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
     * Role can be updated
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
