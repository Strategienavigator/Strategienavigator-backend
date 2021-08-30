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

    /** Erstellt einen neuen Anonymen User, ohne ihn in die Datenbank zu speichern
     * @param string $password Das neue Password des Users
     * @return User Der neue anonyme User
     * @throws \Exception Wenn keine Quelle von Zufall gefunden werden kann
     */
    public function createAnonymousUser(string $password): User
    {
        $u = new User();
        $u->anonymous = true;
        $u->password = $password;
        $u->last_activity = Carbon::now();
        do {
            $u->username = "anonymous" . random_int(1000, 1000000); // TODO maybe change username generation method (could end up in infinitive loop)
        } while (User::whereUsername($u->username)->exists());

        return $u;
    }


    /**
     * @param User $u the anonymous user which gets upgraded
     * @param array $data array with username, password and email fields
     * @param EmailService $emailService
     * @return bool Ob die funktion erfolgreich war.
     */
    public function upgradeAnonymousUser(User $u, array $data, EmailService $emailService): bool
    {
        if ($u->anonymous) {
            $u->anonymous = false;
            $u->fill($data);
            $u->password = $data["password"];
            $u->last_activity = Carbon::now();
            $emailService->requestEmailChangeOfUser($u, $data["email"]);
            $u->save();
            return true;
        }else{
            return false;
        }
    }

}
