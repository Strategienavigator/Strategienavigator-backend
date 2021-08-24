<?php

namespace App\Services;

use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;

class UserService
{


    public function checkUsername(string $username): bool
    {
        return !User::whereUsername($username)->exists();
    }

    public function checkEmail(string $email): bool
    {
        return !(User::whereEmail($email)->exists() ||
            EmailVerification::whereEmail($email)->exists());
    }

    /**
     * Ändert die Daten der Felder des übergebenen User-Objekts.
     *
     * Wenn es einen "email" Eintrag in dem $data array gibt, wird eine confirmation "email" verschickt.
     *
     * @param User $u a user model
     * @param array $data array with the new data
     * @param EmailService $emailService the email service
     */
    public function updateUser(User $u, array $data, EmailService $emailService)
    {

        $u->fill($data);
        if (is_null($u->last_activity))
            $u->last_activity = Carbon::now();
        if (key_exists("password", $data)) {
            $u->password = $data["password"];
        }

        $u->save();
        if (key_exists("email", $data)) {
            $emailService->requestEmailChangeOfUser($u, $data["email"]);
        }
    }

}
