<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user();
        $isSameUser = $user->id === $this->id;
        return [
            "id" => $this->id,
            "username" => $this->username,
            "anonym" => $this->anonym,
            "email" => $this->when($isSameUser, $this->email),
            "created_at" => $this->created_at,
            "owned_saves" => $this->when($isSameUser, $this->saves->map(function ($s) {
                return $s->id;
            })->toArray()),
            "shared_saves" => $this->when($isSameUser, SharedSaveUserResource::collection($this->accessibleShares)),
            "invitations" => $this->when($isSameUser, SharedSaveUserResource::collection($this->invitedSaves))
            /*"invitations" => $this->invitations->map(function($inv){
                return $inv->id;
            })->toArray()*/

        ];
    }
}
