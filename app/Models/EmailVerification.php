<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailVerification
 *
 * @property int $id id of the instance
 * @property string $email
 * @property string $token
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailVerification whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class EmailVerification extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
}
