<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property boolean $anonym
 * @property string $joined_at
 * @property string|null $last_login
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Save[] $accessibleShares
 * @property-read int|null $accessible_shares_count
 * @property-read \App\Models\EmailVerification|null $emailVerification
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SharedSave[] $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Save[] $invitedSaves
 * @property-read int|null $invited_saves_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Save[] $isLocking
 * @property-read int|null $is_locking_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Save[] $saves
 * @property-read int|null $saves_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'last_login',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'anonym' => 'boolean'
    ];

    public function saves(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Save::class, 'owner_id');
    }

    public function isLocking(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Save::class, 'locked_by_id');
    }

    public function emailVerification(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(EmailVerification::class);
    }

    public function invitedSaves(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        //TODO check if withPivot must contain "accepted" to make withPivotValue work
        return $this->belongsToMany(Save::class, 'invite')->using(SharedSave::class)->as("invitation")
            ->withPivot(["permission","accepted"])
            ->withPivotValue("accepted",false)
            ->withTimestamps();
    }

    public function invitations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SharedSave::class)->where('accepted','=',true);
    }

    public function accessibleShares(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        //TODO check if withPivot must contain "accepted" to make withPivotValue work
        return $this->belongsToMany(Save::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission","accepted"])
            ->withPivotValue("accepted",true)
            ->withTimestamps();
    }


}
