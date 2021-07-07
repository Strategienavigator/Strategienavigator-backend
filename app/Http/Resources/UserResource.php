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
        return [
            "id" => $this->id,
            "username" => $this->username,
            "anonym" => $this->anonym,
            //"email" => $this->when($request->user()->id === $this->id, $this->email),
            "email" => $this->email,
            "created_at" => $this->created_at,
            "owned_saves"=>$this->saves->map(function($s){
                return $s->id;
            })->toArray(),
            "shared_saves" =>$this->accessibleShares->map(function($s){
                return $s->id;
            })->toArray(),
            /*"invitations" => $this->when($request->user()->id === $this->id,$this->invitations->map(function($inv){
                return $inv->id;
            })->toArray())*/
            "invitations" => $this->invitations->map(function($inv){
                return $inv->id;
            })->toArray()

        ];
    }
}
