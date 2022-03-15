<?php


namespace App\Services;


use App\Mail\EmailVerificationEmail;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Methoden um die E-Mail-Adresse eines Users zu verwalten
 */
class EmailService
{


    private $tokenService;

    /**
     * Erstellt eine neue Instanz
     * @param TokenService $tokenService Dependency Injection
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /** Erstellt einen email_verification eintrag und schickt eine E-Mail an die angegebene E-Mail.
     * @param User $user Der betroffene User
     * @param string $email Die neue Email
     */
    public function requestEmailChangeOfUser(User $user, string $email)
    {
        $emailVerification = new EmailVerification();
        $emailVerification->email = $email;

        $emailVerification->token = $this->tokenService->createToken();


        $user->emailVerification()->save($emailVerification);


        // is queued because of the ShouldQueue interface of EmailVerificationEmail
        Mail::to($emailVerification->email)->send(new EmailVerificationEmail($emailVerification->token, $user->username));
    }

    /**
     *
     * Prüft die gegebene E-Mail und gibt an, ob sie durch die white oder blacklist verboten wird.
     *
     * @param string $email die zu prüfende email
     * @return bool true wenn die email erlaubt ist, sonst false
     */
    public function checkBlockLists(string $email): bool
    {
        $whitelist = config("accounts.email_whitelist");
        $blacklist = config("accounts.email_blacklist");
        foreach ($whitelist as $allowedRegex) {
            $result = preg_match($this->regexAddDelimiter($allowedRegex), $email);
            if ($result === false || $result === 0) {
                return false;
            }
        }

        foreach ($blacklist as $permittedRegex) {
            $result = preg_match($this->regexAddDelimiter($permittedRegex), $email);

            if ($result === 1) {
                return false;
            }
        }

        return true;
    }

    private function regexAddDelimiter(string $regex)
    {
        $needsDelimiter = !(str_starts_with($regex, "/") && str_ends_with($regex, "/"));

        return ($needsDelimiter ? "/" : "") . $regex . ($needsDelimiter ? "/" : "");
    }
}
