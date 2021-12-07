<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Kommando, welcher alle Anonymen user löscht, welche zu alt sind.
 *
 * Um festzulegen, nach welcher Zeit die User gelöscht werden sollen, muss die methode PurgeAnonymousUsersCommand::userPurgedBefore
 *
 * @see PurgeAnonymousUsersCommand::userPurgedBefore()
 */
class PurgeAnonymousUsersCommand extends Command
{
    /**
     * Name des Kommandos.
     *
     * @var string
     */
    protected $signature = 'purge:anonymous';

    /**
     * Beschreibung des Kommandos
     *
     * @var string
     */
    protected $description = 'Does delete all user database entries, which are anonymous and had no activity for a long time';

    /**
     * Setzt Zeitpunkt fest vor den inaktiven User gelöscht werden.
     *
     * @var Carbon
     */
    public static $purgedBefore;

    /**
     * Alle anonymen nutzer, welche vor dem übergebenen datum ihre letzte aktivität hatten, werden gelöscht
     * @param Carbon $date Muss in der vergangenheit liegen
     */
    public static function userPurgedBefore(Carbon $date)
    {
        if($date->isPast())
            static::$purgedBefore = $date;
    }

    /**
     * Gibt den Wert von $purgedBefore oder den Zeitpunkt vor einem Monat zurück
     * @see $purgedBefore
     * @return Carbon
     */
    public static function getUserPurgedBeforeTime(){
        return static::$purgedBefore?:Carbon::now()->subMonth();
    }

    /**
     * Führt das Kommando aus
     */
    public function handle()
    {
        $count = User::whereAnonymous(true)->where('last_activity', '<', static::getUserPurgedBeforeTime())->forceDelete();
        $this->output->success("Deleted " . $count . " rows!");
    }
}
