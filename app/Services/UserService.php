<?php

namespace App\Services;

use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;

/**
 * Methoden zum Verwalten von Usern
 */
class UserService
{

    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }


    /** Überprüft ob der Username bereits verwendet wird
     * @param string $username Der zu überprüfende Username
     * @return bool True, wenn der übergebene Benutzername noch nicht verwendet wird
     */
    public function checkUsername(string $username): bool
    {
        return !User::whereUsername($username)->exists();
    }

    /**
     * Überprüft ob die E-Mail bereits verwendet wird und ob sie von der white oder blacklist geblockt wird
     *
     * zu verifizierende E-Mail-Adressen gelten auch als verwendet
     * @param string $email Zu überprüfende E-Mail
     * @return bool True, wenn die E-Mail noch verfügbar ist
     */
    public function checkEmail(string $email): bool
    {
        return !(
                User::whereEmail($email)->exists() ||
                EmailVerification::whereEmail($email)->exists()
            );
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
     * Stuft ein anonymes Konto auf ein normales Konto hoch
     *
     * @param User $u das anonyme Konto, welches hoch gestuft wird
     * @param array $data array mit username, password und email einträge
     * @param EmailService $emailService der EmailService
     * @return bool Ob die funktion erfolgreich war.
     */
    public function upgradeAnonymousUser(User $u, array $data, EmailService $emailService): bool
    {
        if ($u->anonymous) {
            $u->anonymous = false;
            $u->fill($data);
            $u->password = $data["password"];
            $u->last_activity = Carbon::now();
            $u->created_at = Carbon::now();
            $emailService->requestEmailChangeOfUser($u, $data["email"]);
            $u->save();
            return true;
        } else {
            return false;
        }
    }

}
