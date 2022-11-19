<?php
namespace App\Broadcasting;
use App\Http\Resources\SimplestUserResource;
use App\Models\Save;
use App\Models\User;

class SaveChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param Save $save
     * @return SimplestUserResource | bool
     */
    public function join(User $user, Save $save): SimplestUserResource | bool
    {
        if (
            $save &&
            (
                $save->isContributor($user) ||
                $save->owner->is($user)
            )
        ) {
            return new SimplestUserResource($user);
        }
        return false;
    }
}
