<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Email Verifications Email.
 *
 * Zeigt den token und username in der Email an.
 * Die E-Mails werden immer gequeueed.
 */
class EmailVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @param string $token den token der EmailVerification instanz
     * @param string $username der Username des Users, bei dem die E-Mail bestätigt werden soll
     */
    public function __construct(string $token, string $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * den token der EmailVerification instanz
     * @var string
     */
    public $token;

    /**
     * Username des verknüpften Users Konto
     * @var string
     */
    public $username;

    /**
     * Erstellt die E-Mail
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email-verification')->subject("E-Mail Bestätigen");
    }
}
