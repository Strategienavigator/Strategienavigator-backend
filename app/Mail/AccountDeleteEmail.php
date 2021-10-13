<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * E-Mail, die den Nutzer darüber benachrichtigt, dass das Konto innerhalb kurzer Zeit gelöscht wird.
 */
class AccountDeleteEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Benutzername des Users
     * @var string
     */
    public $username;

    /**
     * Erstellt eine Instanz
     *
     * @return void
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * Erstellt die Nachricht
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('account-delete')->subject("Löschung deines Benutzerkontos");
    }
}
