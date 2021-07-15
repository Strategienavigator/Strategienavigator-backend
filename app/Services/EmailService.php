<?php


namespace App\Services;


use App\Models\EmailVerification;
use App\Models\User;

class EmailService
{

    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /** Does create a new email validation entry and sends an email with a token.
     * @param User $user the user which is affected
     * @param string $email the new email
     */
    public function requestEmailChangeOfUser(User $user, string $email)
    {
        $emailVerification = new EmailVerification();
        $emailVerification->email = $email;

        // TODO create token and send email to user
        // $emailVerification->token = $this->tokenService->getToken();
        $user->emailVerification()->save($emailVerification);
    }
}
