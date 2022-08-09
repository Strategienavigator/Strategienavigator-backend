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
            "user" => $this->user_id,
            "save" => [
                "id" => $this->save_id,
                "name"=>$this->safe->name,
                "tool"=>[
                    "id"=>$this->safe->tool->id,
                    "name"=>$this->safe->tool->name
                ]
            ],
            "permission" => $this->permission,
            "accepted" => $this->accepted,
            "declined" => $this->declined,
            "revoked" => $this->revoked
        ];
    }
}
