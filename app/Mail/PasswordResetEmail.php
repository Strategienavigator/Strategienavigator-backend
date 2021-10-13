<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Passwort Reset E-Mail
 *
 * Enthält den Token des Passwort Resets und den Benutzernamen.
 * Wird immer gequeued
 */
class PasswordResetEmail extends Mailable
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
     * Token des Passwort Resets
     * @var string
     */
    public $token;

    /**
     * Benutzername des Kontos
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
        return $this->view('password-reset')->subject("Passwort vergessen");
    }
}
