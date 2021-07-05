<?php

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToolPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Tool $tool
     * @return boolean
     */
    public function view(User $user, Tool $tool): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return boolean
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Tool $tool
     * @return boolean
     */
    public function update(User $user, Tool $tool): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Tool $tool
     * @return boolean
     */
    public function delete(User $user, Tool $tool): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Tool $tool
     * @return boolean
     */
    public function restore(User $user, Tool $tool): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Tool $tool
     * @return boolean
     */
    public function forceDelete(User $user, Tool $tool): bool
    {
        return false;
    }
}
