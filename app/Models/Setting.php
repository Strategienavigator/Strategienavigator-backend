<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 *
 * @mixin \Eloquent
 * @property int $id id der Einstellungen
 * @property mixed|null $extras
 * @property string $type
 * @property string $description
 * @property string $name
 * @method static Builder|Setting whereDescription($value)
 * @method static Builder|Setting whereExtras($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereName($value)
 * @method static Builder|Setting whereType($value)
 */
class Setting extends Model
{
    use HasFactory;


    public $timestamps = false;

}
