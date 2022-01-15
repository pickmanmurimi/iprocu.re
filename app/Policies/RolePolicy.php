<?php

namespace App\Policies;

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
        return $user->can('role.viewAny');
    }

    /**
     * show
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('role.view');
    }

    /**
     * update
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('role.create');
    }

    /**
     * update
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('role.update');
    }

    /**
     * deactivate
     *
     * @param User $user
     * @return bool
     */
    public function deactivate(User $user): bool
    {
        return $user->can('role.deactivate');
    }

    /**
     * destroy
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user): bool
    {
        return $user->can('role.destroy');
    }
}
