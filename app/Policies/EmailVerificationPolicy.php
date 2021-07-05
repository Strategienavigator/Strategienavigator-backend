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
     * @param EmailVerification $emailVerificationLink
     * @return mixed
     */
    public function view(User $user, EmailVerification $emailVerificationLink)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return mixed
     */
    public function update(User $user, EmailVerification $emailVerificationLink)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return mixed
     */
    public function delete(User $user, EmailVerification $emailVerificationLink)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return mixed
     */
    public function restore(User $user, EmailVerification $emailVerificationLink)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  EmailVerification  $emailVerificationLink
     * @return mixed
     */
    public function forceDelete(User $user, EmailVerification $emailVerificationLink)
    {
        //
    }
}
