<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tool
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Tool newModelQuery()
 * @method static Builder|Tool newQuery()
 * @method static Builder|Tool query()
 * @method static Builder|Tool whereCreatedAt($value)
 * @method static Builder|Tool whereId($value)
 * @method static Builder|Tool whereName($value)
 * @method static Builder|Tool whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Save[] $saves
 * @property-read int|null $saves_count
 */
class Tool extends Model
{
    use HasFactory;

    /**
     * No value is mass assignable because toll data doesn't change and is read only
     *
     * @var array
     */
    protected $fillable = [
        "name"
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


    public function saves(): HasMany
    {
        return $this->hasMany(Save::class);
    }
}
