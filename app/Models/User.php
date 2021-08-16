<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property boolean $anonym
 * @property string $joined_at
 * @property string|null $last_activity
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActivity($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SharedSave[] $sharedSaves
 * @property-read int|null $shared_saves_count
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
        'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'last_activity',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity' => 'datetime',
        'anonym' => 'boolean'
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param string $username
     * @return User
     */
    public function findForPassport(string $username): User
    {
        $u = $this->where('email', $username)->first();
        if(is_null($u)){
            $u = $this->where('username', $username)->where('anonym', true)->first();
        }
        return $u;
    }


    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(Save::class, 'owner_id');
    }

    public function isLocking(): HasMany
    {
        return $this->hasMany(Save::class, 'locked_by_id');
    }

    public function emailVerification(): HasOne
    {
        return $this->hasOne(EmailVerification::class);
    }

    public function invitedSaves(): BelongsToMany
    {
        return $this->belongsToMany(Save::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission"])
            ->withPivotValue("accepted", false)
            ->withPivotValue("declined", false)
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(SharedSave::class)
            ->where('accepted', '=', false)
            ->where('declined', '=', false);
    }

    public function sharedSaves(): HasMany
    {
        return $this->hasMany(SharedSave::class);
    }

    public function accessibleShares(): BelongsToMany
    {
        return $this->belongsToMany(Save::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission"])
            ->withPivotValue("accepted", true)
            ->withPivotValue("declined", false)
            ->withTimestamps();
    }


}
