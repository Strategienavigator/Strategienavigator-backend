<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Global Scope, welche bei jeder Datenbankabfrage die in dem Request definierte Order by Klausel hinzufügt
 *
 * kann wie folgt hinzugefügt werden:
 *
 * ```
 * protected static function booted()
 * {
 *     parent::booted();
 *     static::addGlobalScope(new CreatedAtSortingScope());
 * }
 * ```
 */
class SortingScope implements Scope
{

    /**
     * @var string Welche Spalte sortiert werden soll
     */
    private $column;

    /**
     * @param string $column definiert welche spalte sortiert werden soll, default = "created_at"
     */
    public function __construct(string $column = 'created_at')
    {
        $this->column = $column;
    }

    /**
     * Sortiert den aktuellen Request
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {

        if (Request::has('orderBy')) {
            $validator = \Validator::make(Request::input(), [
                "orderBy" => ['string', Rule::in(['ASC', 'DESC'])]
            ]);
            $validated = $validator->valid();
            if ($validator->passes()) {
                $orderBy = $validated['orderBy'];
                $builder->orderBy($this->column, $orderBy);
            }
        }

    }
}
