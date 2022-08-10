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
            "user" => ["id" => $this->user_id, "username" => $this->user->name],
            "save" => [
                "id" => $this->save_id,
                "name" => $this->safe->name,
                "tool" => new ToolResource($this->safe->tool)
            ],
            "permission" => $this->permission,
            "accepted" => $this->accepted,
            "declined" => $this->declined,
            "revoked" => $this->revoked
        ];
    }
}
