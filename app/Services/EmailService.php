<?php


namespace App\Services;


use App\Mail\EmailVerificationEmail;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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

        $emailVerification->token = $this->tokenService->createToken();


        $user->emailVerification()->save($emailVerification);


        // is queued because of the ShouldQueue interface of EmailVerificationEmail
        Mail::to($emailVerification->email)->send(new EmailVerificationEmail($emailVerification->token,$user->username));
    }
}
