<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param string $token
     * @param string $username
     */
    public function __construct(string $token, string $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * password reset token
     * @var string
     */
    public $token;

    /**
     * Benutzername des Kontos
     * @var string
     */
    public $username;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('password-reset');
    }
}
