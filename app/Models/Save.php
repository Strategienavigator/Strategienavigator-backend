<?php

namespace App\Models;

use App\Helper\PermissionHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Save
 *
 * @property int $id
 * @property string $name
 * @property string|null $last_opened
 * @property mixed|null $data
 * @property int $tool_id
 * @property int $owner_id
 * @property int|null $locked_by_id
 * @property string|null $last_locked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Save newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Save newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Save query()
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereLastLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereLastOpened($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereLockedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereToolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $contributors
 * @property-read int|null $contributors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvitationLink[] $invitationLinks
 * @property-read int|null $invitation_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SharedSave[] $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $invited
 * @property-read int|null $invited_count
 * @property-read \App\Models\User|null $locker
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\Tool $tool
 * @method static \Illuminate\Database\Query\Builder|Save onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Save withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Save withoutTrashed()
 * @method static \Database\Factories\SaveFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereName($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SharedSave[] $sharedSaves
 * @property-read int|null $shared_saves_count
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Save whereDescription($value)
 */
class Save extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data',
        'name',
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
        'name' => "string",
        'last_locked' => 'datetime',
        'last_opened' => 'datetime'
    ];


    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function locker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by_id');
    }

    public function tool(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    public function sharedSaves(): HasMany
    {
        return $this->hasMany(SharedSave::class);
    }

    public function invited(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission", "accepted", "declined", "revoked"])
            ->withPivotValue("accepted", false)
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(SharedSave::class)
            ->where("accepted", '=', false);
    }

    public function invitationLinks(): HasMany
    {
        return $this->hasMany(InvitationLink::class);
    }

    /**
     * checks if the given user and save combination has at leas the given permission
     * @param User $user
     * @param Save $save
     */
    public function hasAtLeasPermission(User $user, int $permission)
    {
        if ($user->id === $this->owner_id) {
            return true;
        } else if (($contributor = $this->contributors()->firstWhere('user_id', '=', $user->id)) !== null) {
            $hasPermission = $contributor->pivot->permission;
            if (PermissionHelper::isAtLeastPermission($hasPermission, $permission)) {
                return true;
            }
        }

        return false;
    }

    public function contributors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission", "accepted", "declined", "revoked"])
            ->withPivotValue("accepted", true)
            ->withPivotValue("declined", false)
            ->withPivotValue("revoked", false)
            ->withTimestamps();
    }
}
