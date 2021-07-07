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
            "email" => $this->when($request->user()->id === $this->id, $this->email),
            "created_at" => $this->created_at,
        ];
    }
}
