<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * view
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('roles.viewAny');
    }

    /**
     * show
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('roles.view');
    }

    /**
     * update
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('roles.create');
    }

    /**
     * update
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function update(User $user, Role $role): bool
    {
        // cannot update admin role
        return $user->can('roles.update') && $role->name !== 'admin';
    }

    /**
     * destroy
     *
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function destroy(User $user, Role $role): bool
    {
        return $user->can('roles.destroy') && $role->name !== 'admin';
    }
}
