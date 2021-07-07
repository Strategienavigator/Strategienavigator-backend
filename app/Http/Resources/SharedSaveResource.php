<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SharedSaveResource extends JsonResource
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
            "user"=>$this->user_id,
            "save"=>$this->save_id,
            "permission"=>$this->permission,
        ];
    }
}
