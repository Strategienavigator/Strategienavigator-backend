<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewMany(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param UserSetting $userSetting
     * @return mixed
     */
    public function view(User $user, UserSetting $userSetting)
    {
        return $user->id === $userSetting->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user, User $model): bool
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param UserSetting $userSetting
     * @return bool
     */
    public function update(User $user, UserSetting $userSetting): bool
    {
        return $user->id === $userSetting->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param UserSetting $userSetting
     * @return bool
     */
    public function delete(User $user, User $m): bool
    {
        return $user->id = $m->id;
    }
}
