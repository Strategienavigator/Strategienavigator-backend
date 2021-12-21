<?php

namespace App\Services;

use App\Models\Save;
use Carbon\Carbon;

class SaveService
{

    /**
     * @var Carbon
     */
    private static $_unlock_since;

    /**
     * Ändert den unlock_since wert, gibt den neuen Wert zurück. Kann als getter dienen, wenn kein argument übergeben wird
     * @param Carbon|null $time neuer unlock_since Wert
     * @return Carbon
     */
    public static function unlock_since(Carbon $time = null)
    {
        if (!is_null($time)) {
            SaveService::$_unlock_since = $time;
        }
        return SaveService::$_unlock_since;
    }

    /**
     * Prüft, wann der Speicherstand zuletzt bearbeitet wurde, falls das zu lange her ist wird der lock status entfernt
     * @param Save $save Der Speicherstand, welcher überprüft werden soll
     * @return void
     */
    public function fix_locked_by(Save $save)
    {
        $last_locked = $save->last_locked;
        $locked_by = $save->locked_by_id;
        $last_edited = $save->updated_at;
        if ($last_locked < SaveService::unlock_since() and $last_edited < SaveService::unlock_since()) {
            $save->locked_by_id = null;
        }
    }

}
