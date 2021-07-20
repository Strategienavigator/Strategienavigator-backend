<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PasswordReset
 * @property int $user_id
 * @property string $expiry_date
 * @property string $token
 * @property boolean $password_changed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @mixin \Eloquent
 */
class PasswordReset extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = "token";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expiry_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
