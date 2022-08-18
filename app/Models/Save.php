<?php

namespace App\Models;

use App\Helper\PermissionHelper;
use App\Models\Scopes\SortingScope;
use App\Traits\Limitable;
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
 * Speicherstand eines Tools
 *
 * @property int $id id des Speicherstandes
 * @property string $name Name des Speicherstandes
 * @property string|null $description Beschreibung des Speicherstandes
 * @property string|null $last_opened Zeitpunkt an dem der Speicherstand zum letzten Mal geöffnet wurde
 * @property mixed|null $data Daten des Tools
 * @property int $tool_id Id des zugehörigen Tools
 * @property int $owner_id Id des Users, welcher Eigentümer des Speicherstandes ist
 * @property int|null $locked_by_id Id des Users, welcher diesen Speicherstand aktuell bearbeitet
 * @property string|null $last_locked Zeitpunkt an dem das letzte Mal der Speicherstand gelockt wurde
 * @property Carbon|null $created_at Timestamp des Zeitpunktes der Erstellung
 * @property Carbon|null $updated_at Timestamp des Zeitpunktes der letzten Änderung
 * @property Carbon|null $deleted_at Timestamp des Zeitpunktes der Löschung
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
 * @property-read Collection|SharedSave[] $sharedSaves
 * @property-read int|null $shared_saves_count
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
 * @method static Builder|Save whereDeletedAt($value)
 * @method static Builder|Save whereName($value)
 * @method static Builder|Save whereDescription($value)
 * @method static SaveFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|Save withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Save withoutTrashed()
 * @method static \Illuminate\Database\Query\Builder|Save onlyTrashed()
 * @mixin Eloquent
 */
class Save extends Model
{
    use HasFactory, SoftDeletes, Limitable;

    /**
     * Attribute, welche Massen zuweisbar sind
     *
     * @var array
     */
    protected $fillable = [
        'data',
        'description',
        'name',
    ];

    /**
     * Zugehörigkeit, welche Attribute zu welchen nativen Typen gecastet werden soll.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'last_locked' => 'datetime',
        'last_opened' => 'datetime'
    ];

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new SortingScope());
    }


    /**
     * Beschreibt die Beziehung zu der users Tabelle zum Owner
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')->withTrashed();
    }

    /**
     * Beschreibt die Beziehung zu der users Tabelle zu dem User der den Speicherstand sperrt
     * @return BelongsTo
     */
    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by_id');
    }

    /**
     * Beschreibt die Beziehung zu dem Tool
     * @return BelongsTo
     */
    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    /**
     * Beschreibt die Beziehung zu der sharedSaves Tabelle
     * @return HasMany
     */
    public function sharedSaves(): HasMany
    {
        return $this->hasMany(SharedSave::class);
    }

    /**
     * Beschreibt die Beziehung zu den Mitwirkenden Usern, welche die Einladung noch nicht angenommen haben
     *
     * Von der Pivot Tabelle werden die permission, accepted, declined und revoked attribute geladen
     * @return BelongsToMany
     */
    public function invited(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission", "accepted", "declined", "revoked"])
            ->withPivotValue("accepted", false)
            ->withPivotValue("revoked", false)
            ->withTimestamps();
    }

    /**
     * Beschreibt die Beziehung zu den Einladungen, welche noch nicht angenommen wurden
     *
     * @return HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(SharedSave::class)
            ->where("accepted", '=', false);
    }

    /**
     * Beschreibt die Beziehung zu den Einladungslinks
     * @return HasMany
     */
    public function invitationLinks(): HasMany
    {
        return $this->hasMany(InvitationLink::class);
    }

    /**
     * Beschreibt die Beziehung zu den Mitwirkenden Usern, welche die Einladung bereits angenommen haben.
     *
     * Von der Pivot Tabelle werden die permission, accepted, declined und revoked attribute geladen
     * @return BelongsToMany
     */
    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_save')->using(SharedSave::class)
            ->withPivot(["permission", "accepted", "declined", "revoked"])
            ->withPivotValue("accepted", true)
            ->withPivotValue("declined", false)
            ->withPivotValue("revoked", false)
            ->withTimestamps();
    }

    public function isContributor(User|int $user)
    {
        $id = is_int($user) ? $user : $user->id;
        return $this->contributors->firstWhere('id', $id) !== null;
    }

    /**
     * Prüft, ob der übergebene User mindestens die angegebene Berechtigung bei diesem Speicherstand besitzt
     * @param User $user Der zu überprüfende User
     * @param int $permission Die zu überprüfende Berechtigung
     * @return bool Ob der User die Berechtigung besitzt
     */
    public function hasAtLeasPermission(User $user, int $permission)
    {
        if ($user->id === $this->owner_id) {
            return true;
        } else if (($contributor = $this->contributors->firstWhere('id', '=', $user->id)) !== null) {
            $hasPermission = $contributor->pivot->permission;
            if (PermissionHelper::isAtLeastPermission($hasPermission, $permission)) {
                return true;
            }
        }

        return false;
    }
}
