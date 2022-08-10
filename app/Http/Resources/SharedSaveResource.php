<?php

namespace App\Http\Resources;

use App\Models\SharedSave;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Klasse, welche eine SharedSave instanz in ein Array umwandelt
 */
class SharedSaveResource extends JsonResource
{
    /**
     * Felder der SharedSave instanz
     *
     * @param Request $request
     * @return array
     *
     * @see SharedSave
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => new SimplestUserResource($this->user),
            "save" => new SimplerSaveResource($this->safe),
            "permission" => $this->permission,
            "accepted" => $this->accepted,
            "declined" => $this->declined,
            "revoked" => $this->revoked
        ];
    }
}
