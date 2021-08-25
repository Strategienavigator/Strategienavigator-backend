<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property boolean $anonym
 * @property string $joined_at
 * @property string|null $last_activity
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder whereAnonym($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereJoinedAt($value)
 * @method static Builder|User whereLastLogin($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 * @property-read Collection|Save[] $accessibleShares
 * @property-read int|null $accessible_shares_count
 * @property-read EmailVerification|null $emailVerification
 * @property-read Collection|SharedSave[] $invitations
 * @property-read int|null $invitations_count
 * @property-read Collection|Save[] $invitedSaves
 * @property-read int|null $invited_saves_count
 * @property-read Collection|Save[] $isLocking
 * @property-read int|null $is_locking_count
 * @property-read Collection|Save[] $saves
 * @property-read int|null $saves_count
 * @property-read Collection|Client[] $clients
 * @property-read int|null $clients_count
 * @property-read Collection|Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User whereLastActivity($value)
 * @property-read Collection|SharedSave[] $sharedSaves
 * @property-read int|null $shared_saves_count
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'description'
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
     * @return User the user, could be an anonymous user or a normal one
     */
    public function findForPassport(string $username)
    {
        return $this->where('email', $username)->where('anonym', false)
            ->orWhere('username', $username)->where('anonym', true)
            ->first();
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
