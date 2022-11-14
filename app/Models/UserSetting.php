<?php

namespace App\Models;

use App\Traits\Limitable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\UserSetting
 *
 * @property int $user_id id des Users
 * @property int $setting_id id der Einstellung
 * @method static Builder|UserSetting newModelQuery()
 * @method static Builder|UserSetting newQuery()
 * @method static Builder|UserSetting query()
 * @mixin \Eloquent
 * @property-read \App\Models\Setting $setting
 * @property-read \App\Models\User $user
 */
class UserSetting extends Pivot
{
    use Limitable;

    protected $table = "user_settings";
    public $timestamps = false;

    protected $fillable = [
        "value"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }
}
