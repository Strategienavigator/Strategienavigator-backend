<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Modell um eine Passwort Reset Anfrage zu speichern
 *
 * @property int $user_id user id des verknüpften Users
 * @property Carbon $expiry_date Timestamp an dem der Passwort Reset ablauft
 * @property string $token Token des Passwort Resets (Primary Key)
 * @property boolean $password_changed Ob das Passwort bereits geändert wurde
 * @property Carbon|null $created_at Timestamp des Zeitpunktes der Erstellung
 * @property Carbon|null $password_changed_at Timestamp des Zeitpunktes der letzten Änderung
 * @property-read User $user verknüpfte User
 * @mixin Eloquent
 * @method static Builder|PasswordReset newModelQuery()
 * @method static Builder|PasswordReset newQuery()
 * @method static Builder|PasswordReset query()
 * @method static Builder|PasswordReset whereCreatedAt($value)
 * @method static Builder|PasswordReset whereExpiryDate($value)
 * @method static Builder|PasswordReset wherePasswordChanged($value)
 * @method static Builder|PasswordReset wherePasswordChangedAt($value)
 * @method static Builder|PasswordReset whereToken($value)
 * @method static Builder|PasswordReset whereUserId($value)
 */
class PasswordReset extends Model
{
    use HasFactory;

    /**
     * Das Model hat keine timestamps
     * @var bool
     */
    public $timestamps = false;
    /**
     * Primary Key zählt nicht automatisch hoch
     * @var bool
     */
    public $incrementing = false;
    /**
     * Primary Key ist ein string
     * @var string
     */
    protected $keyType = 'string';
    /**
     * Die Primary Key Spalte ist "token"
     * @var string
     */
    protected $primaryKey = "token";

    /**
     * Attribute, welche Massen zuweisbar sind
     *
     * @var array
     */
    protected $fillable = [
        'expiry_date',
    ];

    /**
     * Attribute, welche Massen zuweisbar sind
     *
     * @var array
     */
    protected $casts = [
        'password_changed' => 'boolean',
        'token'=>'string'
    ];

    /**
     * Beschreibt die Beziehung zu der users Tabelle
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
