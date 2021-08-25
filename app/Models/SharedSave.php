<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\SharedSave
 *
 * @method static Builder|SharedSave newModelQuery()
 * @method static Builder|SharedSave newQuery()
 * @method static Builder|SharedSave query()
 * @mixin Eloquent
 * @property-read Save $safe
 * @property-read User $user
 * @property int $id
 * @property int $user_id
 * @property int $save_id
 * @property int $permission
 * @property int $accepted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SharedSave whereAccepted($value)
 * @method static Builder|SharedSave whereCreatedAt($value)
 * @method static Builder|SharedSave whereId($value)
 * @method static Builder|SharedSave wherePermission($value)
 * @method static Builder|SharedSave whereSaveId($value)
 * @method static Builder|SharedSave whereUpdatedAt($value)
 * @method static Builder|SharedSave whereUserId($value)
 * @property int $declined
 * @method static Builder|SharedSave whereDeclined($value)
 * @property int $revoked
 * @method static Builder|SharedSave whereRevoked($value)
 */
class SharedSave extends Pivot
{

    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission',
        'revoked'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * renamed because of function overloading
     * @return BelongsTo
     */
    public function safe(): BelongsTo
    {
        return $this->belongsTo(Save::class, "save_id");
    }

}
