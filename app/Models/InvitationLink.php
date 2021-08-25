<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\InvitationLink
 *
 * @property int $id
 * @property Carbon $expiry_date
 * @property int $permission
 * @property int $save_id
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|InvitationLink newModelQuery()
 * @method static Builder|InvitationLink newQuery()
 * @method static Builder|InvitationLink query()
 * @method static Builder|InvitationLink whereCreatedAt($value)
 * @method static Builder|InvitationLink whereExpiryDate($value)
 * @method static Builder|InvitationLink whereId($value)
 * @method static Builder|InvitationLink wherePermission($value)
 * @method static Builder|InvitationLink whereSaveId($value)
 * @method static Builder|InvitationLink whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Save $safe
 * @method static Builder|InvitationLink whereToken($value)
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
     * @return BelongsTo
     */
    public function safe(): BelongsTo
    {
        return $this->belongsTo(Save::class, "save_id");
    }
}
