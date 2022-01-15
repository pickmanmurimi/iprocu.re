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
        /** @var Role $super_admin */
        $super_admin = Role::create(['name' => 'super-admin', 'description' => 'super admin']);
        /** @var Role $customer */
        $customer = Role::create(['name' => 'customer', 'description' => 'customer']);

        // =================================================================================
        // assign permissions
        // =================================================================================
        //  supper admin
        PermissionsService::assignPermissions($super_admin, $actions, 'users');
        PermissionsService::assignPermissions($super_admin, $actions, 'roles');
        PermissionsService::assignPermissions($super_admin, $actions, 'products');

        // customers
        PermissionsService::assignPermissions($customer, ['viewAny', 'view', 'create'], 'products');

    }
}


