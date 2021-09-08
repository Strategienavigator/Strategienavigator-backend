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
        Mail::to($emailVerification->email)->send(new EmailVerificationEmail($emailVerification->token,$user->username));
    }
}
