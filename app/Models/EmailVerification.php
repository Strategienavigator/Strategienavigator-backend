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
 * @property int $id id des Datenbank eintrags
 * @property string $email unverifizierte E-Mail des Users
 * @property string $token token welcher zum verifizieren verwendet wird
 * @property int $user_id id des Users
 * @property Carbon|null $created_at Timestamp des Zeitpunktes der Erstellung
 * @property Carbon|null $updated_at Timestamp des Zeitpunktes der letzten Änderung
 * @property-read User $user Der verknüpfte User
 * @method static Builder|EmailVerification newModelQuery()
 * @method static Builder|EmailVerification newQuery()
 * @method static Builder|EmailVerification query()
 * @method static Builder|EmailVerification whereCreatedAt($value)
 * @method static Builder|EmailVerification whereEmail($value)
 * @method static Builder|EmailVerification whereId($value)
 * @method static Builder|EmailVerification whereUpdatedAt($value)
 * @method static Builder|EmailVerification whereUserId($value)
 * @method static Builder|EmailVerification whereToken($value)
 * @mixin Eloquent
 */
class EmailVerification extends Model
{
    use HasFactory;


    /**
     * Beschreibt die Beziehung zur users Tabelle
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
