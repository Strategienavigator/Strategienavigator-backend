<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * Klasse, welche eine Tool instanz in ein Array umwandelt
 */
class ToolResource extends JsonResource
{
    /**
     * Wandelt Instanz in ein array um
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}
