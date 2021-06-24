<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\SharedSave
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SharedSave query()
 * @mixin \Eloquent
 */
class SharedSave extends Pivot
{

    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission',
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

}
