<?php

namespace App\Models;

use App\Helper\PermissionHelper;
use Database\Factories\SaveFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Save newModelQuery()
 * @method static Builder|Save newQuery()
 * @method static Builder|Save query()
 * @method static Builder|Save whereCreatedAt($value)
 * @method static Builder|Save whereData($value)
 * @method static Builder|Save whereId($value)
 * @method static Builder|Save whereLastLocked($value)
 * @method static Builder|Save whereLastOpened($value)
 * @method static Builder|Save whereLockedById($value)
 * @method static Builder|Save whereOwnerId($value)
 * @method static Builder|Save whereToolId($value)
 * @method static Builder|Save whereUpdatedAt($value)
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @property-read Collection|User[] $contributors
 * @property-read int|null $contributors_count
 * @property-read Collection|InvitationLink[] $invitationLinks
 * @property-read int|null $invitation_links_count
 * @property-read Collection|SharedSave[] $invitations
 * @property-read int|null $invitations_count
 * @property-read Collection|User[] $invited
 * @property-read int|null $invited_count
 * @property-read User|null $locker
 * @property-read User $owner
 * @property-read Tool $tool
 * @method static \Illuminate\Database\Query\Builder|Save onlyTrashed()
 * @method static Builder|Save whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Save withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Save withoutTrashed()
 * @method static SaveFactory factory(...$parameters)
 * @method static Builder|Save whereName($value)
 * @property-read Collection|SharedSave[] $sharedSaves
 * @property-read int|null $shared_saves_count
 * @property string|null $description
 * @method static Builder|Save whereDescription($value)
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


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by_id');
    }

    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    public function sharedSaves(): HasMany
    {
        return $this->hasMany(SharedSave::class);
    }

    public function invited(): BelongsToMany
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

    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission", "accepted", "declined", "revoked"])
            ->withPivotValue("accepted", true)
            ->withPivotValue("declined", false)
            ->withPivotValue("revoked", false)
            ->withTimestamps();
    }
}
