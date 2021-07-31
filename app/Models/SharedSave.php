<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\SharedSave
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave query()
 * @mixin \Eloquent
 * @property-read \App\Models\Save $safe
 * @property-read \App\Models\User $user
 * @property int $id
 * @property int $user_id
 * @property int $save_id
 * @property int $permission
 * @property int $accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereSaveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereUserId($value)
 * @property int $declined
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave whereDeclined($value)
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

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * renamed because of function overloading
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function safe(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Save::class, "save_id");
    }

}
