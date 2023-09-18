<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SaveResource
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource query()
 * @mixin \Eloquent
 * @property int $id id of the save resource
 * @property int $save_id id of the associated save
 * @property string $file_name name of this file
 * @property string $file_type mime type of the file
 * @property mixed $contents binary data of the file
 * @property string $contents_hash hash value of the contents of the file
 * @property string $hash_functions hash function used to compute the hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Save|null $safe associated save
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereContentsHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereHashFunction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereSaveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveResource whereUpdatedAt($value)
 */
class SaveResource extends Model
{
    use HasFactory;


    /**
     * relation to the associated save
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function safe()
    {
        return $this->belongsTo(Save::class);
    }
}
