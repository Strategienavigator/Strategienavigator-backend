<?php

namespace App\Policies;

use App\Helper\PermissionHelper;
use App\Models\Save;
use App\Models\SharedSave;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Save $save
     * @return mixed
     */
    public function view(User $user, Save $save)
    {
        return $this->hasAtLeasPermission($user,$save,PermissionHelper::$PERMISSION_READ);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Save $save
     * @return mixed
     */
    public function update(User $user, Save $save)
    {
        return $this->hasAtLeasPermission($user,$save,PermissionHelper::$PERMISSION_WRITE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Save $save
     * @return mixed
     */
    public function delete(User $user, Save $save)
    {
        //
    }

    /**
     * checks if the given user and save combination has at leas the given permission
     * @param User $user
     * @param Save $save
     */
    private function hasAtLeasPermission(User $user, Save $save, int $permission){
        if ($user->id === $save->owner_id) {
            return true;
        } else if (($contributor = $save->contributors()->firstWhere('user_id', '=', $user->id)) !== null) {
            $hasPermission = $contributor->pivot->permission;
            if(PermissionHelper::isAtLeastPermission($hasPermission, $permission)){
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Save $save
     * @return mixed
     */
    public function restore(User $user, Save $save)
    {
        //TODO
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Save $save
     * @return mixed
     */
    public function forceDelete(User $user, Save $save)
    {
        //TODO
        return false;
    }
}
