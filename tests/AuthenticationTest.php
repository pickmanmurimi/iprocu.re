<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->json('GET','api/v1/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}
