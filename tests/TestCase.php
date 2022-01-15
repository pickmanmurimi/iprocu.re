<?php

use App\Models\User;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    /**
     * Base login
     * Logs a user in
     * @param $user
     * @return User $user
     */
    protected function loginAs($user = null) : User
    {
        $user = $user ?? User::factory()->count(1)->create()->first();
        auth()->attempt(['email' => $user->email, 'password' => 'secret']);

        return $user;
    }
}
