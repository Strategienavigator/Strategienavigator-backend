<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvitationLink
 *
 * @property int $id
 * @property string $expiry_date
 * @property int $permission
 * @property int $save_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink whereSaveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Save $safe
 * @property string $token
 * @method static \Illuminate\Database\Eloquent\Builder|InvitationLink whereToken($value)
 */
class InvitationLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission',
        'expiry_date',
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
        'expiry_date' => 'datetime',
    ];

    /**
     * renamed because of function overloading
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function safe(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Save::class);
    }
}
