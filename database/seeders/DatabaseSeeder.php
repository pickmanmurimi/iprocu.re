<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesPermissionsSeeder::class);

        // seed users
        // creates 10 users
        User::factory()->hasProducts(3)->count(10)->create()->each(function ( User $user) {
            $user->roles()->syncWithoutDetaching( rand(1,2) );
        });
    }
}
