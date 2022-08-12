<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Klasse, welche eine Save instanz in ein Array umwandelt.
 *
 * Es werden nur ids der Mitwirkenden angezeigt
 */
class SimpleSaveResource extends JsonResource
{
    /**
     * Erstellt ein Array aus mit den Attributen von dem Speicherstand
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "locked_by" => $this->locked_by_id,
            "name" => $this->name,
            "description" => $this->description,
            "last_locked" => $this->last_locked,
            "owner" => new SimplestUserResource($this->owner),
            "owner_deleting" => $this->owner->trashed(),
            "tool" => new ToolResource($this->tool),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
            "deleted_at" => $this->deleted_at,
            /*"contributors" => $this->contributors->map(function ($c) {
                return $c->id;
            })->toArray()*/
        ];
    }
}
