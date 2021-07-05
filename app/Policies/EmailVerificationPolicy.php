<?php

namespace App\Policies;

use App\Models\EmailVerification;
use App\Models\EmailVerificationLink;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailVerificationPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param EmailVerification $emailVerificationLink
     * @return boolean
     */
    public function viewboolean(User $user, EmailVerification $emailVerificationLink): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return boolean
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return boolean
     */
    public function update(User $user, EmailVerification $emailVerificationLink): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return boolean
     */
    public function delete(User $user, EmailVerification $emailVerificationLink): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return boolean
     */
    public function restore(User $user, EmailVerification $emailVerificationLink): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return boolean
     */
    public function forceDelete(User $user, EmailVerification $emailVerificationLink): bool
    {
        //
    }
}
