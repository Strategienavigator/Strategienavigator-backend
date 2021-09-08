<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Passport\Token;

class AuthTokenPolicy
{
    use HandlesAuthorization;

    /**
     * Wenn der User der Eigentümer des Token ist, darf er ihn löschen
     *
     * @param User $user Der aktuell authentifizierte User
     * @param Token $token Der zu überprüfende User
     * @return bool Ob der User den Token löschen kann
     */
    public function delete(User $user, Token $token)
    {
        return $user->id === $token->user_id;
    }
}
