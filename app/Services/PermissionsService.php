<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;

class PermissionsService
{
    /**
     * @param $actions
     * @param $scope
     * @return void
     */
    public static function createPermissions( array $actions, $scope )
    {
        foreach( $actions as $action )
        {
            Permission::create( [ 'name' => $scope . '.' . $action ] );
        }
    }

    /**
     * @param Role $role
     * @param array $actions
     * @param string $scope
     * @return void
     */
    public static function assignPermissions( Role $role, array $actions, string $scope)
    {
        foreach( $actions as $action ) {
            $permission = Permission::whereName(  $scope . '.' . $action )->firstOrFail();
            $role->permissions()->syncWithoutDetaching( $permission );
        }
    }
}
