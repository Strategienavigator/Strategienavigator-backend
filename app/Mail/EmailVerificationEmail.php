<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token, string $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * token of the connected user verification
     * @var string
     */
    public $token;

    /**
     * username of the connected user account
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
        return $this->view('email-verification');
    }
}
