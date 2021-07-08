<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tool
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tool newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tool newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tool query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tool whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tool whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tool whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tool whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Save[] $saves
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


    public function saves(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Save::class);
    }
}
