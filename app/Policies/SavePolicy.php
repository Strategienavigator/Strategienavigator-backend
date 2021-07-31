<?php

namespace App\Policies;

use App\Helper\PermissionHelper;
use App\Models\Save;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        return env('APP_DEBUG'); // TODO change to false
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Save $save
     * @return boolean
     */
    public function view(User $user, Save $save): bool
    {
        return $save->hasAtLeasPermission($user, PermissionHelper::$PERMISSION_READ);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return boolean
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Save $save
     * @return boolean
     */
    public function update(User $user, Save $save): bool
    {
        return $save->hasAtLeasPermission($user, PermissionHelper::$PERMISSION_WRITE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Save $save
     * @return boolean
     */
    public function delete(User $user, Save $save): bool
    {
        return $save->hasAtLeasPermission($user, PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Save $save
     * @return boolean
     */
    public function restore(User $user, Save $save): bool
    {
        //TODO
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Save $save
     * @return boolean
     */
    public function forceDelete(User $user, Save $save): bool
    {
        //TODO
        return false;
    }
}
