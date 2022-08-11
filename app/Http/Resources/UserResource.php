<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Klasse, welche eine User instanz in ein Array umwandelt
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user();
        $isSameUser = $user->id === $this->id;
        return [
            "id" => $this->id,
            "username" => $this->username,
            "anonymous" => $this->anonymous,
            "email" => $this->when($isSameUser, $this->email),
            "created_at" => $this->created_at,
            "owned_saves" => $this->when($isSameUser, $this->saves->map(function ($s) {
                return new SimplerSaveResource($s);
            })->toArray()),
            "shared_saves" => $this->when($isSameUser, SharedSaveUserResource::collection($this->accessibleShares)),
            "invitations" => $this->when($isSameUser, SharedSaveUserResource::collection($this->invitedSaves))
            /*"invitations" => $this->invitations->map(function($inv){
                return $inv->id;
            })->toArray()*/

        ];
    }
}
