<?php

namespace App\Models;

use App\Traits\Limitable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @mixin \Eloquent
 * @property int $id identifikations nummber
 * @property mixed|null $extras optionale Datenfelder um typspezifische Daten zu speichern
 * @property string $type den Typ der Einstellung
 * @property string $description Eine Beschreibung der Einstellung
 * @property string $name name der Einstellung
 * @property string $default default value
 * @method static Builder|Setting whereDescription($value)
 * @method static Builder|Setting whereExtras($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereName($value)
 * @method static Builder|Setting whereType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 */
class Setting extends Model
{
    use HasFactory,Limitable;


    public $timestamps = false;


    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_settings');
    }

}
