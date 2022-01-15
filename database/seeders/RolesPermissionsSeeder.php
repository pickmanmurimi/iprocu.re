<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Services\PermissionsService;
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // the crud operations
        $actions = ['create', 'viewAny', 'view', 'destroy', 'update'];

        // =================================================================================
        // create permissions
        // =================================================================================
        PermissionsService::createPermissions($actions, 'users');
        PermissionsService::createPermissions($actions, 'roles');
        PermissionsService::createPermissions($actions, 'products');

        // =================================================================================
        // Create Roles
        // =================================================================================
        /** @var Role $admin */
        $admin = Role::create(['name' => 'admin', 'description' => 'super admin']);
        /** @var Role $customer */
        $customer = Role::create(['name' => 'customer', 'description' => 'customer']);

        // =================================================================================
        // assign permissions
        // =================================================================================
        //  supper admin
        PermissionsService::assignPermissions($admin, $actions, 'users');
        PermissionsService::assignPermissions($admin, $actions, 'roles');
        PermissionsService::assignPermissions($admin, $actions, 'products');

        // customers
        PermissionsService::assignPermissions($customer, ['viewAny', 'view', 'create'], 'products');

    }
}


