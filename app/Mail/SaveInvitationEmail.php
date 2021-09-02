<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * E-Mail, welche versand wird, wenn ein User einen anderen dazu einlädt an einem Speicherstand mitzuarbeiten
 * @package App\Mail
 */
class SaveInvitationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Url zu der Invitation Page im Frontend
     * @var string
     */
    public $fullUrl;
    /**
     * Name des Speicherstandes
     * @var string
     */
    public $saveName;
    /**
     * Nutzername des eingeladenen Nutzers
     * @var string
     */
    public $username;

    /**
     * Erstellt eine neue instanz
     *
     * @param string $username Username des eingeladenen Users
     * @param string $saveName Name des Speicherstandes
     * @param int $invitationId Id der SharedSave Instanz
     */
    public function __construct(string $username, string $saveName, int $invitationId)
    {
        $this->username = $username;
        $this->saveName = $saveName;
        $this->fullUrl = config('frontend.url') . '/' . config('frontend.invite_page'). '/' . $invitationId;
    }

    /**
     * Erstellt die Mail
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('save-invitation');
    }
}
