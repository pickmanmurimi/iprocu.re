<?php

use App\Models\Role;
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
     * @param User|null $user
     * @param string|null $role
     * @return User $user
     */
    protected function loginAs(User $user = null, string $role = null): User
    {
        /** @var User $user */
        $user = $user ?? User::factory()->count(1)->create()->first();
        // set the role
        if ($role) $user->roles()->sync(Role::whereName($role)->first());

        auth()->attempt(['email' => $user->email, 'password' => 'secret']);

        return $user;
    }
}
