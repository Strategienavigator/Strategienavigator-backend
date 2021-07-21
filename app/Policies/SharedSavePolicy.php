<?php

namespace App\Policies;

use App\Helper\PermissionHelper;
use App\Models\Save;
use App\Models\SharedSave;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharedSavePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return env("APP_DEBUG");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SharedSave  $sharedSave
     * @return mixed
     */
    public function view(User $user, SharedSave $sharedSave)
    {
        $save = $sharedSave->safe;
        return $save->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_READ);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Save $save)
    {
        return $save->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SharedSave  $sharedSave
     * @return mixed
     */
    public function update(User $user, SharedSave $sharedSave)
    {
        return $sharedSave->safe->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SharedSave  $sharedSave
     * @return mixed
     */
    public function delete(User $user, SharedSave $sharedSave)
    {
        return $sharedSave->safe->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SharedSave  $sharedSave
     * @return mixed
     */
    public function restore(User $user, SharedSave $sharedSave)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SharedSave  $sharedSave
     * @return mixed
     */
    public function forceDelete(User $user, SharedSave $sharedSave)
    {
        return false;
    }
}
