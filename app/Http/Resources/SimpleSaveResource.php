<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "last_locked" => $this->last_locked,
            "owner_id" => $this->owner_id,
            "tool_id" => $this->tool_id,
            "contributors" => $this->contributors->map(function ($c) {
                return $c->id;
            })->toArray()
        ];
    }
}
