<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class InvitationLinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "expiry_date" => $this->expiry_date,
            "permission" => $this->permission,
            "save_id" => $this->save_id,
            "created_at" => $this->created_at,
        ];
    }
}
