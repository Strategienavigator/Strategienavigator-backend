<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertUserCountEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var int Anzahl aller User
     */
    public $userCount;
    /**
     * @var int Anzahl aller User, welche ihr Account in der letzten Woche erstellt haben
     */
    public $userLastWeekCount;
    /**
     * @var int Anzahl aller Speicherstände
     */
    public $saveCount;
    /**
     * @var int Anzahl aller Speicherstände, welche innerhalb der letzten Woche erstellt wurde
     */
    public $saveLastWeekCount;
    /**
     * @var int Amount of characters saved as save data in the database.
     */
    public $saveCharacterCount;
    /**
     * @var int total amount of save resource blob size.
     */
    public $saveResourceSize;

    /**
     * Erstellt eine neue Instanz
     *
     * @param int $userCount Anzahl aller User
     * @param int $userLastWeekCount Anzahl aller User, welche ihr Account in der letzten Woche erstellt haben
     * @param int $saveCount Anzahl aller Speicherstände
     * @param int $saveLastWeekCount Anzahl aller Speicherstände, welche innerhalb der letzten Woche erstellt wurde
     */
    public function __construct(int $userCount, int $userLastWeekCount, int $saveCount, int $saveLastWeekCount, int $saveCharacterCount, int $saveResourceSize)
    {
        $this->userCount = $userCount;
        $this->userLastWeekCount = $userLastWeekCount;
        $this->saveCount = $saveCount;
        $this->saveLastWeekCount = $saveLastWeekCount;
        $this->saveCharacterCount = $saveCharacterCount;
        $this->saveResourceSize = $saveResourceSize;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user-count-alert');
    }
}
