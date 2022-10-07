<?php

namespace App\Console\Commands;

use App\Models\Save;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Kommando, welcher alle Gelöschten Speicherstände löschen, welche zu alt sind.
 *
 * Um festzulegen, nach welcher Zeit die User gelöscht werden sollen, muss die methode PurgeDeletedSaves::savesPurgeBefore
 *
 * @see PurgeDeletedSaves::savesPurgeBefore()
 */
class PurgeDeletedSaves extends Command
{
    /**
     * Name des Kommandos.
     *
     * @var string
     */
    protected $signature = 'purge:saves';

    /**
     * Beschreibung des Kommandos
     *
     * @var string
     */
    protected $description = 'Does delete all save database entries, which are deleted and passed a speciefed time period';

    /**
     * Setzt Zeitpunkt fest vor den gelöschte Speicherstände vollständig gelöscht werden.
     *
     * @var Carbon
     */
    public static $purgedBefore;

    /**
     * Alle gelöschten Speicherstände, welche vor dem übergebenen Datum ihr Löschdatum hatten, werden gelöscht
     * @param Carbon $date Muss in der vergangenheit liegen
     */
    public static function savesPurgeBefore(Carbon $date)
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
        $count = Save::withTrashed()->where('deleted_at', '<', static::getUserPurgedBeforeTime())->forceDelete();
        $this->output->success("Deleted " . $count . " rows!");
    }
}
