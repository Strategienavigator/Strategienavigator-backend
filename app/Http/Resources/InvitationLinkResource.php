<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Klasse, welche eine InvitationLink instanz in ein Array umwandelt
 */
class InvitationLinkResource extends JsonResource
{
    /**
     * Felder der InvitationLink instanz ohne das Token und updated_at Feld
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "expiry_date" => $this->expiry_date,
            "permission" => $this->permission,
            "save" => new SimplerSaveResource($this->safe),
            "created_at" => $this->created_at,
        ];
    }
}
