<?php

namespace App\Policies;

use App\Helper\PermissionHelper;
use App\Models\InvitationLink;
use App\Models\Save;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return boolean
     */
    public function viewAny(User $user):bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param InvitationLink $invitationLink
     * @return boolean
     */
    public function view(User $user, InvitationLink $invitationLink):bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return boolean
     */
    public function create(User $user, Save $save):bool
    {
        return !$user->anonym && $save->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param InvitationLink $invitationLink
     * @return boolean
     */
    public function update(User $user, InvitationLink $invitationLink):bool
    {
        return !$user->anonym && $invitationLink->safe->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param InvitationLink $invitationLink
     * @return boolean
     */
    public function delete(User $user, InvitationLink $invitationLink): bool
    {
        return !$user->anonym && $invitationLink->safe->hasAtLeasPermission($user,PermissionHelper::$PERMISSION_ADMIN);
    }
}
