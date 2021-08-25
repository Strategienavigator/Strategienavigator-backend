<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmailVerification
 *
 * @property int $id id of the instance
 * @property string $email
 * @property string $token
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EmailVerification newModelQuery()
 * @method static Builder|EmailVerification newQuery()
 * @method static Builder|EmailVerification query()
 * @method static Builder|EmailVerification whereCreatedAt($value)
 * @method static Builder|EmailVerification whereEmail($value)
 * @method static Builder|EmailVerification whereId($value)
 * @method static Builder|EmailVerification whereUpdatedAt($value)
 * @method static Builder|EmailVerification whereUserId($value)
 * @mixin Eloquent
 * @property-read User $user
 * @method static Builder|EmailVerification whereToken($value)
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


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
