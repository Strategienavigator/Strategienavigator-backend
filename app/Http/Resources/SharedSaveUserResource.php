<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Klasse, welche eine Beziehung von einem Speicherstand zu einem User darstellt.
 *
 * Das übergebene Objekt muss ein save objekt mit einer geladenen Pivot Tabelle, welche ein permission attribute besitzt
 */
class SharedSaveUserResource extends JsonResource
{
    /**
     * Erstellt ein array mit save_id und permission Feld
     *
     * @param Request $request
     * @return array
     *
     * @see SharedSave
     */
    public function toArray($request)
    {
        return [
            "save" => new SimplerSaveResource($this->resource),
            $this->merge(new PermissionResource($this->pivot))
        ];
    }
}
