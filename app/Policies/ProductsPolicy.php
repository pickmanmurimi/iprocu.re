<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductsPolicy
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
        return $user->can('products.viewAny');
    }

    /**
     * show
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('products.view');
    }

    /**
     * update
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('products.create');
    }

    /**
     * update
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('products.update');
    }

    /**
     * deactivate
     *
     * @param User $user
     * @return bool
     */
    public function deactivate(User $user): bool
    {
        return $user->can('products.deactivate');
    }

    /**
     * destroy
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user): bool
    {
        return $user->can('products.destroy');
    }
}
