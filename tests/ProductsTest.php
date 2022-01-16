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
     * can get all products
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
     * customer can own products
     *
     * @return void
     */
    public function testCustomerCanGetOwnProducts()
    {
        // seed a user
        $this->artisan('db:seed');
        $customer = Role::whereName('customer')->first()->users->first();
        $this->loginAs($customer);
        $this->json('GET', 'api/v1/products/my-products');

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            [['name', 'description', 'type', 'category', 'price', 'quantity', 'manufacturer', 'distributor',]]]);

    }

    /**
     * customers can get products
     *
     * @return void
     */
    public function testCustomerCanGetProducts()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'customer');
        $this->json('GET', 'api/v1/products/show/');

        $this->response->assertStatus(200);
        $this->response->assertJsonStructure(['data' =>
            [['name', 'description', 'type', 'category', 'price', 'quantity', 'manufacturer', 'distributor',]]]);

    }

    /**
     * Product can be updated
     *
     * @return void
     */
    public function testCanUpdateProduct()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get product
        $product = Product::first();

        $this->json('PUT', 'api/v1/products/update/' . $product->id, [
            'name' => 'Test name',
            'description' => 'Test description',
            'type' => 'Test type',
            'category' => 'Test category',
            'price' => 100.99,
            'quantity' => 5,
            'manufacturer' => 'Test manufacturer',
            'distributor' => 'Test distributor',
        ]);

        $this->response->assertStatus(200);
        $this->response->assertJson(["message" => "Product updated",]);
        $this->seeInDatabase('products', ['name' => 'Test name']);

    }

    /**
     * Product can be deleted
     *
     * @return void
     */
    public function testCanDeleteProduct()
    {
        // seed a user
        $this->artisan('db:seed');
        $this->loginAs(null, 'admin');

        // get product
        $product = Product::first();

        $this->json('DELETE', 'api/v1/products/delete/' . $product->id);

        $this->response->assertStatus(200);
        $this->response->assertJson(["message" => "Product deleted",]);
        $this->assertTrue(Product::find($product->id) === null);

    }
}
